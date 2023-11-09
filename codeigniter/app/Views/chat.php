<div id="chatBox"></div>
<div id='chatInputDiv'>
<label for="chatText">chat here</label>
<input type="text" name='chatText' id='chatText'>
<button id='sendMsg'>send</button>

<div id='userCoutn'>
    <p>active users: </p>
</div>
</div>
<style>
    #chatBox {
        max-width: 400px;
        height: 80%;
        background-color: #fff;
        overflow-y: scroll;
    }
    
    #chatInputDiv {
        margin-top: 20px;
        color: #fff;
    }

    #chatInputDiv input {
        height: 35px;
        border-radius: 14px;
    }

</style>

<script src='<?= site_url()?>css/chat.js'> </script>