<?php
defined('FlameCMS') or die('No Script Cuddies');
defined('ajaxload') or die('No Script Cuddies');
$sys=&get_inst();
$data=$sys->install->check();
?>
<div class="row callout transparent">
	<div class="small-12 columns">
		<div class="titleset primary"><?=__('Application Requirements');?></div>
		<table>
		  <thead>
		    <tr>
		      <th width="200"><?=__('Modules');?></th>
		      <th><?=__('Required Version');?></th>
		      <th width="150"><?=__('Installed Version');?></th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php 
		  	$continue=true;
		  	foreach($data as $tc): 
				/*if one of the requirements aren't met...*/
		  	if($tc['ok']==false)
			{$continue=false;}
		  	?>
		    <tr class="callout <?=(($tc['ok']==false)?'alert':'success')?>">
		      <td><?=$tc['label']?></td>
		      <td><?=((is_array($tc['cv']))?implode('/',$tc['cv']):$tc['cv']);?></td>
		      <td class=""><?=$tc['uv']?></td>
		    </tr>
		    <?php endforeach;
		    ?>
		  </tbody>
		</table>
		<?php if($continue==true):
	    ?>
	    <div class="row">
	    	<!-- Unsatisfied requirement/s -->
	    	<div class="small-12 columns">
	    		<div class="callout success">
	    			<?=__('hey! look at the person who has the best Host provider!')?>
	    			<br />
	    			<?=__('Lets finish the install ok?');?>
	    			<br />
	    		</div>
	    		<a data-installer="step-2" class="uk-button tm-button-download float-right">
	    			<i class="fa fa-check-circle-o"></i>
	    			<?=__('Continue to Step 2');?>
	    		</a>
	    	</div>
	    </div>
	    <?php 
	    else:
	    ?>
	    <div class="row">
	    	<!-- Unsatisfied requirement/s -->
	    	<div class="small-12 columns">
	    		<div class="callout alert">
	    			<?=__('Ups... it apears that you have some unsatisfied requirements...');?>
	    			<br />
	    			<?=__('please talk to you host provider in order to install them.');?>
	    			<br />
	    		</div>
	    	</div>
	    </div>
	    <?php endif;?>
	</div>
</div>
