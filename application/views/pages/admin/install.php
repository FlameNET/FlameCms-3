<?php
/*FlameCMS CHECK*/
defined('FlameCMS') OR die('No script Cuddies');
if(!defined('page_redirect') || (defined('page_redirect') && (page_redirect!='admin/install')))
/*in the future, this will redirect to the home page, and if is admin, to the administration panel*/
die('Ups.... you shouldn\'t be here...');
?>
hi? this should be the installer