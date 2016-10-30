<?php
if(!defined('preload') || (preload==false)):
?>
<?php 
if(defined('page_redirect') && (page_redirect=='admin/install'))
{
	?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>FlameCMS Installer</title>
		<!-- Enable Mobile View -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Installer Favicon -->
		<link rel="icon" href="<?=base_url('assets/imgs/flamecms/fav_normal.png');?>">
		<link rel="shortcut icon" href="<?=base_url('assets/imgs/flamecms/fav_normal.png');?>" type="assets/image/x-icon">
		<!--[if IE]><link rel="shortcut icon" href="<?=base_url('assets/imgs/flamecms/fav_icon.ico');?>"><![endif]-->
        <link rel="apple-touch-icon-precomposed" href="<?=base_url('assets/imgs/flamecms/fav_normal.png');?>">
		<meta name="msapplication-TileColor" content="#eee">
		<meta name="msapplication-TileImage" content="<?=base_url('assets/imgs/flamecms/fav_normal.png');?>">
		<?php head();?>
	</head>
	<body class="flamecms_installer">
		<header class="flame_cms_installer">
			<div class="flamecms_preset row">
				<div class="logo small-12 medium-4 large-2 columns">
					<img src="<?=base_url('assets/imgs/flamecms/logo.png');?>" width="100%">
				</div>
				<div class="title small-12 medium-4 large-3 columns">
					<h5>Installer</h5>
				</div>
			</div>
		</header>
		<content class="flamecms_installer">
<?php
}
else
{
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>/*the site title*/</title>
		<!-- Enable Mobile View -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php head();?>
	</head>
	<body>
		<header class="">
				
		</header>
		<content>
<?php
}
?>
<?php 
endif;
?>