<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tournament-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<input type="hidden" name="Tournament[creator]" value="<?php echo Yii::app()->user->getName(); ?>" />

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'date',array('class'=>'span5 datepicker')); ?>

	<?php echo $form->textFieldRow($model,'entry_fee',array('class'=>'span5 money_prepend','maxlength'=>10, 'prepend' => '$')); ?>

	<?php echo $form->textFieldRow($model,'bar_match',array('class'=>'span5 money_prepend','maxlength'=>10, 'prepend' => '$')); ?>

	<?php echo $form->textFieldRow($model,'xman',array('class'=>'span5 money_prepend','maxlength'=>10, 'prepend' => '$')); ?>

	<?php echo $form->textFieldRow($model,'num_of_boards',array('class'=>'span2','maxlength'=>10)); ?>

	<?php echo $form->dropDownListRow($model,'tournament_type', $model->tournamentTypeDropDown(), array('class'=>'span5','maxlength'=>10)); ?>

	<?php
		if(!$model->teams_selected())
		{
			echo $form->checkboxRow($model,'auto_generate_teams');
		}
	?>

	<table>
	<tr>
		<td style="width:115px">
			<label class="checkbox" for="Tournament_high_dart">
				<input id="ytTournament_high_dart" type="hidden" value="0" name="Tournament[high_dart]">
				<input name="Tournament[high_dart]" id="Tournament_high_dart" value="1" <?php if($model->high_dart): ?>checked="checked"<?php endif; ?> type="checkbox" />
				High Dart
			</label>
		</td>
		<td>
			<div class="input-prepend">
			    <span class="add-on">$</span><input type="text" name="Tournament[high_dart_fee]" class="input-mini money_prepend" value="<?php echo $model->high_dart_fee; ?>" />
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<label class="checkbox" for="Tournament_high_out">
				<input id="ytTournament_high_out" type="hidden" value="0" name="Tournament[high_out]">
				<input name="Tournament[high_out]" id="Tournament_high_out" value="1" <?php if($model->high_out): ?>checked="checked"<?php endif; ?> type="checkbox">
				High Out
			</label>
		</td>
		<td>
			<div class="input-prepend">
			    <span class="add-on">$</span><input type="text" name="Tournament[high_out_fee]" class="input-mini money_prepend" value="<?php echo $model->high_dart_fee; ?>" />
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<label class="checkbox" for="Tournament_mystery_out">
				<input id="ytTournament_mystery_out" type="hidden" value="0" name="Tournament[mystery_out]">
				<input name="Tournament[mystery_out]" id="Tournament_mystery_out" value="1" <?php if($model->mystery_out): ?>checked="checked"<?php endif; ?> type="checkbox">
				Mystery Out
			</label>
		</td>
		<td>
			<div class="input-prepend">
			    <span class="add-on">$</span><input type="text" name="Tournament[mystery_out_fee]" class="input-mini money_prepend" value="<?php echo $model->mystery_out_fee; ?>" />
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<label class="checkbox" for="Tournament_honey_pot">
				<input id="ytTournament_honey_pot" type="hidden" value="0" name="Tournament[honey_pot]">
				<input name="Tournament[honey_pot]" id="Tournament_honey_pot" value="1" <?php if($model->honey_pot): ?>checked="checked"<?php endif; ?> type="checkbox">
				Honey Pot
			</label>
		</td>
		<td>
			<div class="input-prepend">
			    <span class="add-on">$</span><input type="text" name="Tournament[honey_pot_fee]" class="input-mini money_prepend" value="<?php echo $model->honey_pot_fee; ?>" />
			</div>
		</td>
	</tr>
	</table>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
