<?php
defined('FlameCMS') or die('No Script Cuddies');
defined('ajaxload') or die('No Script Cuddies');

$sys=&get_inst();

?>
<div class="callout transparent">
	<div class="row">
		<div class="small-12 medium-6 medium-offset-3 large-4 large-offset-4 columns" align="center">
			<div class="installer installing-loader"></div>
			<div class="status" id="installer_status">
				<?=__('Feching Current Status...');?>
			</div>
		</div>
	</div>
</div>