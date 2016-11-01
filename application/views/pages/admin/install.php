<?php
/*FlameCMS CHECK*/
defined('FlameCMS') OR die('No script Cuddies');
if(!defined('page_redirect') || (defined('page_redirect') && (page_redirect!='admin/install')))
/*in the future, this will redirect to the home page, and if is admin, to the administration panel*/
die('Ups.... you shouldn\'t be here...');
get_header();
$sys=&get_inst();
?>
<style>
	content.flamecms_installer{
	    background: #0AE821 url(<?=base_url('assets/imgs/flamecms/installer_background.png');?>) 50% 50% no-repeat;
	    padding: 120px 0;
    	display: block;
	}
	.tm-logo {
	    margin: -115px 0 -14px 0;
	}
	.shadow_text{
		font-size: 20px;
	    line-height: 26px;
	    font-weight: 300;
	    text-shadow: 1.5px 1.5px 1.5px #403b3b;
	    color:white;
	    margin-top: 15px;
	    margin-bottom: 15px;
	}
	.uk-button {
	    -webkit-appearance: none;
	    margin: 0;
	    border: none;
	    overflow: visible;
	    font: inherit;
	    text-transform: none;
	    display: inline-block;
	    -moz-box-sizing: border-box;
	    box-sizing: border-box;
	    vertical-align: middle;
	    min-height: 30px;
	    text-decoration: none;
	    text-align: center;
	    border: 1px solid rgba(0,0,0,.2);
	    border-bottom-color: rgba(0,0,0,.3);
	    background-origin: border-box;
	    background-image: -webkit-linear-gradient(top,#fff,#eee);
	    background-image: linear-gradient(to bottom,#fff,#eee);
	    border-radius: 4px;
	    text-shadow: 0 1px 0 #fff;
	}
	.tm-button-download {
	    margin: 10px 0 15px 0;
	    box-shadow: 1px 1px 1px rgba(0,0,0,0.1);
	    background: #fff;
	    border: none;
	    color: #D42B2B !important;
	    min-height: 50px;
	    padding: 0 30px;
	    
	    line-height: 50px;
	    font-size: 18px;
	}
	.tm-button-download:hover {
	    background: #dd0202;
	    color: #fff !important;
	    text-shadow: 0 1px 0 rgba(0,0,0,0.1);
	    -webkit-transition: background-color .15s ease-in-out;
	    transition: background-color .15s ease-in-out;
	}
	.uk-subnav {
	    padding: 0;
	    list-style: none;
	    font-size: 0;
	}
	.uk-subnav>li {
	    position: relative;
	    font-size: 1rem;
	    vertical-align: top;
	    display: inline-block;
	    margin: 0 5px;
	}
	.tm-subnav.uk-subnav a:not([class]) {
	    color: #fff !important;
	}
</style>
<div class="hidden" id="hidden_containers">
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
<div class="row installer_container">
	<div class="small-12 columns" id="body_ajax_loader">
		<div class="centered">
			<img class="tm-logo" src="<?=base_url('assets/imgs/flamecms/fav_normal.png');?>" title="FlameCMS" alt="FlameCMS" height="217" width="281">
			<p class="shadow_text"><?=__('Welcome to FlameCMS');?><br />
				<?=__('Content Management System for World of Warcraft Servers.');?>
			</p>
				<?php 
				$langs=$sys->ilang->get_langs();
				if(!empty($langs)):
						?>

			<div class="row">
				<?php 
				foreach($langs as $lid=>$lang):
				?>
				<a data-install-lang="<?=$lang['code']?>">
					<?=(($lang['flag']!='')?'<img src="'.$lang['flag'].'" width="16px" />':'');?> <?=$lang['name']?>
				</a>
				<?php
				endforeach;
				?>
			</div>
						<?php
				endif;
				?>
		</div>
		<div class="row">
			<div class="small-12 medium-6 columns">
				<a data-installer="step-1" class="uk-button tm-button-download float-right"><i class="fa fa-check-circle-o"></i> <?=__('Install Now');?></a>
			</div>
			<div class="small-12 medium-6 columns">
				<a href="https://google.com/" class="uk-button tm-button-download"> <?=__('No, Thanks');?></a>
			</div>
		</div>
		<div class="centered">
			<ul class="tm-subnav uk-subnav">
                <li><a href="https://github.com/FlameNET/FlameCMS/stargazers"><i class="fa fa-star"></i> <span data-uikit-stargazers="">3700</span> <?=__('Stargazers');?></a></li>
                <li><a href="https://github.com/FlameNET/FlameCMS-3"><i class="fa fa-github"></i> FlameCMS</a></li>
                <li><a href="https://twitter.com/FlameCMS"><i class="fa fa-twitter"></i> @FlameCMS</a></li>
                <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i> FlameCMS</a></li>
            </ul>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('a[data-install-lang]').click(function(e){
			e.preventDefault();
			var data={};
			data['lang']=$(this).attr('data-install-lang');
			$.ajax({
			    url:'<?=base_url('ajax/admin/install');?>',
			    data:data,
			    method:'POST',
			    success:function(){
			    	window.location.reload();
			    },
			});
		});
		$('a[data-installer],input[data-installer],button[data-installer]').live('click',function(e) {
			$ths=$(this);
			console.log('click');
			if($ths.is('input') || $ths.is('button')){
				if(($ths.hasAttr('type')) && ($ths.attr('type')=='submit')){
					$ths.closest("form").keycript('<?=base_url('ajax/admin/install');?>',function(result){
						
						$(document).foundation();
					});
				}
			}
			else{
				/*It's a 'A' tag from the init...*/
				var data={};
				data['step']=$ths.attr('data-installer');
				$.ajax({
				    url:'<?=base_url('ajax/admin/install');?>',
				    data:data,
				    method:'POST',
				    success:function(result){
				    	$('#body_ajax_loader').html(result);
				    	if(!$('#body_ajax_loader').hasClass('ajax_loaded'))
				    	{
				    		$('#body_ajax_loader').addClass('ajax_loaded');
				    	}
						$(document).foundation();
				    },
				});
			}
			$(document).foundation();
		});
	});
</script>
<?php 
get_footer();
?>