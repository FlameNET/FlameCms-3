<?php
if(!defined('preload') || (preload==false)):
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>/*the site title*/</title>
		<?php head();?>
	</head>
	<body>
		<div class="hidden_presets">
			<div class="loader_flame">
				<div class="container">
				   <span class="particle lighter"></span>
				   <span class="particle light"></span>
				   <span class="particle light"></span>
				   <span class="particle lighter"></span>
				   <span class="particle dark"></span>
				   <span class="particle dark"></span>
				   <span class="particle light"></span>
				   <span class="particle dark"></span>
				   <span class="particle light"></span>
				   <span class="particle lighter"></span>
				   <span class="particle lighter"></span>
				   <span class="particle light"></span>
				   <span class="particle dark"></span>
				   <span class="particle dark"></span>
				   <span class="particle dark"></span>
				   <span class="particle dark"></span>
				   <span class="particle lighter"></span>
				   <span class="particle light"></span>
				   <span class="particle light"></span>
				   <span class="particle lighter"></span>
				   <span class="particle lighter"></span>
				   <span class="particle lighter"></span>
				   <span class="particle light"></span>
				   <span class="particle dark"></span>
				</div>
			</div>
		</div>
		<header class="<?=(defined('page_redirect') && (page_redirect=='admin/install'))?'flame_cms_installer':'';?>">
			<?php 
				if(defined('page_redirect') && (page_redirect=='admin/install'))
				{
					?>
						<div class="flamecms_preset row">
							<div class="logo small-12 medium-4 large-2 columns">
								<img src="<?=base_url('assets/imgs/flamecms/logo.png');?>" width="100%">
							</div>
							<div class="title small-12 medium-4 large-3 columns">
								<h5>Installer</h5>
							</div>
						</div>
					<?php
				}
				else
				{
					?>
						<ul class="vertical menu large-dropdown" data-responsive-menu="drilldown large-dropdown" style="width: 300px;">
						  <li>
						    <a href="#">Item 1</a>
						    <ul class="vertical menu">
						      <li>
						        <a href="#">Item 1A</a>
						        <ul class="vertical menu">
						          <li><a href="#">Item 1A</a></li>
						          <li><a href="#">Item 1B</a></li>
						          <li><a href="#">Item 1C</a></li>
						          <li><a href="#">Item 1D</a></li>
						          <li><a href="#">Item 1E</a></li>
						        </ul>
						      </li>
						      <li><a href="#">Item 1B</a></li>
						    </ul>
						  </li>
						  <li>
						    <a href="#">Item 2</a>
						    <ul class="vertical menu">
						      <li><a href="#">Item 2A</a></li>
						      <li><a href="#">Item 2B</a></li>
						    </ul>
						  </li>
						  <li>
						    <a href="#">Item 3</a>
						    <ul class="vertical menu">
						      <li><a href="#">Item 3A</a></li>
						      <li><a href="#">Item 3B</a></li>
						    </ul>
						  </li>
						</ul>
					<?php
				}
			?>
		</header>
		<content>
<?php 
endif;
?>