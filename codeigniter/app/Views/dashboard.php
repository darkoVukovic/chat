
<aside>
<ul id='navgiationUl'>
<?php 
if(isset($navigation)) {
    foreach($navigation as $item) : ?>
        <li><a href="<?= site_url().$item?>"><?= $item?></a></li>    
    <?php endforeach ;
}
?>
</ul>
</aside>
