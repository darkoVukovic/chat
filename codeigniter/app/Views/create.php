<?php 
echo form_open(site_url().'admin/create');
echo form_label('name of navigation', 'navigationName');
echo form_input(['name' => 'navigationName']);
echo form_submit('submitNavigation', 'save');
?>