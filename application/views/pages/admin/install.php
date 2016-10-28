<?php
/*FlameCMS CHECK*/
defined('FlameCMS') OR die('No script Cuddies');
if(!defined('page_redirect') || (defined('page_redirect') && (page_redirect!='admin/install')))
/*in the future, this will redirect to the home page, and if is admin, to the administration panel*/
die('Ups.... you shouldn\'t be here...');
get_header();
?>
<div class="row">
	<div class="small-12 columns">
		<div class="loader_flame row" style="height:500px">
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
</div>
<?php 
get_footer();
?>