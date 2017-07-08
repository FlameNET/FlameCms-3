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
<script>
	$(document).ready(function(){
		$(document).on('formvalid.zf.abide',function(e){
			var sub=$('#form_installer_submit');
			if(sub.hasAttr('disabled')){
				sub.removeAttr('disabled');
			}
		}).on('forminvalid.zf.abide',function(e){
			var sub=$('#form_installer_submit');
			if(!sub.hasAttr('disabled')){
				sub.attr('disabled','disabled');
			}
		});
		$('#cms_server_configuration input[required],#cms_server_configuration select[required]').change(function(e){
			var form=$('#cms_server_configuration');
			var v=form.foundation('validateForm');
		});
	});
</script>
<form method="POST" id="cms_server_configuration" data-abide novalidate>
		<input type="hidden" id="step" value="step-3-reload" required=""/>
		<div class="row">
			<div class="small-12 columns" >
				<div class="blank-space"></div>
				<div class="callout transparent">
					<div class="row">
						<div class="small-12 columns">
							<button id="form_installer_submit" type="submit" data-installer="step-3" class="uk-button tm-button-download float-right" type="submit" disabled="disabled">Resend Previous Data</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>