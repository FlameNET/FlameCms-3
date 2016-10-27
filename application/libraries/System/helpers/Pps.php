<?php
/*FlameCMS CHECK*/
defined('FlameCMS') OR die('No script Cuddies');
/*
 * ********************************
 * Class : Pps -> per page script
 * ********************************
 * Fase Alpha 0.0.1
 * ********************************
 * Purpose: (db setting)
 * 	1.1 - try to reduce the number of scripts loaded per page request
 * 	1.2 - Speed up presentation of the Website
 * 	OR
 * 	2.1 - set header cache by md5( FILE_DATE )
 * 	OR
 * 	3	- Disabled
 * ********************************
 * Problems of this implementation: (1.*)
 * the output files (pages) have to set the scripts : (slow CODDING)
 * OR
 * the output file is under an OB_start and ob_get_clean()
 * and to detect features, have to have:
 * 		class identifing js feature
 * 		attribute identifing js feature
 * 		etc... 
 * 	To detect:
 * 		the code is runned by a preg_match and foreach
 * 		if any found, includes automaticly
 * 	(FASTER CODDING, SLOWER PLATFORM)
 * 
 * Problems of this implementation: (2.*)
 * 	All files (JS/IMG/CSS) are cached and the first load is very slow
 *  
 * Problems of this implementation: (3.*)
 * 	Depend from browser to Browser
 * ********************************
 * any of this are applied on install
 */
Class Pps{
 	function init($page){
 		/*if install*/
 		$sys=&get_inst();
 		if(defined('page_redirect') && (page_redirect=='admin/install'))
 		{
 			$this->impl3($page);
			return;
 		}
		elseif(isset($sys->configuration->platform->pps) && ($sys->configuration->platform->pps=='1')){$this->impl1($page);return;}
		elseif(isset($sys->configuration->platform->pps) && ($sys->configuration->platform->pps=='2')){$this->impl2($page);return;}
		else{$this->impl3($page);return;}
 	}
	/*Implementation 3: OK*/
	function impl3($page){
		$uri='pages/'.$page;
		get_inst()->page->convert_uri_string($uri);
		if(get_inst()->page->exists($uri)){
			get_inst()->load->view($uri);
			
			return true;
		}
		get_inst()->page->load_404();
		return false;
	}
	function impl2($page){
		$uri='pages/'.$page;
		get_inst()->page->convert_uri_string($uri);
		if(get_inst()->page->exists($uri)){
			define('preload',true,false);
			$html = get_inst()->load->view($uri, '', true);
			define('preload',false,false);
			
			/*end*/
			return;
		}
		$html = get_inst()->page->load_404(true);
		/* ********************************
		 * To Be continued....
		 * ********************************/
	}
	function impl1($page){
		$uri='pages/'.$page;
		get_inst()->page->convert_uri_string($uri);
		if(get_inst()->page->exists($uri)){
			define('preload',true,false);
			$html = get_inst()->load->view($uri, '', true);
			define('preload',false,false);
			
			/*end*/
			return;
		}
		$html = get_inst()->page->load_404(true);
		
		/* ********************************
		 * To Be continued....
		 * ********************************/
	}
	static $scripts;
	function pre_load_scripts($scripts){
		$scr=self::$scripts;
		if(!is_array($src)){$src=array();}
		foreach($scripts as $script){
			if(!isset($src[$script['slug']])){
				$src[$script['slug']]=$script;
			}
		}
	}
}