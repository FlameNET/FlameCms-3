<?php
defined('FlameCMS') or die('No Script Cuddies');

Class Install_langs{
	private static $langs=array();
	private static $current='';
	function lang_exists($lang_code){
		return (file_exists(APPPATH.'flamecms_installer_langs/'.$lang_code.'.php'));
	}
	function lang($lang_code){
		self::$current=$lang_code;
		if(!isset(self::$langs))
		{
			self::$langs=array();
		}
		if(!isset(self::$langs[$lang_code]))
		{
			self::$langs[$lang_code]=array();
		}
	}
	function define_name($code,$name,$flag=''){
		if(!isset(self::$langs))
		{
			self::$langs=array();
		}
		if(!isset(self::$langs[$code]))
		{
			self::$langs[$code]=array();
		}
		self::$langs[$code]['flag']='';
		if($flag!='')
		{
			self::$langs[$code]['flag']=$flag;
		}
		self::$langs[$code]['name']=$name;
		self::$langs[$code]['slug']=$code;
		if(!isset(self::$langs[$code]['strings']))
			self::$langs[$code]['strings']=array();
	}
	function add_line($original,$translated){
		$code=self::$current;
		if($translated=='')
			self::$langs[$code]['strings'][md5($original)]=$original;
		else
			self::$langs[$code]['strings'][md5($original)]=$translated;
	}
	function get_translated($original){
		$code=$this->get_installer_lang();
		return self::$langs[$code]['strings'][md5($original)];
	}
	function __($o){
		return $this->get_translated($o);
	}
	function get_installer_lang(){
		$sys=&get_inst();
		if(($sys->session->installer!==null) && ($sys->session->installer['lang']!==null)){
			return $sys->session->installer['lang'];
		}
		else{
			$uri_lang=substr($sys->uri->segment(1),0,2);
			$uri_lang_code=$this->lang_exists($uri_lang);
			$browser_lang=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			if($uri_lang_code==true){
				$this->set_installer_lang($uri_lang);
				return $uri_lang;
			}elseif($this->lang_exists($browser_lang)){
				$this->set_installer_lang($browser_lang);
				return $browser_lang;
			}else{
				//default lang
				$this->set_installer_lang('en');
				return $sys->session->installer['lang'];
			}
		}
	}
	function set_installer_lang($lang_code){
		$sys=&get_inst();
		if($sys->session->installer!==null){
			$data=array('lang'=>$lang_code);
			$sys->session->set_userdata('installer',$data);
		}
		else{
			$a=array();
			$a['lang']=$lang_code;
			$installer=$sys->session->get_userdata('installer');
			if(is_array($installer)){
				$sys->session->set_userdata('installer',array_merge($installer,$a));
			}else{
				$sys->session->set_userdata('installer',$a);
			}
		}
	}
	function get_langs(){
		$l=self::$langs;
		$langs=array();
		foreach($l as $lid=>$ln){
			$langs[$lid]=array(
				'name'=>$ln['name'],
				'flag'=>$ln['flag'],
				'code'=>$ln['slug']
			);
		}
		return $langs;
	}
}
function __g($o){return __($o);}
function __($o){
	return get_inst()->ilang->__($o);
}
function __s($o,$t){
	return get_inst()->ilang->add_line($o,$t);
}
