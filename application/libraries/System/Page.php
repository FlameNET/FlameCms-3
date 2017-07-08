<?php
/*FlameCMS CHECK*/
defined('FlameCMS') OR die('No script Cuddies');
Class Page{
	function load($page,$tostring=false,$page_redirect=false)
	{
		$sys=&get_inst();
		$this->args_to_string($page);
		/*if triggered an redirect, cancel everything and go to page*/
		$this->validade_page_redirect($page);
		$ajax_check='';
		$temp=explode('/',$page);
		$ajax_check=$temp[0];
		if(get_inst()->settings_cms->cms_theme=='default'){
			if(!file_exists(APPPATH.'views/page/'.$page.'.php')){
				if(is_dir(APPPATH.'views/page/'.$page.'')){
					$page.='/index';
				}
			}
		}else{
			if(!file_exists(APPPATH.'views/page_'.get_inst()->settings_cms->cms_theme.'/'.$page.'.php')){
				if(is_dir(APPPATH.'views/page_'.get_inst()->settings_cms->cms_theme.'/'.$page.'')){
					$page.='/index';
				}
			}
		}
		if(($ajax_check!='ajax') && ($ajax_check!='assets')){
			get_inst()->load->view('styles_and_scripts');
			//unset($temp);
			/*precheck if exists, if don't, maybe is the lang code?*/
			$uri=implode('/',$temp);
			unset($temp);
			/* Check to see if it is an language::: disabled because Languages Class don't exist yet*/
			if(($this->exists($uri)==true)/* && ($sys->lang->is_language_code($ajax_check)==true)*/){
				get_inst()->pps->init($uri);
			}else{
				/*here, it does not matter if is exists or not... the pps will automaticly see it*/
				get_inst()->pps->init($page);
			}
		}
		elseif($ajax_check!='assets'){
			unset($temp[0]);
			$page=implode('/',$temp);
			unset($temp);
			return $this->__subload('ajax', $page, $tostring,$page_redirect);
		}
	}
	function load_404($special_call=false){
		if($special_call==false)
			$this->__subload('special','the_404');
		else
			return $this->__subload('special','the_404',true);
	}
	function get_header(){
		return $this->__subload('special','header');
	}
	function get_footer(){
		return $this->__subload('special','footer');
	}
	/*other....*/
	/*
	 * ****************************
	 * Function __subload : This is only for ajax, header, footer, 404 and other special pages
	 * **************************** 
	 */
	private function __subload($type,$page,$special_call=false,$page_redirect=false){
		if(($type=='ajax') || ($type=='special')){
			
			$load=$type.'/'.$page;
			$this->convert_uri_string($load);
			if($special_call===false){
				get_inst()->load->view($load);
			}
			elseif(!is_bool($special_call) && is_array($special_call)){
				/*ok, maybe we have vars to be loaded here.... so... let's try to load them*/
				if($page_redirect==false){
					return get_inst()->load->view($load, $special_call);
				}else{
					return get_inst()->load->view($load, $special_call,true);
				}
			}else{
				return get_inst()->load->view($load, '', true);
			}
		}else{
			die('FOR SECURITY REASONS, THIS FUNCION ONLY ALLOWS AJAX AND SPECIAL TYPE PAGES');
		}
	}
	function exists($uri){
		$dr=APPPATH.'views/'.$uri;
		$this->convert_uri_string($dr);
		if(file_exists($dr.'.php')){return true;}return false;
	}
	function convert_uri_string(&$uri){
		$d=DIRECTORY_SEPARATOR;
		if($d=='/'){
			/*Linux*/
			if(strpos($uri,'\\')){
				$uri=str_replace('\\', $d, $uri);
			}
		}else{
			/*Windows*/
			if(strpos($uri,'/')){
				$uri=str_replace('/', $d, $uri);
			}
		}
	}
	private function args_to_string(&$page)
	{
		if(is_array($page)){
			$page=implode('/',$page);
		}
	}
	private function validade_page_redirect($page){
		/*
		 * ********************************
		 * Cases of test:
		 * ********************************
		 * if this page is diferent of redirect
		 * if the uri contains the lang code, remove it and test
		 * if isn't 404
		 * */
		$v=explode('/', $page);
		$type=$v[0];
		unset($v[0]);
		$t=implode('/',$v);
		if(defined('page_redirect'))
		{
			if($type!='ajax')
				if($page!='404')
					if($t!='404')
						if($page!=page_redirect)
							if($t!=page_redirect)
			 					redirect(page_redirect);
		}
	}
}
function convert_uri_string(&$uri){
	get_inst()->page->convert_uri_string($uri);
}
function get_header(){
	get_inst()->page->get_header();
}
function get_footer(){
	get_inst()->page->get_footer();
}
