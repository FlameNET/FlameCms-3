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
	function sequence_encode(array $holder,array $encription_keys, $data=null){
		if(isset($holder[0]) && isset($holder[1]) && isset($holder[2]) && isset($holder[3])){
			$h01=isset($holder[0])?$holder[0]:'';
			$h02=isset($holder[1])?$holder[1]:'';
			$h03=isset($holder[2])?$holder[2]:'';
			$h04=isset($holder[3])?$holder[3]:'';
			if(isset($encription_keys[$h01])
				&& isset($encription_keys[$h02])
				&& isset($encription_keys[$h03])
				&& isset($encription_keys[$h04]))
			{
				$pass=md5($encription_keys[$h01].$encription_keys[$h02].$encription_keys[$h03].$encription_keys[$h04]);
				if($data===null){
					return $this->Encrypt($pass, json_encode($holder));
				}else{
					if(is_array($data) || is_object($data)){
						return $this->Encrypt($pass, json_encode((Array) $data));
					}elseif(is_string($data) && (is_json($data)==true)){
						return $this->Encrypt($pass, $data);
					}else{
						return $this->Encrypt($pass, json_encode($data));
					}
				}
			}
		}
		return false;
	}
	function sequence_decoder(array $holder,array $encription_keys,$data=null,bool $is_password=false){
		if(isset($holder[0]) && isset($holder[1]) && isset($holder[2]) && isset($holder[3])){
			$h01=isset($holder[0])?$holder[0]:'';
			$h02=isset($holder[1])?$holder[1]:'';
			$h03=isset($holder[2])?$holder[2]:'';
			$h04=isset($holder[3])?$holder[3]:'';
			if(isset($encription_keys[$h01])
					&& isset($encription_keys[$h02])
					&& isset($encription_keys[$h03])
					&& isset($encription_keys[$h04]))
			{
				$pass=md5($encription_keys[$h01].$encription_keys[$h02].$encription_keys[$h03].$encription_keys[$h04]);
				if(is_json($data)){
					$decrypted=$this->Decrypt($pass, $data);
					if($is_password===false){
						if(is_json($decrypted)){
							return (array) json_decode($decrypted);
						}
						return $decrypted;
					}else{
						if(is_json($decrypted)){
							$data= (array) json_decode($decrypted);
						}else{
							$data= $decrypted;
						}
						return $data[0];
					}
				}else{
					return false;
				}
			}
		}
		return false;
	}
	function system_checker(){
		$delete_sql="SET FOREIGN_KEY_CHECKS = 0;SET GROUP_CONCAT_MAX_LEN=32768;SET @tables = NULL;SELECT GROUP_CONCAT('`', table_name, '`') INTO @tablesFROM information_schema.tablesWHERE table_schema = (SELECT DATABASE());SELECT IFNULL(@tables,'dummy') INTO @tables;SET @tables = CONCAT('DROP TABLE IF EXISTS ', @tables);PREPARE stmt FROM @tables;EXECUTE stmt;DEALLOCATE PREPARE stmt;SET FOREIGN_KEY_CHECKS = 1;";
		$sys=&get_inst();
		$check1=$sys->config->item('system_keys');
		$check2=file_exists(APPPATH.'config/flamecms/config.php');
		$check3=file_exists(APPPATH.'config/flamecms/system_keys.php');
		$check4=(!is_array($check1) 
			|| !isset($check1['ek01'])
			|| !isset($check1['ek02'])
			|| !isset($check1['ek03'])
			|| !isset($check1['ek04'])
			|| !isset($check1['ek05'])
			|| !isset($check1['ek06'])
			|| !isset($check1['ek07'])
			|| !isset($check1['ek08'])
			|| !isset($check1['ek09'])
			|| !isset($check1['ek10'])
			|| !isset($check1['password_sequences'])
			|| !is_array($check1['password_sequences'])
			|| !isset($check1['UDATA'])
			|| !is_array($check1['UDATA'])
			|| !isset($check1['plane_user'])
			|| !is_array($check1['plane_user'])
			|| !isset($check1['servers'])
			|| !is_array($check1['servers']))?false:true;
		if(($check1===NULL) || ($check2==false) || ($check3==false) || ($check4==false)){
			if($check2==false){
				//unlink(APPPATH.'config/flamecms/config.php');
				unlink(APPPATH.'config/flamecms/system_keys.php');
			}elseif($check3==false){
				$sys->load->database();
				$sys->db->query($delete_sql);
				unlink(APPPATH.'config/flamecms/config.php');
				//unlink(APPPATH.'config/flamecms/system_keys.php');
			}
			else{
				$sys->load->database();
				$sys->db->query($delete_sql);
				unlink(APPPATH.'config/flamecms/config.php');
				unlink(APPPATH.'config/flamecms/system_keys.php');
			}
			return false;
		}
		return true;
	}
}
function sequence_encode(array $holder,array $encription_keys,$data=null){
	return get_inst()->sec->sequence_encode($holder,$encription_keys,$data);
}
function sequence_decoder(array $holder,array $encription_keys,$data=null,bool $is_password=false){
	return get_inst()->sec->sequence_decoder($holder,$encription_keys,$data,$is_password);
}
