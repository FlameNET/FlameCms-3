<?php
defined('FlameCMS') or die('No Script Cuddies');
defined('ajaxload') or die('No Script Cuddies');
$sys=&get_inst();
$data=$sys->install->check();
?>
<div class="row callout transparent">
	<div class="small-12 columns">
		<div class="titleset primary">Application Requirements</div>
		<table>
		  <thead>
		    <tr>
		      <th width="200">Modules</th>
		      <th>Required Version</th>
		      <th width="150">Installed Version</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php foreach($data as $tc): ?>
		    <tr class="callout <?=(($tc['ok']==false)?'alert':'success')?>">
		      <td><?=$tc['label']?></td>
		      <td><?=((is_array($tc['cv']))?implode('/',$tc['cv']):$tc['cv']);?></td>
		      <td class=""><?=$tc['uv']?></td>
		    </tr>
		    <?php endforeach;?>
		  </tbody>
		</table>
	</div>
</div>
