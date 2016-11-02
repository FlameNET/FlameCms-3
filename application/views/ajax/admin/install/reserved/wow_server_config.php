<?php

defined('FlameCMS') or die('No Script Cuddies');
$sys=&get_inst();

if($sys->input->is_ajax_request())
{
	if($_POST['action']=='add')
	{
		/*return data*/
		$rd=array(
			
		);
	}
	return json_encode($rd,true)
}
else{
	die('Ups...');
}
