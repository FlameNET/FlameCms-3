<?php
defined('FlameCMS') or die('No Script Cuddies');
if(!check_the_config_file_flamecms()){
	define('installer',true,true);
	$sys=&get_inst();
	
	if($sys->input->is_ajax_request())
	{
		$data=array();
		$data=array_merge($data,$_POST);
		if($data['step']=='step-1'){
			define('ajaxload',true);
			$sys->page->load('ajax/admin/install/reserved/step2');
		}
		elseif($data['step']=='step-2'){
			define('ajaxload',true);
			$sys->page->load('ajax/admin/install/reserved/step3');
		}
		elseif($data['step']=='step-3'){
			$sys->session->install_data=$data;
			define('ajaxload',true);
			$sys->installer->config_file($data['cms_mysql_con_host'],
				$data['cms_mysql_con_user'],
				$data['cms_mysql_con_pass'],
				$data['cms_mysql_con_db'],
				$data['cms_mysql_con_port'],
				$data['cms_mysql_con_prefix']);
				/*set everything to session*/
				$sys->session->installer_data=$data;
				$rdata=array();
				$rdata['html']=$sys->page->load('ajax/admin/install/reserved/step4',true);
				$rdata['step']='step-4';
				print_r( json_encode($rdata));
		}elseif($data['step']=='step-3-reload'){
				$rdata=array();
				$rdata['html']=$sys->page->load('ajax/admin/install/reserved/step4',true);
				$rdata['step']='step-4';
				print_r( json_encode($rdata));
		}elseif($data['step']=='step-4'){
			//next step maybe?
			$sys->load->database();
			$sys->db->database();
			$sys->installer->initiate_root_account();
			$rdata=array();
			$rdata['html']=$sys->page->load('ajax/admin/install/reserved/step5',true);
			$rdata['step']='step-5';
			print_r( json_encode($rdata));
		}elseif($data['step']=='step-5'){
			$sys->load->database();
			$sys->db->database();
			$sys->installer->initiate_owner_account($sys->session->installer_data);
			$rdata=array();
			$rdata['html']=$sys->page->load('ajax/admin/install/reserved/step6',true);
			$rdata['step']='step-6';
			print_r( json_encode($rdata));
		}elseif($data['step']=='step-6'){
			$sys->load->database();
			$sys->db->database();
			$sys->installer->setup_settings();
			$rdata=array();
			$rdata['html']=$sys->page->load('ajax/admin/install/reserved/step7',true);
			$rdata['step']='step-7';
			print_r( json_encode($rdata));
		}
	}
	else{
		die('Ups...');
	}
}else{
	die('NO!');
}
