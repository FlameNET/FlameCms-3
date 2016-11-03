<?php
defined('FlameCMS') or die('No Script Cuddies');
class Install{
	function get_var_checks(){
		ob_start(); 
		phpinfo(INFO_MODULES); 
		$info = ob_get_contents(); 
		ob_end_clean(); 
		$info = stristr($info, 'Client API version'); 
		preg_match('/[1-9].[0-9].[1-9][0-9]/', $info, $match);
		/*data*/
		$data=array();
		/*mysql version*/ 
		$data['msv'] = $match[0];
		/*apache version*/
		$apa=explode('/',apache_get_version());
		$apa=explode(' ',$apa[1]);
		$data['apa']=$apa[0];
		/*OS version*/
		$data['osv']=php_uname('s');
		/*php v*/
		$php=explode('-',phpversion());
		$data['php']=$php[0];
		$check=array('ch'=>array(
			'php'=>'5.5.1',
			'msv'=>'5.0.11',
			'apa'=>'2.2.29',
			'osv'=>array(
				'linux',
				'windows'
				),
			),'cu'=>$data);
		return $check;
	}
	/*system requirements check*/
	function check(){
		$sys=&get_inst();
		$data=array();
		$data['apa']=$sys->install->checkapa();
		$data['php']=$sys->install->checkphp();
		$data['msv']=$sys->install->checkmsv();
		$data['ops']=$sys->install->checkops();
		$data['ico']=$sys->install->check_iconv();
		$data['soa']=$sys->install->check_soap();
		$data['cur']=$sys->install->check_curl();
		$data['has']=$sys->install->check_hash();
		$data['ope']=$sys->install->check_openssl();
		return $data;
	}
	function check_msqlcon($host,$user,$pass,$db,$port){
		@ $msc=mysqli_connect($host,$user,$pass,'',$port) or '';
		if(($msc!=='') && (!is_bool($msc))){
			/*connection ok, lets check the db*/
			@ $msq=mysqli_query($msc, 'SHOW DATABASES LIKE "'.$db.'";');
			if(mysqli_num_rows($msq)==0){
				/*The Database Does Not Exist*/
				return 2;
			}
			else{
				/*Everything Ok*/
				return 0;
			}
		}
		else{
			/*The connection it's broken (or no connection at all)*/
			return 1;
		}
	}
	function check_openssl(){
		$openssl=function_exists('openssl_free_key');
		return Array('uv'=>(($openssl==true)?__('Yes'):__('No')),'cv'=>__('OpenSSL Extension Exists'),'label'=>'OpenSSL','ok'=>$openssl);
	}
	function check_hash(){
		$hash=function_exists('hash');
		return Array('uv'=>(($hash==true)?__('Yes'):__('No')),'cv'=>__('Hash Extension Exists'),'label'=>'Hash','ok'=>$hash);
	}
	function check_curl(){
		$curl=function_exists('curl_version');
		return Array('uv'=>(($curl==true)?__('Yes'):__('No')),'cv'=>__('Curl Extension Exists'),'label'=>'Curl','ok'=>$curl);
	}
	function check_iconv(){
		if (function_exists('iconv')) {
		 $iconv=true;
		}
		else{
			$iconv=false;
		}
		return Array('uv'=>(($iconv==true)?__('Yes'):__('No')),'cv'=>__('IconV Extension Exists'),'label'=>'Iconv','ok'=>$iconv);
	}
	function check_soap(){
		if (extension_loaded('soap')) {
		  $soap=class_exists("SOAPClient");
		}
		else{
			$soap=class_exists("SOAPClient");
		}
		return Array('uv'=>(($soap==true)?__('Yes'):__('No')),'cv'=>__('Soap Exists and Enabled'),'label'=>__('Soap Client API'),'ok'=>$soap);
	}
	function checkphp(){
		$var=$this->get_var_checks();
		$check=$var['ch']['php'];
		$current=$var['cu']['php'];
		return Array('uv'=>$current,'cv'=>$check,'label'=>__('PHP Version'),'ok'=>$this->decode_versions($check, $current));
	}
	function checkapa(){
		$var=$this->get_var_checks();
		$check=$var['ch']['apa'];
		$current=$var['cu']['apa'];
		return Array('uv'=>$current,'cv'=>$check,'label'=>__('Apache Server Version'),'ok'=>$this->decode_versions($check, $current));
	}
	function checkmsv(){
		$var=$this->get_var_checks();
		$check=$var['ch']['msv'];
		$current=$var['cu']['msv'];
		return Array('uv'=>$current,'cv'=>$check,'label'=>__('Mysqli Client API Version'),'ok'=>$this->decode_versions($check, $current));
	}
	function checkops(){
		$var=$this->get_var_checks();
		$check=$var['ch']['osv'];
		$current=$var['cu']['osv'];
		
		return Array('uv'=>$current,'cv'=>$check,'label'=>__('Operating System'),'ok'=>in_array(strtolower($current),$check));
	}
	function decode_versions($v1,$v2){
		$vch=version_compare($v2,$v1);
		if(is_bool($vch))
		{
			return $vch;
		}
		else{
			if($vch>=0)
			{
				return true;
			}
			else{
				return false;
			}
		}
	}
}
