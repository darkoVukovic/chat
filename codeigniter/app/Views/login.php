<?php 
echo form_open('login');?>

<input type="text" name='username' placeholder="username">
<input type="password" name='password' placeholder="password">

<?php
echo form_submit('submitLogin', 'save');
?>