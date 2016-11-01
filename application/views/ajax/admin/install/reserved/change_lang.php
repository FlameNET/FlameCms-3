<?php
defined('FlameCMS') or die('No Script Cuddies');
$sys=&get_inst();
if($sys->input->is_ajax_request())
{
	$lang=$_POST['lang'];
	$sys->ilang->set_installer_lang($lang);
}
else{
	die('Ups...');
}
