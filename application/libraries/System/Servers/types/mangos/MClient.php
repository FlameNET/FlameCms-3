<?php
defined('FlameCMS') or die('No Script Cuddies');
class MClient{
	function command($command='',$server_id,$config=array()){
		$sys=&get_inst();
		if(empty($config)){			
			$soapUsername = '';
			$soapPassword = '';
			$soapHost = '';
			$soapPort = '';
		}
		else{			
			$soapUser = (isset($config['user'])?$config['user']:$sys->configuration->soap->$server_id->user);
			$soapPass = (isset($config['pass'])?$config['pass']:$sys->configuration->soap->$server_id->pass);
			$soapHost = (isset($config['host'])?$config['host']:$sys->configuration->soap->$server_id->host);
			$soapPort = (isset($config['port'])?$config['port']:$sys->configuration->soap->$server_id->port);
		}

		$client = new SoapClient(NULL, array(
			'location' => "http://$soapHost:$soapPort/",
			'uri'      => 'urn:MaNGOS',
			'style'    => SOAP_RPC,
			'login'    => $soapUser,
			'password' => $soapPass,
		));
		if($command==''){
			$command = "server info";
		}

		$result = $client->executeCommand(new SoapParam($command, 'command'));
		return $result;
	}
}