<?php
defined('FlameCMS') or die('No Script Cuddies');
defined('ajaxload') or die('No Script Cuddies');
$sys=&get_inst();
?>
<form method="POST"  data-abide novalidate>
	<div class="callout transparent">
		<div class="row collapse">
			<div class="medium-3 columns">
				<ul class="tabs vertical" id="example-vert-tabs" data-tabs>
					<li>
						<label>Required</label>
					</li>
					<li class="tabs-title is-active">
						<a href="#cms_setup_init" aria-selected="true">
							[CMS] Initiation of setup
						</a>
					</li>
					<li class="tabs-title">
						<a href="#cms_mysql_con">
							[CMS] Mysql Server Connection
						</a>
					</li>
					<li class="tabs-title">
						<a href="#cms_admin_acc">
							[CMS] Administrator Account
						</a>
					</li>
					<li>
						<label>Not Required</label>
					</li>
					<li class="tabs-title">
						<a href="#wow_tab">
							[WOW] Server Configuration and Realms
						</a>
					</li>
				</ul>
			</div>
			<div class="medium-9 columns">
					<div class="tabs-content vertical" data-tabs-content="example-vert-tabs">
						<div class="tabs-panel is-active" id="cms_setup_init">
							<fieldset class="fieldset flamecms">
								<legend>[CMS] Initiation of setup</legend>
								<div class="row">
									<div class="small-12 medium-6 columns">
										<div class="row">
											<label for="cms_default_language_selection">
												Default CMS Language
											</label>
											<select required="required" id="cms_default_language_selection">
												<option value="">Select A Language</option>
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
										<div class="row">
											<label for="multilanguage">Multi Language?</p>
											<div class="switch large">
												<input class="switch-input" id="multilanguage" type="checkbox" name="multilanguage">
												<label class="switch-paddle" for="multilanguage">
													<span class="switch-active" aria-hidden="true">Yes</span>
													<span class="switch-inactive" aria-hidden="true">No</span>
												</label>
											</div>
										</div>
									</div>
									<div class="small-12 medium-6 columns">
										<div class="row">
											<label for="cms_domain">
												Domain of this CMS
											</label>
											<input type="url" id="cms_domain" required="required" placeholder="http://example.com"/>
										</div>
										<div class="row">
											<div class="medium-12 columns">
												<label>
													Languages
												</label>
											</div>
											<div class="medium-6 columns">
												<label >简体中文
													<input type="checkbox" id="multilang-cn" required="required" />	
												</label>
											</div>
											<div class="medium-6 columns">
												<label>Deutsch
													<input type="checkbox" id="multilang-de" required="required" />
												</label>
											</div>
											<div class="medium-6 columns">
												<label>Español
													<input type="checkbox" id="multilang-es" required="required" />
												</label>
											</div>
											<div class="medium-6 columns">
												<label>English
													<input type="checkbox" id="multilang-en" required="required" />
												</label>
											</div>
											<div class="medium-6 columns">
												<label>Français
													<input type="checkbox" id="multilang-fr" required="required" />
												</label>
											</div>
											<div class="medium-6 columns">
												<label>ελληνικά
													<input type="checkbox" id="multilang-gr" required="required" />
												</label>
											</div>
											<div class="medium-6 columns">
												<label>Italiano
													<input type="checkbox" id="multilang-it" required="required" />
												</label>
											</div>
											<div class="medium-6 columns">
												<label>한국어
													<input type="checkbox" id="multilang-ko" required="required" />
												</label>
											</div>
											<div class="medium-6 columns">
												<label>Português
													<input type="checkbox" id="multilang-pt" required="required" />
												</label>
											</div>
											<div class="medium-6 columns">
												<label>Русский
													<input type="checkbox" id="multilang-ru" required="required" />
												</label>
											</div>
											<div class="medium-6 columns">
												<label>繁體中文
													<input type="checkbox" id="multilang-tw" required="required" />
												</label>
											</div>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="tabs-panel" id="cms_mysql_con">
							<fieldset class="fieldset flamecms">
								<legend>[CMS] Mysql Server Configuration</legend>
							</fieldset>
						</div>
						<div class="tabs-panel" id="cms_admin_acc">
							<fieldset class="fieldset flamecms">
								<legend>[CMS] Mysql Admin Account</legend>
							</fieldset>
						</div>
						<div class="tabs-panel" id="wow_tab">
							<fieldset class="fieldset flamecms">
								<legend>[WOW] Server Configurations and Realms</legend>
							</fieldset>
						</div>
					</div>
				
			</div>
		</div>
		
		<div class="row">
			<div class="small-12 columns" >
				<div class="blank-space"></div>
				<div class="callout transparent">
					<div class="row">
						<div class="small-12 columns">
							<button data-installer="step-2" class="uk-button tm-button-download float-right" type="submit" disabled="disabled">Send Data</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>