<?php
defined('FlameCMS') or die('No Script Cuddies');
$sys=&get_inst();

if($sys->input->is_ajax_request())
{
	$data=array();
	$data=array_merge($data,$_POST);
	if($data['step']=='step-1'){
		define('ajaxload',true);
		$sys->page->load('ajax/admin/install/reserved/step2');
	}
	elseif($data['step']=='step-2'){
		define('ajaxload',true);
		$sys->page->load('ajax/admin/install/reserved/step3');
	}
	elseif($data['step']=='step-3'){
		define('ajaxload',true);
		$sys->page->load('ajax/admin/install/reserved/step4');
	}
}
else{
	die('Ups...');
}
