<?php
/*CODEIGNITHER CHECK*/
defined('BASEPATH') OR exit('No direct script access allowed');
/*System Init and preloader*/
class System {
	private static $sys_instance;
	function set_inst(&$instance){
		self::$sys_instance=$instance;
	}
	function & get_inst(){
		if(!isset(self::$sys_instance))
		{
			$this->set_inst(get_instance());
		}
		return self::$sys_instance;
	}
	static function & get_instance(){
		if(!isset(self::$sys_instance))
		{
			$this->set_inst(get_instance());
		}
		return self::$sys_instance;
	} 
	static function set_instance(&$instance)
	{
		self::$sys_instance=$instance;
	}
	public static $configuration;
	function __construct(){
		if(!isset(self::$sys_instance))
		{
			/*CREATE THE FlameCMS Global Var to validate Our Libraries*/
			define('FlameCMS','init');
			$CI=&get_instance();
			/*Preload system*/
			
			/*Old CI Bug*/
			//session_start();
				
			$CI->load->library(
				array(
					'calendar',
					'email',
					'encryption',
					'upload',
					'System/initiator'=>'pre',
				)
			);
			$CI->load->helper(
				array(
					'cookie',
					'url'
				)
			);
			set_inst($CI);
			$sys=&get_inst();
			$sys->pre->init();
		}
	}
	
	/*stop implemention of cloning*/
	private function __wakeup(){}
	private function __clone(){}
}
function & get_inst(){
	return System::get_instance();
}
function set_inst(&$inst){
	System::set_instance($inst);
}
	/*Get the Real Client IP (Cannot parse Proxies only the ip of it)*/
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}