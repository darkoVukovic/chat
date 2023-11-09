document.addEventListener('DOMContentLoaded', function (event) {
let uri = window.location.href;
breakUri = uri.split('/');
id = breakUri.pop(-1);
       var conn = new WebSocket('ws://chat:5001?pk='+id);

       conn.onerror=function(event){
           webServerConnectionError();
       }
       conn.onmessage = function(e) { 
           
           let msgData  = JSON.parse(e.data);
           let chatBox = document.querySelector('#chatBox');
           var chatMsg = document.createElement('div');
           if(msgData.userConnectedNotify) {
               chatMessagePosition = 'chatMsgBot';
           }
           else {
               (msgData.self ? chatMessagePosition = 'chatMsgSelf' : chatMessagePosition = 'chatMsg');
           }

           chatBox.innerHTML += "<div class='"+chatMessagePosition+"' id='msgNum_"+msgData.msgId+"' ><span>"+msgData.username+" : "+msgData.msg+"</span></div>";
           scrollToMessage(msgData.msgId);     
       };
       
       conn.onopen = function(e) {
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
                   pk: '1234'
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

}, false);


