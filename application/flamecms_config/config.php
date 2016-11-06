<?php
defined('FlameCMS') or die('No Script Cuddies');
function check_the_config_file_flamecms(){
	return file_exists(APPPATH.'config/flamecms/config.php');
}
