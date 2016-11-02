<?php

defined('FlameCMS') or die('No Script Cuddies');
$sys=&get_inst();

if($sys->input->is_ajax_request())
{
	$a=$sys->install->check_msqlcon($_POST['host'],$_POST['user'],$_POST['pass'],$_POST['db'],$_POST['port']);
	if($a==0){
		$tr=array();
		$tr['error']=false;
		$tr['message']=__('Everything Ok! procced');
		$tr['callout']='success';
	}
	elseif($a==1){
		$tr=array();
		$tr['error']=true;
		$tr['message']=__('Ups, Apears that your Connection Is not Right. Please Check Your Settings');
		$tr['callout']='alert';
	}
	else{
		$tr=array();
		$tr['error']=true;
		$tr['message']=__('The Database Does not exist, please check it');
		$tr['callout']='warning';
	}
	print_r(json_encode($tr,true));
}
else{
	die('Ups...');
}
