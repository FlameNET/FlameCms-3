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
				?><link rel="text/css" href="<?=(($style['ext']==false)?base_url('assets/'):'').$style['path'].'?v='.$style['version'];?>">
				<?php
			}
		}
		return ob_get_clean();
	}
}
/*Styles*/
function add_style($slug,$path,$external=false,$version){get_inst()->sas->add_style($slug,$path,$external,$version);}
function remove_style($slug){get_inst()->sas->remove_style($slug);}
function styles(){return get_inst()->sas->styles();}
