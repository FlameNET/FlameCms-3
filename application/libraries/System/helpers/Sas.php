<?php
/*FlameCMS CHECK*/
defined('FlameCMS') OR die('No script Cuddies');
/*
 * ********************************
 * Class : Sas -> Styles and Scrips
 * ********************************
 */
class Sas{
	static $styles;
	static $scripts;
	function add_style($slug,$path,$external=false,$version)
	{
		$styles=self::$styles;
		if(!isset($styles) && !is_array($styles))
		{
			$styles=array();
		}
		$styles[$slug]=array(
			'slug'=>$slug,
			'path'=>$path,
			'version'=>$version,
			'ext'=>$external
		);
		self::$styles=$styles;
		return true;
	}
	function remove_style($slug)
	{
		$styles=self::$styles;
		if(!isset($styles) && !is_array($styles))
		{
			return;
		}
		$styles[$slug]=null;
		unset($styles[$slug]);
		self::$styles=$styles;
		return true;
	}
	function styles(){
		$styles=self::$styles;
		ob_start();
		if(!empty($styles)){
			foreach($styles as $style){
				?><link type="text/css" rel="stylesheet" href="<?=(($style['ext']==false)?base_url('assets/'):'').$style['path'].'?v='.$style['version'];?>">
				<?php
			}
		}
		return ob_get_clean();
	}
	/*Scripts Routines*/
	function add_script($slug,$path,$external=false,$location=false,$requires=array(),$version=''){
		
		$scripts=self::$scripts;
		if(!isset($scripts) && !is_array($scripts))
		{
			$scripts=array();
		}
		$scripts[$slug]=array(
			'slug'=>$slug,
			'path'=>$path,
			'version'=>$version,
			'ext'=>$external,
			'requires'=>$requires,
			'location'=>$location
		);
		self::$scripts=$scripts;
		return true;
	}
	function remove_script($slug){
		
		$scripts=self::$scripts;
		if(!isset($scripts) && !is_array($scripts))
		{
			return;
		}
		$scripts[$slug]=null;
		unset($scripts[$slug]);
		self::$scripts=$scripts;
		return true;
	}
	function scripts_head(){
		$scripts=self::$scripts;
		if(!isset($scripts) && !is_array($scripts))
		{
			return;
		}
		return $this->scripts_head_helper($scripts);
	}
	function scripts_footer(){
		$scripts=self::$scripts;
		if(!isset($scripts) && !is_array($scripts))
		{
			return;
		}
		return $this->scripts_footer_helper($scripts);
	}
	static $loaded;
	static $temp;
	static $scripts_header_return;
	private function scripts_head_helper($scripts){
		
		$loaded=self::$loaded;
		$temp=self::$temp;
		$scripts_header_return=self::$scripts_header_return;
		if(!is_string($scripts_header_return))
		{$scripts_header_return='';}
		if(!is_array($loaded)){
			$loaded=array();
			self::$loaded=$loaded;
		}
		if(!is_array($temp)){
			$temp=array();
			self::$temp=$temp;
		}
		foreach($scripts as $script){
			if($script['location']==true){
				$requires=$script['requires'];
				if(!empty($requires))
				{
					foreach($requires as $requriement){
						if(isset($loaded[$requriement]) && ($loaded[$requriement]==true)){
							continue;
						}
						elseif(!isset($scripts[$requriement])){
							continue;
						}
						$temp[$script['slug']]=$script;
						break;
					}
				}
				if(!isset($temp[$script['slug']]))
				{
					ob_start();
					?>
					<script type="text/javascript" src="<?=(($script['ext']==false)?base_url('assets/'):'').$script['path'].'?v='.$script['version'];?>"></script><?php
					$scripts_header_return.=ob_get_clean();
				}
				$loaded[$script['slug']]=true;
			}
		}
		self::$scripts_header_return=$scripts_header_return;
		self::$loaded=$loaded;
		if(count($temp)>0)
		{
			$this->scripts_head_helper($temp);
		}
		$scripts_header_return=self::$scripts_header_return;
		return $scripts_header_return;
	}
	static $scripts_footer_return;
	private function scripts_footer_helper($scripts){
		
		$loaded=self::$loaded;
		$temp=self::$temp;
		$scripts_footer_return=self::$scripts_footer_return;
		if(!is_string($scripts_footer_return)){$scripts_footer_return='';}
		if(!is_array($loaded)){
			$loaded=array();
			self::$loaded=$loaded;
		}
		if(!is_array($temp)){
			$temp=array();
			self::$temp=$temp;
		}
		foreach($scripts as $script){
			if($script['location']==false){
				$requires=$script['requires'];
				if(!empty($requires))
				{
					foreach($requires as $requriement){
						if(isset($loaded[$requriement]) && ($loaded[$requriement]==true)){
							continue;
						}
						elseif(!isset($scripts[$requriement])){
							continue;
						}
						$temp[$script['slug']]=$script;
						break;
					}
				}
				if(!isset($temp[$script['slug']]))
				{
					ob_start();
					?>
					<script type="text/javascript" src="<?=(($script['ext']==false)?base_url('assets/'):'').$script['path'].'?v='.$script['version'];?>"></script><?php
					$scripts_footer_return.=ob_get_clean();
				}
				$loaded[$script['slug']]=true;
			}
		}
		self::$loaded=$loaded;
		self::$scripts_footer_return=$scripts_footer_return;
		if(count($temp)>0)
		{
			$this->scripts_footer_helper($temp);
		}
		$scripts_footer_return=self::$scripts_footer_return;
		return $scripts_footer_return;
	}
}
/*Styles*/
function add_style($slug,$path,$external=false,$version){get_inst()->sas->add_style($slug,$path,$external,$version);}
function remove_style($slug){get_inst()->sas->remove_style($slug);}
function styles(){return get_inst()->sas->styles();}
function add_script($slug,$path,$external=false,$location=false,$requires=array(),$version=''){	return get_inst()->sas->add_script($slug,$path,$external,$location,$requires,$version);}
function remove_script($slug){return get_inst()->sas->remove_script($slug);}
function scripts_head(){return get_inst()->sas->scripts_head();}
function scripts_footer(){return get_inst()->sas->scripts_footer();}
function head(){echo styles().scripts_head();}
function footer(){echo scripts_footer();}
