<?php if(!defined('preload') || (preload==false)):?>
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