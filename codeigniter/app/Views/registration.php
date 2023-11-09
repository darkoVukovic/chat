<?php 
echo form_open('registration'); ?>

<input type="text" name='username' placeholder="username">
<input type="password" name='password' placeholder="password">
<input type="email" name='email' placeholder="'email">
<?php
echo form_submit('submitLogin', 'save');
?>