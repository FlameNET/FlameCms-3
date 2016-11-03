<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * ********************************
 * Main Controller
 * ********************************
 * 
 * will trigger the system to start
 * and have some other properties
 * 
 * ********************************
 */
class Main extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('system');
		$sys=&get_inst();
	}
	function page(){
		$args=implode('/',func_get_args());
		get_inst()->page->load($args);
	}
}