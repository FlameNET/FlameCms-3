<?php
/*FlameCMS CHECK*/
defined('FlameCMS') OR die('No script Cuddies');
/*Helper Functions | Class Not Used*/
class Hfs{
}
function includeall($dir){
	foreach (glob($dir."/*.php") as $filename)
	{
	    include_once $filename;
	}
}
function requireall($dir){
	foreach (glob($dir."/*.php") as $filename)
	{
	    require_once $filename;
	}
}
