<?php namespace App\Controllers;

use App\Libraries\Errors;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


class ChatConnection implements MessageComponentInterface {
    protected $clients;
    public $pk;
    public $username;
    public $msgId = 0;
    public $redisClient;
    public $currentUsers = 0;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->redisClient = new \App\Libraries\RedisService;
        echo "SERVER RUNNING..." .PHP_EOL;

    }

    public function onOpen(ConnectionInterface $conn) {
        $this->currentUsers++;
        $params = $conn->httpRequest->getUri()->getQuery(); 
        $params = explode('=', $params);
        $pk = $params[1];
        $conn->pk = $pk;
        // zasto api ako mogu posaljem poruku odavde 
        $this->redisClient->addUserCount($this->currentUsers);
        $conn->username = $this->redisClient->getUsername($pk);   
        if(is_null($conn->username)) {
            $conn->close();
            return;
        }

        $this->clients->attach($conn);
        foreach($this->clients as $client) {
            $msgData['userConnectedNotify'] = true;
            $msgData['username'] = 'Notify-bot';
            $msgData['msg'] = $conn->username.' Connected to chat ';
            $this->msgId++;
            $msgData['msgId'] = $this->msgId;
            $msgData['usersCount'] = $this->currentUsers;
            $client->send(json_encode($msgData));
        }

        echo $conn->username ." CONNECTED TO ROOM".PHP_EOL;

    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $msgData = JSON_decode($msg);
        if(is_null($msgData)) {
            
            $this->clients->detach($from);

        }

        $msgData->username = $from->username;
        $this->msgId++;
        $msgData->msgId = $this->msgId;
        foreach ($this->clients as $client) {
            if($client->username == $from->username) $msgData->self = true;
            else {
                $msgData->self = false;
            }
            $client->send(JSON_encode($msgData));
        }

        echo $msgData->username. ' sends message '. $msgData->msg.PHP_EOL;
    }

    public function onClose(ConnectionInterface $conn) {
        echo "user: ".$conn->username. " left chat room".PHP_EOL;

        $this->clients->detach($conn);
        $this->currentUsers--;
        $this->redisClient->changeUserStatus($conn->pk, 0);
        foreach ($this->clients as $client) {
            $msgData['userConnectedNotify'] = true;
            $msgData['username'] = 'Notify-bot';
            $msgData['msg'] = $conn->username.' disconnected from chat ';
            $this->msgId++;
            $msgData['msgId'] = $this->msgId;
            $msgData['usersCount'] = $this->currentUsers;

            $client->send(JSON_encode($msgData));
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
        echo "ERROR".PHP_EOL;
    }
}