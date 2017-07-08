<?php defined('BASEPATH') OR exit('No direct script access allowed');
//defined('FlameCMS') or die('No Script Cuddies');

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'adomasalcore3',
	'password' => 'ascent',
	'database' => 'flamenet_cmsv3',
	'dbdriver' => 'mysqli',
	'port'=>'3306',
	'dbprefix' => 'flamecms_',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
	