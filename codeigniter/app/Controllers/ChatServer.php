<?php namespace App\Controllers;

    require '../../vendor/autoload.php';

    use Ratchet\MessageComponentInterface;
    use Ratchet\ConnectionInterface;
    use Ratchet\Server\IoServer;
    use Ratchet\Http\HttpServer;
    use Ratchet\WebSocket\WsServer;
    use App\Controllers\ChatConnection;
    
class ChatServer  {

    public function index() {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new ChatConnection()
                )
            ),
          9000
        );
    
        $server->run();
    }
}


$server = new ChatServer();
$server->index();
  
?>