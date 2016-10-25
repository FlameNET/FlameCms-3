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
 */
Class Pps{
 	
}