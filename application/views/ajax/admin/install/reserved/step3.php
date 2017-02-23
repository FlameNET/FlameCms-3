<?php
defined('FlameCMS') or die('No Script Cuddies');
defined('ajaxload') or die('No Script Cuddies');
$sys=&get_inst();
?>
<form method="POST" id="cms_server_configuration" data-abide novalidate>
	<div class="callout transparent">
		<div class="row">
			<div class="medium-3 columns">
				<ul class="tabs vertical" id="example-vert-tabs" data-tabs>
					<li>
						<label><?=__('Required');?></label>
					</li>
					<li class="tabs-title is-active">
						<a href="#cms_setup_init" aria-selected="true">
							<?=__('[CMS] Initiation of setup');?>
						</a>
					</li>
					<li class="tabs-title">
						<a href="#cms_mysql_con">
							<?=__('[CMS] Mysql Server Connection');?>
						</a>
					</li>
					<li class="tabs-title">
						<a href="#cms_admin_acc">
							<?=__('[CMS] Administrator Account');?>
						</a>
					</li>
				</ul>
			</div>
			<div class="medium-9 columns">
					<div class="tabs-content vertical" data-tabs-content="example-vert-tabs">
						<div class="tabs-panel is-active" id="cms_setup_init">
							<fieldset class="fieldset flamecms">
								<legend><?=__('[CMS] Initiation of setup');?></legend>
								<div class="row">
									<div class="small-12 medium-6 columns">
										<label for="cms_default_language_selection">
											<?=__('Default CMS Language');?>
										</label>
										<select required="required" id="cms_default_language_selection">
											<option value="cn">简体中文</option>
											<option value="de">Deutsch</option>
											<option value="es">Español</option>
											<option value="en" selected="selected">English</option>
											<option value="fr">Français</option>
											<option value="gr">ελληνικά</option>
											<option value="it">Italiano</option>
											<option value="ko">한국어</option>
											<option value="pt">Português</option>
											<option value="ru">Русский</option>
											<option value="tw">繁體中文</option>
										</select>
									</div>
									
									<script>
										function get_and_lock_current_lang(){
											var current_lang=$('#cms_default_language_selection');
											$('#languages_selection').find('input[type=checkbox]').each(function(){
												$(this).prop('checked', false);
												if($(this).hasAttr('disabled')){
													$(this).removeAttr('disabled');
												}
											});
											$('#multilang-'+current_lang.val()).attr('disabled','disabled').prop('checked',true);
										}
										$('#cms_default_language_selection').change(function(){
											get_and_lock_current_lang();
										});
										$('#multilanguage').change(function(){
											console.log('checkbox multilanguage change!');
											if($(this).is(':checked')){
												get_and_lock_current_lang();
												$('#languages_selection').slideDown();
											}
											else{
												$('#languages_selection').slideUp();
											}
										});
									</script>
									<div class="small-12 medium-6 columns">
										<label for="cms_domain">
											<?=__('Domain of this CMS');?>
										</label>
										<input type="url" id="cms_domain" required="required" placeholder="http://example.com"/>
									</div>
									
									<div class="small-12 medium-6 columns">
										<label for="cms_name">
											<?=__('CMS Public Name');?>
										</label>
										<input type="text" id="cms_name" required="required" placeholder="FlameCMS"/>
									</div>
									<div class="small-12 medium-6 columns">
										<label for="multilanguage"><?=__('Multi Language?');?></p>
										<div class="switch medium">
											<input class="switch-input" id="multilanguage" type="checkbox" name="multilanguage">
											<label class="switch-paddle" for="multilanguage">
												<span class="switch-active" aria-hidden="true"><?=__('Yes');?></span>
												<span class="switch-inactive" aria-hidden="true"><?=__('No')?></span>
											</label>
										</div>
									</div>
									<div class="small-12 columns">
										<div class="row" id="languages_selection" style="display:none;">
											<div class="medium-12 columns">
												<label>
													<?=__('Languages');?>
												</label>
												<span><?=__('Changing the default language will reset the language list (the checkboxes)');?></span>
											</div>
											<div class="medium-6 large-4 columns">
												<label >简体中文
													<input type="checkbox" id="multilang-cn" />	
												</label>
											</div>
											<div class="medium-6 large-4 columns">
												<label>Deutsch
													<input type="checkbox" id="multilang-de" />
												</label>
											</div>
											<div class="medium-6 large-4 columns">
												<label>Español
													<input type="checkbox" id="multilang-es" />
												</label>
											</div>
											<div class="medium-6 large-4 columns">
												<label>English
													<input type="checkbox" id="multilang-en" />
												</label>
											</div>
											<div class="medium-6 large-4 columns">
												<label>Français
													<input type="checkbox" id="multilang-fr" />
												</label>
											</div>
											<div class="medium-6 large-4 columns">
												<label>ελληνικά
													<input type="checkbox" id="multilang-gr" />
												</label>
											</div>
											<div class="medium-6 large-4 columns">
												<label>Italiano
													<input type="checkbox" id="multilang-it" />
												</label>
											</div>
											<div class="medium-6 large-4 columns">
												<label>한국어
													<input type="checkbox" id="multilang-ko" />
												</label>
											</div>
											<div class="medium-6 large-4 columns">
												<label>Português
													<input type="checkbox" id="multilang-pt" />
												</label>
											</div>
											<div class="medium-6 large-4 columns">
												<label>Русский
													<input type="checkbox" id="multilang-ru" />
												</label>
											</div>
											<div class="medium-6 large-4 columns">
												<label>繁體中文
													<input type="checkbox" id="multilang-tw" />
												</label>
											</div>
										</div>	
									</div>
								</div>
							</fieldset>
						</div>
						<div class="tabs-panel" id="cms_mysql_con">
							<fieldset class="fieldset flamecms">
								<legend><?=__('[CMS] Mysql Server Configuration');?></legend>
								<div class="callout" id="cms_mysql_check_message" style="display:none;">
								</div>
								<div class="row">
									<div class="small-12 medium-6 column">
										<label for="cms_mysql_con_host"><?=__('[CMS] Mysql Host');?></label>
										<input id="cms_mysql_con_host" required="" type="text" placeholder="<?=__('80.00.00.00 or flamecms.github.io');?>"/>
									</div>
									<div class="small-12 medium-6 column">
										<label for="cms_mysql_con_user"><?=__('[CMS] Mysql User');?></label>
										<input id="cms_mysql_con_user" required="" type="text" placeholder="<?=__('dbuser');?>"/>
									</div>
									<div class="small-12 medium-6 column">
										<label for="cms_mysql_con_pass"><?=__('[CMS] Mysql Password');?></label>
										<input id="cms_mysql_con_pass" nec="" required="" type="password" placeholder="<?=__('excelentPassword');?>"/>
									</div>
									<div class="small-12 medium-6 column">
										<label for="cms_mysql_con_port"><?=__('[CMS] Mysql Port');?></label>
										<input id="cms_mysql_con_port" required="" type="number" value="3306" placeholder="<?=__('Port');?>"/>
									</div>
									<div class="small-12 medium-6 column">
										<label for="cms_mysql_con_db"><?=__('[CMS] Database Name');?></label>
										<input id="cms_mysql_con_db" required="" type="text" value="" placeholder="<?=__('greatdb');?>"/>
									</div>
									<div class="small-12 medium-6 column">
										<label for="cms_mysql_con_prefix"><?=__('[CMS] Database Table Prefix');?></label>
										<input id="cms_mysql_con_prefix" type="text" value="" placeholder="<?=__('tableprexif_');?>"/>
									</div>
									<div class="small-12 medium-12 column">
										<a data-install-check-db="cms" class="uk-button tm-button-download">
											<?=__('Check [CMS] Mysql Settings');?>
										</a>
									</div>
									<script>
										$(document).ready(function(){
											$('a[data-install-check-db]').click(function(e){
												var cms=$('#cms_mysql_check_message');
												cms.slideUp();
												e.preventDefault();
												var data={};
												data['host']=$('#cms_mysql_con_host').val();
												data['user']=$('#cms_mysql_con_user').val();
												data['pass']=$('#cms_mysql_con_pass').val();
												data['port']=$('#cms_mysql_con_port').val();
												data['db']=$('#cms_mysql_con_db').val();
												$.ajax({
												    url:'<?=base_url('ajax/admin/install/reserved/check_mysql_settings');?>',
												    data:data,
												    method:'POST',
												    success:function(result){
												    	var data=JSON.parse(result);
												    	cms.html(data['message']);
												    	if(cms.hasClass('success') || cms.hasClass('warning') || cms.hasClass('alert'))
												    	{
												    		cms.removeClass('success').removeClass('warning').removeClass('alert');
												    		cms.addClass(data['callout']);
												    		cms.slideDown();
												    	}
												    	else{
												    		cms.addClass(data['callout']);
												    		cms.slideDown();
												    	}
												    },
												});
											});
										});
									</script>
								</div>
							</fieldset>
						</div>
						<div class="tabs-panel" id="cms_admin_acc">
							<fieldset class="fieldset flamecms">
								<legend><?=__('[CMS] Administrator Account');?></legend>
								<div class="row">
									<div class="small-12 medium-6 columns">
										<label for="cms_admin_account_username"><?=__('Admin Username');?></label>
										<input type="text" required="" id="cms_admin_account_username" placeholder="<?=__('Admin_username123')?>"/>
									</div>
									<div class="small-12 medium-6 columns">
										<label for="cms_admin_account_password"><?=__('Admin Password');?></label>
										<input type="password" required="" id="cms_admin_account_password" placeholder="<?=__('super_admin_p455w0rd')?>"/>
									</div>
									<div class="small-12 medium-6 columns">
										<label for="cms_admin_account_confirm_password"><?=__('Confirm the Admin Password');?></label>
										<input type="password" data-equalto="cms_admin_account_password" required="" id="cms_admin_account_confirm_password" placeholder="<?=__('super_admin_p455w0rd')?>"/>
									</div>
									<div class="small-12 medium-6 columns">
										<label for="cms_admin_account_email"><?=__('Admin Email');?></label>
										<input type="email" required="" id="cms_admin_account_email" placeholder="<?=__('admin@flamecms.github.io')?>">
									</div>
									<div class="small-12 medium-6 columns">
										<label for="cms_admin_account_fname"><?=__('Admin First Name');?></label>
										<input type="text" required="" id="cms_admin_account_fname" placeholder="<?=__('John')?>">
									</div>
									<div class="small-12 medium-6 columns">
										<label for="cms_admin_account_lname"><?=__('Admin Last Name');?></label>
										<input type="text" required="" id="cms_admin_account_lname" placeholder="<?=__('Doe')?>"/>
									</div>
								</div>
							</fieldset>
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
		<input type="hidden" id="step" value="step-3" required=""/>
		<div class="row">
			<div class="small-12 columns" >
				<div class="blank-space"></div>
				<div class="callout transparent">
					<div class="row">
						<div class="small-12 columns">
							<button id="form_installer_submit" type="submit" data-installer="step-3" class="uk-button tm-button-download float-right" type="submit" disabled="disabled"><?=__('Send Data');?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>