<?php
/*FlameCMS CHECK*/
defined('FlameCMS') OR die('No script Cuddies');
Class Page{
	function load($page)
	{
		$this->args_to_string($page);
		/*if triggered an redirect, cancel everything and go to page*/
		$this->validade_page_redirect($page);
		$ajax_check='';
		$temp=explode('/',$page);
		$ajax_check=$temp[0];
		unset($temp);
		if($ajax_check!='ajax'){
			
		}
		else{
			
		}
	}
	/*other....*/
	/*
	 * ****************************
	 * Function __subload : This is only for ajax, header, footer, 404 and other special pages
	 * **************************** 
	 */
	private function __subload($type,$page){
		if(($type=='ajax') || ($type=='special')){
			$load=$type.'/'.$page;
			convert_uri_string($load);
			get_inst()->load->view($load);
		}else{
			die('FOR SECURITY REASONS, THIS FUNCION ONLY ALLOWS AJAX AND SPECIAL TYPE PAGES');
		}
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
