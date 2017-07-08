<?php
defined('APPPATH') or die('No SCRIPT KUDDIES');
function is_json($data){
	$ndata=json_decode($data);
	if(json_last_error() !== JSON_ERROR_NONE){
		return false;
	}elseif(json_last_error() !== 0){
		return false;
	}elseif($ndata === null){
		return false;
	}
	return true;
}
