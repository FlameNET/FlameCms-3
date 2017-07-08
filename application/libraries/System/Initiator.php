<?php
/*FlameCMS CHECK*/
defined('FlameCMS') OR die('No script Cuddies');
Class Initiator{
	function init(){
		//$this->system();
		$this->setting_up();
	}
	function setting_up(){
		$sys=&get_inst();
		$sys->load->library(array(
			'System/Trigger'=>'trigger',
			'System/page'=>'page',
			'System/helpers/Pps'=>'pps',
			'System/helpers/Sas'=>'sas',
			'System/helpers/Hfs'=>'hfs',
			'System/security/Sec'=>'sec',
			'System/admin/Updates/Update'=>'up'
		));
		$sys->page->pps =& $sys->pps;
		$sys->page->sas =& $sys->sas;
		$sys->page->hfs =& $sys->hfs;
		$sys->up->get_releases();
		/*If config File Does not exists, Trigger Installer*/
		include(APPPATH.'/flamecms_config/config.php');
		/*Temporary, until installer is completely finished*/
		if(!check_the_config_file_flamecms()){
		//if(true==false){
			$sys->load->library(array(
				'System/libraries/session/MY_Session'=>'session',
				'System/admin/Install',
				'System/install/Installer'=>'installer',
				));
			set_inst($sys);
			$sys->load->library(array(
				'System/admin/install/Install_langs'=>'ilang',
				));
			/*Requires all files on a directory (this case will require all languages)*/
			requireall(APPPATH.'/flamecms_installer_langs');
			get_inst()->trigger->install();
		}
		/*Ignore CodeIgnither Configs (the are still Called, but, not used)*/
		else{
			//removed, this is loaded, on the database.php
			//$sys->config->load('flamecms/config.php');
			$this->configs();
			/*END*/
			set_inst($sys);
		}
	}
	function config(){
		/*Initiate The Configurations*/
		/*They will be in parent_child format, on the DB, so we can load "per parent" configuration*/
		$this->config();
	}
	function configs(){
		/*Initiate The Configurations*/
		/*They will be in parent_child format, on the DB, so we can load "per parent" configuration*/
	}
	private function wind_configuration($configs){
		$confs=System::$configuration;
		/*
		**************************************
		** To Check:
		**************************************
		** The System configuration Table
		** The Servers Table
		** The Realms Table
		**************************************
		*/
		
		System::$configuration=$confs;
	}
}