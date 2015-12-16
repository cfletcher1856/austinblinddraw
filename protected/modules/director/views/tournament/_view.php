<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('participants')); ?>:</b>
	<?php echo CHtml::encode($data->participants); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entry_fee')); ?>:</b>
	<?php echo CHtml::encode($data->entry_fee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bar_match')); ?>:</b>
	<?php echo CHtml::encode($data->bar_match); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('xman')); ?>:</b>
	<?php echo CHtml::encode($data->xman); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('auto_generate_teams')); ?>:</b>
	<?php echo CHtml::encode($data->auto_generate_teams); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('high_dart')); ?>:</b>
	<?php echo CHtml::encode($data->high_dart); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('high_out')); ?>:</b>
	<?php echo CHtml::encode($data->high_out); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('honey_pot')); ?>:</b>
	<?php echo CHtml::encode($data->honey_pot); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mystery_out')); ?>:</b>
	<?php echo CHtml::encode($data->mystery_out); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('high_dart_fee')); ?>:</b>
	<?php echo CHtml::encode($data->high_dart_fee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('high_out_fee')); ?>:</b>
	<?php echo CHtml::encode($data->high_out_fee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('honey_pot_fee')); ?>:</b>
	<?php echo CHtml::encode($data->honey_pot_fee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mystery_out_fee')); ?>:</b>
	<?php echo CHtml::encode($data->mystery_out_fee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creator')); ?>:</b>
	<?php echo CHtml::encode($data->creator); ?>
	<br />

	*/ ?>

</div>
