<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * ********************************
 * Main Controller
 * ********************************
 * will trigger the system to start
 * and have some other properties
 */
class Main extends CI_Controller {
	function __construct(){
		parent::__construct();
	}
	function page(){
		$args=func_get_args();
		print_r('loaded');
		print_r($args);
	}
}