<?php
/*FlameCMS CHECK*/
defined('FlameCMS') OR die('No script Cuddies');
Class Languages{
	function set_language_code($code){
		$sys=&get_inst();
		if(is_lang_code($code)){
			$sys->session->lang=$code;
			return $code;
		}
		return false;
	}
	function current_lang_code(){
		$sys=&get_inst();
		$uri_lang_code=$this->is_lang_code($sys->uri->segment(1));
		$browser_lang=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		if($uri_lang_code==true){
			$sys->session->lang=$sys->uri->segment(1);
			return $sys->uri->segment(1);
		}
		elseif($this->is_lang_code($browser_lang)){
			return $browser_lang;
		}
		elseif(isset($sys->session->lang) && !empty($sys->session->lang) && $this->is_lang_code($sys->session->lang)){
			return $sys->session->lang;
		}
		else{
			$sys->session->lang='en';
			return 'en';
		}
	}
	function language_alternatives(){
		$sys=&get_inst();
		/*
		 * $sys->uri->uri_string()
		 * $this->is_lang_code($sys->uri->segment(0))
		 * */
		$q=$sys->db->get('lang_list');
		if($q->num_rows()!=0){
			$uri=$sys->uri->uri_string();
			if($uri!=''){
				$e=explode('/',$uri);
				if($this->is_lang_code($e[0])){
					unset($e[0]);
				}
				$nuri=implode('/',$e);
			}
			if(!isset($nuri))
			{
				$nuri='';
			}
			ob_start();
			foreach($q->result_array() as $languages){
				?>
				<link rel="alternate" href="<?=base_url($languages['langid'].'/'.$nuri)?>" hreflang="<?=base_url($languages['langid'].'/'.$nuri)?>" type="text/html">
				<?php
			}
			return ob_get_clean();
		}
		return '';
	}
	function get($text){
		$splitstring1 = substr($text, 0, floor(strlen($text) / 2));
		$splitstring2 = substr($text, floor(strlen($text) / 2));
		if (substr($splitstring1, 0, -1) != ' ' AND substr($splitstring2, 0, 1) != ' ')
		{$middle = strlen($splitstring1) + strpos($splitstring2, ' ') + 1;}
		else
		{$middle = strrpos(substr($text, 0, floor(strlen($text) / 2)), ' ') + 1;}
		$string1 = substr($text, 0, $middle);  // "The Quick : Brown Fox Jumped "
		$string2 = substr($text, $middle);  // "Over The Lazy / Dog"
		$strid=md5($string1).md5($string2);
		$sys=&get_inst();
		$q=$sys->db->get_where('lang_str',array('lid'=>$strid,'nlan'=>$this->current_lang_code()));
		if($q->num_rows()==0){
			$this->create($text);
		}else{
			$ret=$q->row_array();
			return $ret['nstr'];
		}
		return $this->get($text);
	}
	function create($text,$current='en',$new=''){
		if(empty($new)){$new=$this->current_lang_code();}
		$sys=&get_inst();
		$splitstring1 = substr($text, 0, floor(strlen($text) / 2));
		$splitstring2 = substr($text, floor(strlen($text) / 2));
		if (substr($splitstring1, 0, -1) != ' ' AND substr($splitstring2, 0, 1) != ' ')
		{$middle = strlen($splitstring1) + strpos($splitstring2, ' ') + 1;}
		else
		{$middle = strrpos(substr($text, 0, floor(strlen($text) / 2)), ' ') + 1;}
		$string1 = substr($text, 0, $middle);  // "The Quick : Brown Fox Jumped "
		$string2 = substr($text, $middle);  // "Over The Lazy / Dog"
		$strid=md5($string1).md5($string2);
		$sys->db->insert('lang_str',array(
				'lid'=>$strid,
				'olan'=>$current,
				'ostr'=>$text,
				'nstr'=>$text,
				'nlan'=>$new
			));
	}
	function is_lang_code($lang){
		$sys=&get_inst();
		$q=$sys->db->get_where('lang_list',array('langid'=>$lang));
		return ($q->num_rows()>0)?true:false;
	}
}
function __($str){
	return get_inst()->language->get($str);
}
function current_lang_code(){
	return get_inst()->language->current_lang_code();
}
function language_alternatives(){
	return get_inst()->language->language_alternatives();
}
function is_lang_code($lang){
	return get_inst()->language->is_lang_code($lang);
}
function set_language_code($code){
	return get_inst()->language->set_language_code($code);
}

