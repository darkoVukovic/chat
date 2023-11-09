document.addEventListener('DOMContentLoaded', function (event) {
let uri = window.location.href;
breakUri = uri.split('/');
id = breakUri.pop(-1);
       var conn = new WebSocket('ws://chat:9000?pk='+id);

       conn.onerror=function(event){
           webServerConnectionError();
           console.log(event);
       }
       conn.onmessage = function(e) { 
        let totaluserDiv = document.querySelector('#userCoutn');

           let msgData  = JSON.parse(e.data);
           let chatBox = document.querySelector('#chatBox');
           var chatMsg = document.createElement('div');
           if(msgData.userConnectedNotify) {
               chatMessagePosition = 'chatMsgBot';
               totaluserDiv.innerHTML = 'active users:'+ msgData.usersCount
           }
           else {
               (msgData.self ? chatMessagePosition = 'chatMsgSelf' : chatMessagePosition = 'chatMsg');
           }

           chatBox.innerHTML += "<div class='"+chatMessagePosition+"' id='msgNum_"+msgData.msgId+"' ><span>"+msgData.username+" : "+msgData.msg+"</span></div>";
           scrollToMessage(msgData.msgId);     
       
       };
       
       conn.onopen = function(e) {
            console.log(e);
       }
       
       let sendBtn = document.querySelector('#sendMsg');
       let chatText = document.querySelector('#chatText');
       
       chatText.addEventListener('keyup', (event) => {
           if (event.keyCode === 13) {
               sendMsg(conn)
           }
       
       })
       
       sendBtn.addEventListener('click', function() {
           sendMsg(conn);
       })
       
       function sendMsg() {
               let text = chatText.value;
               let msg = {
                   msg: text,
                   pk: id
               }
               if(msg.msg != '')
               conn.send(JSON.stringify(msg));     
               
               let chatEleme = document.querySelector('#chatText');
               emptyElemValue(chatEleme);
       }
       
       
       function emptyElemValue(elem) {
           elem.value = '';
       }
       
   
   
   function scrollToMessage(msgId) {
      let msgDiv = document.querySelector('#msgNum_'+msgId);
      msgDiv.scrollIntoView();
   }


   function webServerConnectionError() {
       let chatBox = document.querySelector('#chatBox');
       chatBox.innerHTML = 'Connection to chat failed..';
   }

/*
    const apiUrl = 'http://chat/api/v1/getUserCount';

// Use the fetch function to make the GET request

        fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
            throw new Error('Network response was not ok');
            }
            return response.json(); // Parse the response as JSON
        })
        .then(data => {
            totaluserDiv.innerHTML += data;
        })
        .catch(error => {
            // Handle any errors that occurred during the fetch
            console.error('Fetch error:', error);
        });
        */
}, false);


