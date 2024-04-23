<div class="portlet box blue">
 <div class="portlet-title"><i class="fa fa-plus"></i><span class="box-title">Fill Details</span>
</div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employee-designation-form',
	'enableAjaxValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'employee_designation_name'); ?>
		<?php echo $form->textField($model,'employee_designation_name',array('size'=>25,'maxlength'=>60)); ?><span class="status">&nbsp;</span>
		<?php echo $form->error($model,'employee_designation_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'employee_designation_level'); ?>
		<?php echo $form->textField($model,'employee_designation_level',array('size'=>5,'maxlength'=>5)); ?><span class="status">&nbsp;</span>
		<?php echo $form->error($model,'employee_designation_level'); ?>
	</div>
</div><!-- form -->
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save',array('class'=>'submit')); ?>
		<?php echo CHtml::link('Cancel', array('admin'), array('class'=>'btnCan')); ?>	
	</div>

<?php $this->endWidget(); ?>

</div>
