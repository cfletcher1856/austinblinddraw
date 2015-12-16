<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'f_name',array('class'=>'span5','maxlength'=>120)); ?>

	<?php echo $form->textFieldRow($model,'l_name',array('class'=>'span5','maxlength'=>120)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>120)); ?>

	<?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>15)); ?>

	<?php echo $form->dropDownListRow($model,'level', LevelLookUp::getLevelList(), array('class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model,'redirect', array('//director' => 'Director', '//admin' => 'Admin'), array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->checkBoxRow($model,'active'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
