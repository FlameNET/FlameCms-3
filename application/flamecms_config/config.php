<?php
defined('FlameCMS') or die('No Script Cuddies');
if(!function_exists('check_the_config_file_flamecms')){
	function check_the_config_file_flamecms(){
		return file_exists(APPPATH.'config/flamecms/config.php');
	}
}
if(!function_exists('check_the_installer_config_file_flamecms')){
	function check_the_installer_config_file_flamecms(){
		return file_exists(APPPATH.'config/flamecms/installer_config.php');
	}
}
