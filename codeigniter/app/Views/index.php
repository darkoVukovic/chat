<?php 
echo view('basic/header'); ?>
<div style='display:flex'> <?php
    if($view != 'dashboard') echo view('dashboard');?>
    <div id='content'>
        <?= view($view);?>
    </div>
</div>
<?php
echo view('basic/footer');

?>