<?php
defined('FlameCMS') or die('No Script Cuddies');
Class Update{
	function get_releases(){
		$sys=&get_inst();
		//$server=$sys->configuration->system->cms_update_server;
		$server='https://api.github.com/repos/FlameNET/FlameCms-3/releases';
		$ch = curl_init($server);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, 'FlameCMS_updater');
		$response = curl_exec($ch);
		$response=json_decode($response,true);
		$nedded_data=array();
		$nedded_data['current_version']=$response[0]['tag_name'];
		$nedded_data['release_type']=$response[0]['name'];
		$nedded_data['prerelease']=$response[0]['prerelease'];
		$nedded_data['date_of_release']=$response[0]["published_at"];
		$nedded_data['release_tar']=$response[0]["tarball_url"];
		$nedded_data['release_tar']=$response[0]["zipball_url"];
		return $nedded_data;
		
	}
	function check_update(){
		$sys=&get_inst();
		$data=$this->get_releases();
		//$cversion=$sys->configuration->system->cms_version;
		$cversion='0.0.3-alpha';
		$nversion=$data['current_version'];
		$check=$this->decode_versions($cversion, $nversion);
		$str=(($check==1)?'We have an update!':($check==0)?'We are on the current version!':'we have an higer version');
		//print_r($str);
	}
	
	function decode_versions($v1,$v2){
		$vch=version_compare($v2,$v1);
		if(is_bool($vch))
		{
			return $vch;
		}
		else{
			return $vch;
		}
	}
}
