<?php defined('BASEPATH') OR exit('No direct script access allowed');
//defined('FlameCMS') or die('No Script Cuddies');

/* ***********************************
 * This system keys cannot be changed!
 * ***********************************
 * if you change, it will break the 
 * hole system!
 * ***********************************
 * If the system breaks, it will 
 * delete all the database tables,
 * delete all the system configuration
 * files and will not leave any trace
 * of it only for security reasons,
 * with the purpose of the user
 * privacy.
 * ***********************************
*/
$encription=array();
$encription['ek01']='3be03db94f8a7797181b7d11054eb8cd';
$encription['ek02']='562b2a13f6fa1c782679d5344190be1c';
$encription['ek03']='3f3b6158569f838b45ba96a088fe03ed';
$encription['ek04']='9bd2d9a92cf56ca125cb2fc37825c20d';
$encription['ek05']='2b42780e37849c566d6fb4ffce34f171';
$encription['ek06']='bc51bf3c0e2c564d10f23fac760576bb';
$encription['ek07']='a1c6d41eda3a54fd6dac724a3b366b75';
$encription['ek08']='fffae6996f8e84248c7e12a6cb492e5e';
$encription['ek09']='101f441a463291a0c19a4286d10d9397';
$encription['ek10']='3cf6bee9912ed9841acb9c5db633f350';
$encription['password_sequences']=(Array) json_decode('["ek01","ek04","ek06","ek08"]');
$encription['UDATA']=(Array) json_decode('["ek01","ek05","ek06","ek09"]');
$encription['plane_user']=(Array) json_decode('["ek02","ek04","ek07","ek10"]');
$config['system_keys']=$encription;
	