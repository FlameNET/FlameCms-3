<?php if(!defined('preload') || (preload==false)):?>
	<?php 
		if(defined('page_redirect') && (page_redirect=='admin/install'))
		{
		?>	
	<prefooter class="flamecms_installer2footer">
		<div class="flamecms_preset preset2 centered">
			<ul class="uk-subnav uk-subnav-line">
				<li><a href="https://github.com/FlameNET/">GitHub</a></li>
				<li><a href="https://github.com/FlameNET/FlameCMS-3/issues">Issues</a></li>
				<li><a href="https://twitter.com/FlameCMS">Twitter</a></li>
			</ul>
			<div class="uk-panel">
				<p>Made by <a href="http://flamenet.github.io/FlameCMS/">FlameNET</a> with love and caffeine.<br class="uk-hidden-small">Licensed under <a href="https://github.com/FlameNET/FlameCMS-3/blob/master/licence.txt">GNU license</a>.</p>
				<a href="http://flamenet.github.io/FlameCMS/">
				</a>
			</div>
		</div>
	</prefooter>
	<?php }?>
		</content>
	<footer  class="<?=(defined('page_redirect') && (page_redirect=='admin/install'))?'flame_cms_installer':'';?>">
		<?php 
				if(defined('page_redirect') && (page_redirect=='admin/install'))
				{
					?>
						<div class="flamecms_preset row">
							<div class="title small-9 medium-10 large-11 columns">
								<p>Copyright FlameCMS &copy;<br /> All rights Reserved</p>
							</div>
							<div class="logo small-3 medium-2 large-1 columns">
								<img src="<?=base_url('assets/imgs/flamecms/logo.png');?>" width="100%">
							</div>
						</div>
					<?php
				}
				else
				{
					?>
						
					<?php
				}
			?>
	</footer>
	<?php footer();?>
	</body>
</html>
<?php endif;?>