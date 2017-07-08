<?php
defined('FlameCMS') or die('No Script Cuddies');
class Sec{
	function str_gen($lenght,$kp='',$upper=false){
		$kd=array();
		$kd[]=md5($this->sha512(uniqid('',true).$kp));
		$kd[]=md5($this->sha512(uniqid('',true).$kp).uniqid('',true));
		$kd[]=md5($this->sha512(uniqid('',true).$kp).$kp);
		$kd[]=md5($this->sha512(uniqid('',true).$kp).$kd[(count($kd)-1)]);
		$kd[]=md5($this->sha512(uniqid('',true).$kp).$kd[(count($kd)-1)].$kp);
		$kd[]=md5($this->sha512(uniqid('',true).$kp).$kd[(count($kd)-1)].uniqid('',true));
		$kd[]=md5($this->sha512(uniqid('',true).$kp).uniqid('',true).$kd[(count($kd)-1)].uniqid('',true));
		$fs=implode('',$kd);
		if(strlen($str)>$lenght){
			$fs=str_split($fs,$lenght);
			$fs=$fs[0];
		}
		else{
			while(strlen($fs)<$lenght){
				$str_r_len=strlen($string)-$lenght;
				$fs.=$this->generate_uk($str_r_len,$kp,$upper);
			}
		}
		if(is_array($fs))
			return (($upper==true)?strtoupper($fs[0]):$fs[0]);
		return  (($upper==true)?strtoupper($fs):$fs);
	}
	/*SHA algorithms*/
	function sha512($str){
		$this->string_encoder($str);
		return hash('sha512',$str);
	}
	function sha256($str){
		$this->string_encoder($str);
		return hash('sha256',$str);
	}
	function sha128($str){
		$this->string_encoder($str);
		return hash('sha256',$str);
	}
	/**
	* Decrypt data from a CryptoJS json encoding string
	*
	* @param mixed $passphrase
	* @param mixed $jsonString
	* @return mixed
	*/
	function Decrypt($passphrase, $jsonString){
	    $jsondata = json_decode($jsonString, true);
	    $salt = hex2bin($jsondata["s"]);
	    $ct = base64_decode($jsondata["ct"]);
	    $iv  = hex2bin($jsondata["iv"]);
	    $concatedPassphrase = $passphrase.$salt;
	    $md5 = array();
	    $md5[0] = md5($concatedPassphrase, true);
	    $result = $md5[0];
	    for ($i = 1; $i < 3; $i++) {
	        $md5[$i] = md5($md5[$i - 1].$concatedPassphrase, true);
	        $result .= $md5[$i];
	    }
	    $key = substr($result, 0, 32);
	    $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
	    return json_decode($data, true);
	}
	
	/**
	* Encrypt value to a cryptojs compatiable json encoding string
	*
	* @param mixed $passphrase
	* @param mixed $value
	* @return string
	*/
	function Encrypt($passphrase, $value){
	    $salt = openssl_random_pseudo_bytes(8);
	    $salted = '';
	    $dx = '';
	    while (strlen($salted) < 48) {
	        $dx = md5($dx.$passphrase.$salt, true);
	        $salted .= $dx;
	    }
	    $key = substr($salted, 0, 32);
	    $iv  = substr($salted, 32,16);
	    $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
	    $data = array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt));
	    return json_encode($data);
	}
	/*private methods*/
	private function string_encoder(&$str){
		if(!is_string($str)){
			$str=json_encode($str,true);
		}
		return $str;
	}
	function generate_password_sequence(){
		$sequence=array(
			'ek01',
			'ek02',
			'ek03',
			'ek04',
			'ek05',
			'ek06',
			'ek07',
			'ek08',
			'ek09',
			'ek10');
		$pass_sequence=array_rand ($sequence,4);
		$rsequence=array();
		foreach( $pass_sequence as $i){
			$rsequence[]=$sequence[$i];
		}
		return $rsequence;
	}
}
