<?php
/*FlameCMS CHECK*/
defined('FlameCMS') OR die('No script Cuddies');

/*this will set all the styles and scripts (called as a normal view)*/
add_style('foundation/min','css/foundation/foundation.min.css',false,'0.0.1');
add_style('foundation/icons','css/foundation/foundation-icons.css',false,'0.0.1');
add_style('font-awesome/min','css/font-awesome/font-awesome.min.css',false,'0.0.1');
add_style('flamecms/app','css/flamecms/app.css',false,'0.0.1');
/*main scripts*/
 
 /*header*/
add_script('jquery','js/jquery/jquery-2.2.2.js',false,true,array(),'0.0.1');
add_script('jquery/md5','js/jquery/jquery.md5.js',false,true,array(),'0.0.1');
add_script('jquery/migrate/min','js/jquery/jquery-migrate-1.4.1.min.js',false,true,array(),'0.0.1');
add_script('loader/flame','js/flamecms/loader_flame.js',false,true,array(),'0.0.1');

/*footer*/
add_script('foundation/min','js/foundation/foundation.min.js',false,false,array('jquery','mozilla/what-input'),'0.0.1');
add_script('mozilla/what-input','js/mozilla/what-input.js',false,false,array('jquery'),'0.0.1');
/*per page scripts includes*/
if(isset($sys->configuration->platform->pps) && (($sys->configuration->platform->pps=='2') || ($sys->configuration->platform->pps=='1')))
{
	/* ********************************
	 * include scripts for pps class
	 * ********************************
	 * includes list only
	 * ********************************/
}
else
{
	/* ********************************
	 * normal load
	 * ********************************
	 * include normaly all scripts
	 * *********************************/
}
