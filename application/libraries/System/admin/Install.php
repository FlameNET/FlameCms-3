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
	function checkphp(){
		$var=$this->get_var_checks();
		$check=$var['ch']['php'];
		$current=$var['cu']['php'];
		return Array('uv'=>$current,'cv'=>$check,'ok'=>$this->decode_versions($check, $current));
	}
	function checkapa(){
		$var=$this->get_var_checks();
		$check=$var['ch']['apa'];
		$current=$var['cu']['apa'];
		return Array('uv'=>$current,'cv'=>$check,'ok'=>$this->decode_versions($check, $current));
	}
	function checkmsv(){
		$var=$this->get_var_checks();
		$check=$var['ch']['msv'];
		$current=$var['cu']['msv'];
		return Array('uv'=>$current,'cv'=>$check,'ok'=>$this->decode_versions($check, $current));
	}
	function checkops(){
		$var=$this->get_var_checks();
		$check=$var['ch']['osv'];
		$current=$var['cu']['osv'];
		
		return Array('uv'=>$current,'cv'=>$check,'ok'=>in_array(strtolower($current),$check));
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
