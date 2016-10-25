<?php
/*FlameCMS CHECK*/
defined('FlameCMS') OR die('No script Cuddies');
Class Page{
	function load($page)
	{
		/*if triggered an redirect, cancel everything and go to page*/
		$this->validade_page_redirect($page);
	}
	
	
	/*other....*/
	function validade_page_redirect($page){
		/*
		 * ********************************
		 * Cases of test:
		 * ********************************
		 * if this page is diferent of redirect
		 * if the uri contains the lang code, remove it and test
		 * */
		$v=array_pop(explode('/', $page));
		$v[0]=null;
		$t=implode('/',$v);
		if(defined('page_redirect') && ($page!=page_redirect) && ($t!=page_redirect))
		{
			 redirect(page_redirect);
		}
	}
}
