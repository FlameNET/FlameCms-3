<?php
defined('FlameCMS') or die('No Script Cuddies');
class Installer{
	function config_file($host,$user,$pass,$database,$port,$prefix){
		$sys=&get_inst();
		if(!file_exists(APPPATH.'config/flamecms'))
			mkdir(APPPATH.'config/flamecms');
		//$myfile = fopen(APPPATH.'config/flamecms/config.php', "rw") or false;
		$test=$sys->install->check_msqlcon($host,$user,$pass,$database,$port);
		
		if($test!=0)
		{
			return $test;
		}
		$txt = config_creator_text($host,$user,$pass,$database,$port,$prefix);
		write_file(APPPATH.'config/flamecms/installer_config.php', $txt);
		$sys->load->database();
		$valid_db=$this->initiate_db($prefix, $host, $user, $pass, $database, $port);
		if($valid_db==false){
			unlink(APPPATH.'config/flamecms/config.php');
			unlink(APPPATH.'config/flamecms/installer_config.php');
			rmdir(APPPATH.'config/flamecms');
			return false;
		}
		$this->config_file_system_keys();
		$sys->config->load('flamecms/system_keys');
		return true;
	}
	function end_install(){
		rename(APPPATH.'config/flamecms/installer_config.php',APPPATH.'config/flamecms/config.php');
		unlink(dirname(__file__)."/flamecmsinstaller.sql");
	}
	function config_file_system_keys(){
		$sys=&get_inst();
		$myfile = file_put_contents(APPPATH.'config/flamecms/system_keys.php', config_systemkeys_creator()) or false;
		if($myfile==false){
			return false;
		}
		return true;
	}
	function initiate_db($prefix,$host,$user,$pass,$database,$port){
		$sys=&get_inst();
		$sql=sql($prefix);
		$temp_file=dirname(__file__)."/flamecmsinstaller.sql";
		if($file=file_put_contents($temp_file, $sql)) {
			$command="mysql -u{$user} -p{$pass} "
				. "-h {$host} -D {$database} ";
			shell_exec($command."< ".$temp_file);
			return true;
		}
		else{
			return false;
		}
	}
	function initiate_root_account(){
		$sys=&get_inst();
		$uuid=''; 
		$uuid.=md5(uniqid('',true)); 
		$uuid.=md5(uniqid('',true)); 
		$uuid.=md5(uniqid('',true));
		$p_sequence=$sys->sec->generate_password_sequence();
		$data_user=array(
			'UUID'=>$uuid,
			'username'=>$sys->sec->sha512('ROOT'),
			'activation'=>'',
			/* the password will never match,
			 * since it needs an specific combination and that is not made here.
			 * */
			'password'=>$sys->sec->sha512(''),/*all passwords are made by: md5 with an postencrypt of sha512, so.... it's impossible (or almost) to discover the empty string equivalent.*/
			'email'=>$sys->sec->sha512(''),
			'enforcement'=>json_encode($p_sequence),
			'phone'=>$sys->sec->sha512(''),
			'ek01'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek02'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek03'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek04'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek05'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek06'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek07'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek08'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek09'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek10'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			/*attention this is encripted, so don't be alarmd about secutiry*/
			'login_plane_data'=>array(
				'username'=>'ROOT USER',
				'email'=>'',
				'phone'=>'',
				'recovery_key'=>'',
				'recovery_timeout'=>''
			)
		);
		$data_acco=array(
			'UUID'=>$uuid,
			'permission_level'=>'11',
			/*Encrypted*/
			'UDATA'=>array(
				'fname'=>'FlameCMS',
				'lname'=>'Root',
				'email'=>'',
				'permission_level'=>'12',
				'about_text'=>'FlameCMS Root Control account',
				'job'=>'',
				'contact_info'=>'',
			)
		);
		/*encrypt user password (It's WORKING! Yai!)*/
		$system_keys=$sys->config->item('system_keys');
		$data_user['password']=sequence_encode((array) json_decode($data_user['enforcement']),$data_user, $sys->sec->sha512($data_user['password']));
		//print_r(sequence_decoder((array) json_decode($data_user['enforcement']),$data_user, $data_user['password'],true));
		//* encrypt user personal password sequence  (It's WORKING! Yai!)*/
		
		$data_user['enforcement']=sequence_encode($system_keys['password_sequences'],$system_keys,$data_user['enforcement']);
		//print_r(sequence_decoder($system_keys['password_sequences'],$system_keys, $data_user['enforcement']));
		
		/*encrypt UDATA (USER DATA)  (It's WORKING! Yai!)*/
		$data_acco['UDATA']=sequence_encode($system_keys['UDATA'],$system_keys, $data_acco['UDATA']);
		//print_r(sequence_decoder($system_keys['UDATA'],$system_keys, $data_acco['UDATA']));
		/*encrypt UDATA (USER DATA)  (It's WORKING! Yai!)*/
		$data_user['login_plane_data']=sequence_encode($system_keys['plane_user'],$system_keys,$data_user['login_plane_data']);
		//print_r(sequence_decoder($system_keys['plane_user'],$system_keys,$data_user['login_plane_data']));
		$sys->db->set($data_user);
		$sys->db->insert('user_login');
		$sys->db->set($data_acco);
		$sys->db->insert('user_data');
	}
	function initiate_owner_account($data){
		$sys=&get_inst();
		$p_sequence=$sys->sec->generate_password_sequence();
		$uuid=''; 
		$uuid.=md5(uniqid('',true)); 
		$uuid.=md5(uniqid('',true)); 
		$uuid.=md5(uniqid('',true));
		$data_user=array(
			'UUID'=>$uuid,
			'username'=>$sys->sec->sha512($data['cms_admin_account_username']),
			'email'=>$sys->sec->sha512($data['cms_admin_account_email']),
			'phone'=>$sys->sec->sha512(''),
			'activation'=>'',
			'password'=>'',
			'enforcement'=>json_encode($p_sequence),
			'ek01'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek02'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek03'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek04'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek05'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek06'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek07'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek08'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek09'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			'ek10'=>$sys->sec->sha512(uniqid(json_encode($p_sequence).'_',true)),
			/*attention this is encripted, so don't be alarmd about secutiry*/
			'login_plane_data'=>array(
				'username'=>$data['cms_admin_account_username'],
				'email'=>$data['cms_admin_account_email'],
				'phone'=>'',
				'recovery_key'=>'',
				'recovery_timeout'=>''
			)
		);
		$data_acco=array(
			'UUID'=>$uuid,
			'permission_level'=>'11',
			/*Encrypted*/
			'UDATA'=>array(
				'fname'=>$data['cms_admin_account_fname'],
				'lname'=>$data['cms_admin_account_lname'],
				'email'=>$data['cms_admin_account_email'],
				'about_text'=>'',
				'job'=>'',
				'contact_info'=>'',
			)
		);
		if($data['cms_admin_account_password'] == $data['cms_admin_account_confirm_password']){
			/*encrypt user password (It's WORKING! Yai!)*/
			$system_keys=$sys->config->item('system_keys');
			$data_user['password']=sequence_encode((array) json_decode($data_user['enforcement']),$data_user, $sys->sec->sha512($data['cms_admin_account_password']));
			//print_r(sequence_decoder((array) json_decode($data_user['enforcement']),$data_user, $data_user['password'],true));
			//* encrypt user personal password sequence  (It's WORKING! Yai!)*/
			
			$data_user['enforcement']=sequence_encode($system_keys['password_sequences'],$system_keys,$data_user['enforcement']);
			//print_r(sequence_decoder($system_keys['password_sequences'],$system_keys, $data_user['enforcement']));
			
			/*encrypt UDATA (USER DATA)  (It's WORKING! Yai!)*/
			$data_acco['UDATA']=sequence_encode($system_keys['UDATA'],$system_keys, $data_acco['UDATA']);
			//print_r(sequence_decoder($system_keys['UDATA'],$system_keys, $data_acco['UDATA']));
			/*encrypt UDATA (USER DATA)  (It's WORKING! Yai!)*/
			$data_user['login_plane_data']=sequence_encode($system_keys['plane_user'],$system_keys,$data_user['login_plane_data']);
			//print_r(sequence_decoder($system_keys['plane_user'],$system_keys,$data_user['login_plane_data']));
		}
		/*direct insert (we don't need the prefix for it, CI handles it for us)*/
		$sys->db->insert('user_login',$data_user);
		$sys->db->insert('user_data',$data_acco);
	}
	function setup_settings(){
		$sys=&get_inst();
		$data=array();
		$data['cms_sitename']=$sys->session->installer_data['cms_name'];
		$data['cms_https']=$sys->session->installer_data['forcehttps'];
		$data['cms_force_https']=$sys->session->installer_data['forcehttps'];
		$data['cms_login_force_https']=$sys->session->installer_data['forcehttps_admin'];
		$data['cms_baseurl']=$sys->session->installer_data['cms_domain'];
		$data['cms_lang']=$sys->session->installer_data['cms_default_language_selection'];
		$data['cms_multilang']=$sys->session->installer_data['multilanguage'];
		$data['cms_languages']=array();
		foreach($sys->session->installer_data as $iid=>$item){
			if(strpos($iid,'multilang-')!==false){
				if(($item===true)||($item==='true')){
					$data['cms_languages'][]=str_replace('multilang-', '', $iid);
				}
			}
		}
		foreach($data as $id=>$settings){
			$new_data=array(
				'setting_ind'=>$id,
				'setting_value'=>$settings,
			);
			if(is_array($settings) || is_object($settings)){
				$new_data['setting_value']=json_encode($settings);
				$new_data['setting_type']='j';
			}elseif(is_bool($settings)){
				$new_data['setting_value']=json_encode($settings);
				$new_data['setting_type']='b';
			}elseif(is_string($settings)){
				$new_data['setting_value']=''.$settings;
				$new_data['setting_type']='s';
			}elseif(is_int($settings)){
				$new_data['setting_value']=''.$settings;
				$new_data['setting_type']='i';
			}elseif(is_float($settings)){
				$new_data['setting_value']=''.$settings;
				$new_data['setting_type']='f';
			}elseif(is_double($settings)){
				$new_data['setting_value']=''.$settings;
				$new_data['setting_type']='d';
			}
			$sys->db->set($new_data);
			$sys->db->where('setting_ind',$id);
			$sys->db->update('settings');
		}
	}
}
function config_systemkeys_creator(){
	$sys=&get_inst();
	ob_start();
	echo '<?php ';
	?>
defined('BASEPATH') OR exit('No direct script access allowed');
//defined('FlameCMS') or die('No Script Cuddies');

/* ***********************************
 * This system keys cannot be changed!
 * ***********************************
 * if you change, it will break the 
 * hole system!
 * ***********************************
 * If the system breaks, it will 
 * delete all the database tables,
 * delete all the system configuration
 * files and will not leave any trace
 * of it only for security reasons,
 * with the purpose of the user
 * privacy.
 * ***********************************
*/
$encription=array();
$encription['ek01']='<?=md5(uniqid('',true));?>';
$encription['ek02']='<?=md5(uniqid('',true));?>';
$encription['ek03']='<?=md5(uniqid('',true));?>';
$encription['ek04']='<?=md5(uniqid('',true));?>';
$encription['ek05']='<?=md5(uniqid('',true));?>';
$encription['ek06']='<?=md5(uniqid('',true));?>';
$encription['ek07']='<?=md5(uniqid('',true));?>';
$encription['ek08']='<?=md5(uniqid('',true));?>';
$encription['ek09']='<?=md5(uniqid('',true));?>';
$encription['ek10']='<?=md5(uniqid('',true));?>';
$encription['password_sequences']=(Array) json_decode('<?=json_encode($sys->sec->generate_password_sequence());?>');
$encription['UDATA']=(Array) json_decode('<?=json_encode($sys->sec->generate_password_sequence());?>');
$encription['plane_user']=(Array) json_decode('<?=json_encode($sys->sec->generate_password_sequence());?>');
$encription['servers']=(Array) json_decode('<?=json_encode($sys->sec->generate_password_sequence());?>');
$config['system_keys']=$encription;
	<?php
	return ob_get_clean();
}
function config_creator_text($host,$user,$pass,$database,$port,$prefix){
	ob_start();
	echo '<?php ';
	?>
defined('BASEPATH') OR exit('No direct script access allowed');
//defined('FlameCMS') or die('No Script Cuddies');

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '<?=$host;?>',
	'username' => '<?=$user;?>',
	'password' => '<?=$pass;?>',
	'database' => '<?=$database;?>',
	'dbdriver' => 'mysqli',
	'port'=>'<?=$port;?>',
	'dbprefix' => '<?=$prefix;?>',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
	<?php
	return ob_get_clean();
}
function sql($prefix){
	ob_start();
	?>
	SET FOREIGN_KEY_CHECKS=0;
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>auto_login
	-- ----------------------------

	DROP TABLE IF EXISTS `<?=$prefix;?>auto_login`;
	CREATE TABLE `<?=$prefix;?>auto_login` (
	  `UUID` varchar(99) NOT NULL,
	  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  `data` blob NOT NULL,
	  `ip_address` varchar(45) NOT NULL,
	  `user_agent` text NOT NULL,
	  `terminate_session` tinyint(1) unsigned zerofill NOT NULL,
	  KEY `UUID` (`UUID`),
	  CONSTRAINT `<?=$prefix;?>auto_login_ibfk_1` FOREIGN KEY (`UUID`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>auto_login
	-- ----------------------------
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>blog_content
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>blog_content`;
	CREATE TABLE `<?=$prefix;?>blog_content` (
	  `blog_id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
	  `created_by` varchar(99) NOT NULL,
	  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  `modified_on` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	  `blog_content` longtext NOT NULL,
	  `blog_slug` varchar(255) NOT NULL,
	  `blog_child` int(11) unsigned zerofill DEFAULT NULL,
	  PRIMARY KEY (`blog_id`),
	  KEY `created_by` (`created_by`),
	  KEY `blog_child` (`blog_child`),
	  CONSTRAINT `<?=$prefix;?>blog_content_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `<?=$prefix;?>blog_content_ibfk_2` FOREIGN KEY (`blog_child`) REFERENCES `<?=$prefix;?>blog_content` (`blog_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>blog_content
	-- ----------------------------
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>forum
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>forum`;
	CREATE TABLE `<?=$prefix;?>forum` (
	  `forum_id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
	  `section_id` int(11) unsigned zerofill NOT NULL,
	  `is_content` tinyint(1) NOT NULL,
	  `forum_slug` varchar(255) NOT NULL,
	  `forum_name` text NOT NULL,
	  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `modified_on` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	  `subforum_id` int(11) unsigned zerofill DEFAULT NULL,
	  `created_by` varchar(99) NOT NULL,
	  PRIMARY KEY (`forum_id`),
	  KEY `section_id` (`section_id`),
	  KEY `subforum_id` (`subforum_id`),
	  KEY `created_by` (`created_by`),
	  CONSTRAINT `<?=$prefix;?>forum_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `<?=$prefix;?>forum_section` (`section_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `<?=$prefix;?>forum_ibfk_2` FOREIGN KEY (`subforum_id`) REFERENCES `<?=$prefix;?>forum` (`forum_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `<?=$prefix;?>forum_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>forum
	-- ----------------------------
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>forum_messages
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>forum_messages`;
	CREATE TABLE `<?=$prefix;?>forum_messages` (
	  `forum_id` int(11) unsigned zerofill NOT NULL,
	  `mensage_id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
	  `message_content` longtext NOT NULL,
	  `message_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	  `created_by` varchar(99) NOT NULL,
	  PRIMARY KEY (`mensage_id`,`forum_id`),
	  KEY `forum_id` (`forum_id`),
	  KEY `created_by` (`created_by`),
	  CONSTRAINT `<?=$prefix;?>forum_messages_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `<?=$prefix;?>forum` (`forum_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `<?=$prefix;?>forum_messages_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>forum_messages
	-- ----------------------------
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>forum_section
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>forum_section`;
	CREATE TABLE `<?=$prefix;?>forum_section` (
	  `section_id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
	  `section_name` text NOT NULL,
	  `section_slug` varchar(255) NOT NULL,
	  `created_by` varchar(99) NOT NULL,
	  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `modified_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  `child_of_forum` int(11) unsigned zerofill DEFAULT NULL,
	  `child_of_section` int(11) unsigned zerofill DEFAULT NULL,
	  PRIMARY KEY (`section_id`),
	  UNIQUE KEY `section_id` (`section_id`) USING BTREE,
	  UNIQUE KEY `section_slug` (`section_slug`) USING BTREE,
	  KEY `created_by` (`created_by`),
	  KEY `child_of_section` (`child_of_section`),
	  KEY `child_of_forum` (`child_of_forum`),
	  CONSTRAINT `<?=$prefix;?>forum_section_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `<?=$prefix;?>forum_section_ibfk_2` FOREIGN KEY (`child_of_section`) REFERENCES `<?=$prefix;?>forum_section` (`section_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `<?=$prefix;?>forum_section_ibfk_3` FOREIGN KEY (`child_of_forum`) REFERENCES `<?=$prefix;?>forum` (`forum_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>forum_section
	-- ----------------------------
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>log_login
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>log_login`;
	CREATE TABLE `<?=$prefix;?>log_login` (
	  `username` longtext NOT NULL,
	  `id` int(99) NOT NULL,
	  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  `ip` longtext NOT NULL,
	  `useragent` longtext NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>log_login
	-- ----------------------------
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>sessions
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>sessions`;
	CREATE TABLE `<?=$prefix;?>sessions` (
	  `session_id` varchar(128) NOT NULL,
	  `UUID` varchar(99) DEFAULT NULL,
	  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  `data` blob NOT NULL,
	  `ip_address` varchar(45) NOT NULL,
	  PRIMARY KEY (`session_id`),
	  UNIQUE KEY `id` (`session_id`) USING BTREE,
	  KEY `UUID` (`UUID`),
	  KEY `ci_sessions_timestamp` (`timestamp`) USING BTREE,
	  CONSTRAINT `<?=$prefix;?>sessions_ibfk_1` FOREIGN KEY (`UUID`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>sessions
	-- ----------------------------
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>settings
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>settings`;
	CREATE TABLE `<?=$prefix;?>settings` (
	  `setting_id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
	  `setting_ind` varchar(255) NOT NULL,
	  `setting_value` varchar(255) NOT NULL,
	  `setting_type` varchar(1) NOT NULL,
	  `modified_by` varchar(99) DEFAULT NULL,
	  `modified_on` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`setting_id`,`setting_ind`),
	  UNIQUE KEY `setting_ind` (`setting_ind`) USING BTREE,
	  KEY `modified_by` (`modified_by`),
	  CONSTRAINT `<?=$prefix;?>settings_ibfk_1` FOREIGN KEY (`modified_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>settings
	-- ----------------------------
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000001', 'cms_sitename', 'FlameCMS', 's', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000002', 'cms_https', 'true', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000003', 'cms_theme', 'default', 's', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000004', 'cms_lang', 'en', 's', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000005', 'cms_multilang', 'true', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000006', 'cms_languages', '{\'0\':\"pt\",\'1\':\"en\",\'2\':\"es\"}', 'j', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000007', 'cms_force_https', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000008', 'cms_login_force_https', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000009', 'cms_cookie_name', 'flamecms', 's', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000010', 'cms_baseurl', 'v3.flamecms.tk', 's', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000011', 'cms_alpha_security', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000012', 'cms_version', '0.0.3-alpha', 'v', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000013', 'cms_version_type', 'pre_alpha', 's', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000014', 'cms_update_server', 'https://api.github.com/repos/FlameNET/FlameCms-3/releases', 's', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000015', 'cms_enable_alpha_features', 'true', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000016', 'cms_enable_beta_features', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000017', 'cms_enable_charlie_features', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000018', 'cms_enable_release_features', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000019', 'cms_quick_notifications', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000020', 'cms_ajax_security', 'true', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000021', 'cms_plugins', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000022', 'cms_themes', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000023', 'cms_uploads', 'true', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000024', 'cms_hide_flame_credits', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000025', 'cms_custom_copyright', '{\'value\':false,\'msg\':\'\'}', 'j', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000026', 'cms_advanced_paypal', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000027', 'cms_advanced_enablement_key', '{\'value\':false,\'key\':\'\'}', 'j', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000028', 'cms_maintenance_mode', '{\'value\':false,\'msg\':\'\'}', 'j', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000029', 'cms_enable_wysiwyg', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000030', 'cms_utc', 'UTC+0', 's', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000031', 'cms_root_change_password', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000032', 'cms_enable_menu_managment', 'true', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000033', 'cms_enable_ceo', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000034', 'cms_enable_updates', 'true', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000035', 'cms_support_verification_mode', 'checksum', 's', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000036', 'cms_paid_support', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000037', 'cms_geoip_tracking', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000038', 'cms_log_user_login', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000039', 'cms_ban_ip_for', '15m', 's', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000040', 'cms_facebook_login', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000041', 'cms_splashframe_login', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000042', 'cms_google_login', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000043', 'cms_enable_app_support', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000044', 'cms_log_user_actions', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000045', 'cms_log_update_checks', 'true', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000046', 'cms_favion', '', 's', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000047', 'cms_xls_export_enable', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000048', 'cms_rss_enable', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000049', 'cms_pps_type', '3', 's', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000050', 'cms_subdomain_per_language', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000053', 'cms_enable_localstorage_key', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000054', 'cms_user_session_tracking', 'false', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000055', 'cms_platform_tracking', 'true', 'b', null, null);
	INSERT INTO `<?=$prefix;?>settings` VALUES ('00000000056', 'cms_install_id', '1', 'i', null, null);
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>slideshow
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>slideshow`;
	CREATE TABLE `<?=$prefix;?>slideshow` (
	  `slide_id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
	  `UUID` varchar(99) NOT NULL,
	  `slide_img` varchar(255) NOT NULL,
	  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  `modified_on` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	  `slide_title` text NOT NULL,
	  `slide_content` text NOT NULL,
	  `news_id` int(11) unsigned zerofill DEFAULT NULL,
	  PRIMARY KEY (`slide_id`),
	  KEY `UUID` (`UUID`),
	  KEY `news_id` (`news_id`),
	  CONSTRAINT `<?=$prefix;?>slideshow_ibfk_1` FOREIGN KEY (`UUID`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `<?=$prefix;?>slideshow_ibfk_2` FOREIGN KEY (`news_id`) REFERENCES `<?=$prefix;?>blog_content` (`blog_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>slideshow
	-- ----------------------------
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>system_perms
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>system_perms`;
	CREATE TABLE `<?=$prefix;?>system_perms` (
	  `perm_system_id` varchar(255) NOT NULL,
	  `perm_id` int(11) unsigned zerofill NOT NULL,
	  `perm_description` varchar(255) NOT NULL,
	  `perm_data` longtext NOT NULL,
	  `perm_addered_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  `perm_addered_by` varchar(99) DEFAULT NULL,
	  PRIMARY KEY (`perm_system_id`,`perm_id`),
	  UNIQUE KEY `perm_system_id` (`perm_system_id`,`perm_id`) USING BTREE,
	  KEY `perm_id` (`perm_id`) USING BTREE,
	  KEY `perm_addered_by` (`perm_addered_by`),
	  CONSTRAINT `<?=$prefix;?>system_perms_ibfk_1` FOREIGN KEY (`perm_addered_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>system_perms
	-- ----------------------------
	INSERT INTO `<?=$prefix;?>system_perms` VALUES ('administrator', '00000000000', 'a', '', CURRENT_TIMESTAMP, null);
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>system_roles
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>system_roles`;
	CREATE TABLE `<?=$prefix;?>system_roles` (
	  `role_id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
	  `role_name` text NOT NULL,
	  `role_perms_id` int(11) unsigned zerofill NOT NULL,
	  `role_gm` tinyint(1) NOT NULL,
	  `role_visible_name` text NOT NULL,
	  `role_modified_by` varchar(99) DEFAULT NULL,
	  `role_modified_on` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	  `role_addered_by` varchar(99) DEFAULT NULL,
	  `role_addered_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	  PRIMARY KEY (`role_id`),
	  KEY `role_perms_id` (`role_perms_id`),
	  KEY `role_modified_by` (`role_modified_by`),
	  KEY `role_addered_by` (`role_addered_by`),
	  CONSTRAINT `<?=$prefix;?>system_roles_ibfk_1` FOREIGN KEY (`role_perms_id`) REFERENCES `<?=$prefix;?>system_perms` (`perm_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `<?=$prefix;?>system_roles_ibfk_2` FOREIGN KEY (`role_modified_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `<?=$prefix;?>system_roles_ibfk_3` FOREIGN KEY (`role_addered_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>system_roles
	-- ----------------------------
	INSERT INTO `<?=$prefix;?>system_roles` VALUES ('00000000000', 'Banned', '00000000000', '0', '[BANNED]', null, null, null, '2016-11-06 20:38:37');
	INSERT INTO `<?=$prefix;?>system_roles` VALUES ('00000000001', 'Player', '00000000000', '0', '[player]', null, null, null, '2016-11-06 20:38:37');
	INSERT INTO `<?=$prefix;?>system_roles` VALUES ('00000000002', 'Moderator', '00000000000', '0', '[MOD]', null, null, null, '2016-11-06 20:38:37');
	INSERT INTO `<?=$prefix;?>system_roles` VALUES ('00000000003', 'Game Master', '00000000000', '1', '[GM]', null, null, null, '2016-11-06 20:38:37');
	INSERT INTO `<?=$prefix;?>system_roles` VALUES ('00000000004', 'Forum Moderator', '00000000000', '0', '[FORUM MOD]', null, null, null, '2016-11-06 20:38:37');
	INSERT INTO `<?=$prefix;?>system_roles` VALUES ('00000000005', 'Forum Game Master', '00000000000', '0', '[FORUM GM]', null, null, null, '2016-11-06 20:38:37');
	INSERT INTO `<?=$prefix;?>system_roles` VALUES ('00000000006', 'Hidden Game Master', '00000000000', '1', '[player]', null, null, null, '2016-11-06 20:38:37');
	INSERT INTO `<?=$prefix;?>system_roles` VALUES ('00000000007', 'Administrator', '00000000000', '2', '[ADMIN]', null, null, null, '2016-11-06 20:38:37');
	INSERT INTO `<?=$prefix;?>system_roles` VALUES ('00000000008', 'Forum Administrator', '00000000000', '1', '[FORUM ADMIN]', null, null, null, '2016-11-06 20:38:37');
	INSERT INTO `<?=$prefix;?>system_roles` VALUES ('00000000009', 'Hidden Administrator', '00000000000', '2', '[player]', null, null, null, '2016-11-06 20:38:37');
	INSERT INTO `<?=$prefix;?>system_roles` VALUES ('00000000010', 'Hidden Owner', '00000000000', '3', '[player]', null, null, null, '2016-11-06 20:38:37');
	INSERT INTO `<?=$prefix;?>system_roles` VALUES ('00000000011', 'Owner', '00000000000', '3', '[OWNER]', null, null, null, '2016-11-06 20:38:37');
	INSERT INTO `<?=$prefix;?>system_roles` VALUES ('00000000012', 'Hidden ROOT', '00000000000', '3', '[Player]', null, null, null, '2016-11-06 20:38:37');
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>user_data
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>user_data`;
	CREATE TABLE `<?=$prefix;?>user_data` (
	  `UUID` varchar(99) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `permission_level` int(11) UNSIGNED NOT NULL,
	  `UDATA` longtext CHARACTER SET utf8 COLLATE utf8_general_ci,
	  PRIMARY KEY (`UUID`) USING BTREE,
	  UNIQUE INDEX `UUID`(`UUID`) USING BTREE,
	  INDEX `permission_level`(`permission_level`) USING BTREE,
	  CONSTRAINT `flamecms_user_data_ibfk_2` FOREIGN KEY (`permission_level`) REFERENCES `flamenet_cmsv3`.`flamecms_system_roles` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `flamecms_user_data_ibfk_3` FOREIGN KEY (`UUID`) REFERENCES `flamenet_cmsv3`.`flamecms_user_login` (`UUID`) ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>user_data
	-- ----------------------------
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>user_login
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>user_login`;
	CREATE TABLE `<?=$prefix;?>user_login` (
	  `UUID` varchar(99) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `username` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `password` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `recovery_key` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	  `activation` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `enforcement` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `phone` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `ek01` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `ek02` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `ek03` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `ek04` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `ek05` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `ek06` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `ek07` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `ek08` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `ek09` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `ek10` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `email` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  `cellphone` text CHARACTER SET utf8 COLLATE utf8_general_ci,
	  `login_plane_data` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  PRIMARY KEY (`UUID`) USING BTREE,
	  UNIQUE INDEX `UUID`(`UUID`) USING BTREE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>user_login
	-- ----------------------------
	
	-- ----------------------------
	-- Table structure for <?=$prefix;?>user_messages
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>user_messages`;
	CREATE TABLE `<?=$prefix;?>user_messages` (
	  `UUID_sender` varchar(99) NOT NULL,
	  `UUID_receiver` varchar(99) NOT NULL,
	  `message_id` int(99) unsigned zerofill NOT NULL AUTO_INCREMENT,
	  `message_content` longtext NOT NULL,
	  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`UUID_sender`,`UUID_receiver`,`message_id`),
	  UNIQUE KEY `UUID_sender` (`UUID_sender`,`UUID_receiver`,`message_id`) USING BTREE,
	  UNIQUE KEY `message_id` (`message_id`) USING BTREE,
	  KEY `UUID_receiver` (`UUID_receiver`),
	  CONSTRAINT `<?=$prefix;?>user_messages_ibfk_1` FOREIGN KEY (`UUID_sender`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `<?=$prefix;?>user_messages_ibfk_2` FOREIGN KEY (`UUID_receiver`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of <?=$prefix;?>user_messages
	-- ----------------------------
	
	
	
	-- ----------------------------
	-- Table structure for `<?=$prefix;?>lang_list`
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>lang_list`;
	CREATE TABLE `<?=$prefix;?>lang_list` (
	  `langid` varchar(5) NOT NULL,
	  `lang_name` text NOT NULL,
	  `lang_flag_code` text NOT NULL,
	  `lang_changed_timestamp` int(10) unsigned zerofill DEFAULT NULL,
	  `lang_changed_by` varchar(99) DEFAULT NULL,
	  PRIMARY KEY (`langid`),
	  UNIQUE KEY `langid` (`langid`) USING BTREE,
	  KEY `lang_changed_by` (`lang_changed_by`),
	  CONSTRAINT `<?=$prefix;?>lang_list_ibfk_1` FOREIGN KEY (`lang_changed_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of sys_lang_list
	-- ----------------------------
	INSERT INTO `<?=$prefix;?>lang_list` VALUES ('en', 'English', 'en', null, null);
	INSERT INTO `<?=$prefix;?>lang_list` VALUES ('pt', 'Português', 'pt', null, null);
	
	-- ----------------------------
	-- Table structure for `<?=$prefix;?>lang_str`
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>lang_str`;
	CREATE TABLE `<?=$prefix;?>lang_str` (
	  `lid` varchar(64) NOT NULL,
	  `ostr` text NOT NULL,
	  `olan` varchar(5) NOT NULL,
	  `nlan` varchar(5) NOT NULL,
	  `nstr` text NOT NULL,
	  `lang_changed_timestamp` int(10) unsigned zerofill DEFAULT NULL,
	  `lang_changed_by` varchar(99) DEFAULT NULL,
	  PRIMARY KEY (`lid`,`olan`,`nlan`),
	  UNIQUE KEY `lid` (`lid`,`olan`,`nlan`) USING BTREE,
	  KEY `sys_lang_str_ibfk_1` (`olan`),
	  KEY `sys_lang_str_ibfk_2` (`nlan`),
	  KEY `lang_changed_by` (`lang_changed_by`),
	  CONSTRAINT `<?=$prefix;?>lang_str_ibfk_1` FOREIGN KEY (`olan`) REFERENCES `<?=$prefix;?>lang_list` (`langid`) ON DELETE NO ACTION ON UPDATE CASCADE,
	  CONSTRAINT `<?=$prefix;?>lang_str_ibfk_2` FOREIGN KEY (`nlan`) REFERENCES `<?=$prefix;?>lang_list` (`langid`) ON DELETE NO ACTION ON UPDATE CASCADE,
	  CONSTRAINT `<?=$prefix;?>lang_str_ibfk_3` FOREIGN KEY (`lang_changed_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	-- ----------------------------
	-- Records of `<?=$prefix;?>lang_str`
	-- ----------------------------
	
	-- ----------------------------
	-- Table structure for `<?=$prefix;?>servers`
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>servers`;
	CREATE TABLE `<?=$prefix;?>servers` (
	  `server_id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
	  `server_character` longtext NOT NULL,
	  `server_world` longtext NOT NULL,
	  `server_realm` longtext NOT NULL,
	  `server_active` tinyint(1) NOT NULL DEFAULT '1',
	  `server_type` int(11) unsigned zerofill NOT NULL,
	  `server_other_data` longtext NOT NULL,
	  `server_created_by` varchar(99) NOT NULL,
	  `server_created` int(11) NOT NULL,
	  `server_modified_by` varchar(99) DEFAULT NULL,
	  `server_modified` int(11) DEFAULT NULL,
	  PRIMARY KEY (`server_id`),
	  KEY `server_type` (`server_type`),
	  KEY `server_created_by` (`server_created_by`),
	  KEY `server_modified_by` (`server_modified_by`),
	  CONSTRAINT `<?=$prefix;?>servers_ibfk_1` FOREIGN KEY (`server_type`) REFERENCES `<?=$prefix;?>servers_types` (`server_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `<?=$prefix;?>servers_ibfk_2` FOREIGN KEY (`server_created_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `<?=$prefix;?>servers_ibfk_3` FOREIGN KEY (`server_modified_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of flamecms_servers
	-- ----------------------------
	
	-- ----------------------------
	-- Table structure for `<?=$prefix;?>servers_types`
	-- ----------------------------
	DROP TABLE IF EXISTS `<?=$prefix;?>servers_types`;
	CREATE TABLE `<?=$prefix;?>servers_types` (
	  `server_type_id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
	  `server_type_name` text NOT NULL,
	  `server_type_slug` varchar(6) NOT NULL,
	  `server_type_version` varchar(8) NOT NULL,
	  `server_type_created_by` varchar(99) NOT NULL,
	  `server_type_created` int(11) NOT NULL,
	  `server_type_modified_by` varchar(99) DEFAULT NULL,
	  `server_type_modified` int(11) DEFAULT NULL,
	  PRIMARY KEY (`server_type_id`),
	  CONSTRAINT `<?=$prefix;?>servers_type_ibfk_2` FOREIGN KEY (`server_type_created_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	  CONSTRAINT `<?=$prefix;?>servers_type_ibfk_3` FOREIGN KEY (`server_type_modified_by`) REFERENCES `<?=$prefix;?>user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	-- ----------------------------
	-- Records of flamecms_servers_types
	-- ----------------------------
	
	SET FOREIGN_KEY_CHECKS=1;
	
	<?php /* correction: 08/Jul/2017 20:03 */ ?>
	SET FOREIGN_KEY_CHECKS=0;
	
	ALTER TABLE `<?=$prefix;?>blog_content`
	ADD COLUMN `blog_language`  varchar(5) NULL AFTER `blog_child`,
	ADD COLUMN `blog_language_main`  int(11) UNSIGNED ZEROFILL NULL AFTER `blog_language`,
	ADD FOREIGN KEY (`blog_language_main`) REFERENCES `<?=$prefix;?>blog_content` (`blog_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
	
	SET FOREIGN_KEY_CHECKS=1;
	
	<?php
	$sql=ob_get_clean();
	return $sql;
}
