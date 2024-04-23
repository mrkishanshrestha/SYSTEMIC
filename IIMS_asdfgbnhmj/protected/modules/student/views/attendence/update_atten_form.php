<div class="portlet box blue">
<i class="icon-reorder"></i>
<div class="portlet-title"><span class="box-title">Faculty Timetable</span>
<div class="operation">
<?php echo CHtml::link('Back',array('admin'), array('class'=>'btnback'));?>
</div>
</div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'attendence-form',
	'enableAjaxValidation'=>false,
	//'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>
	
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="block-error">
		<?php echo Yii::app()->user->getFlash('not-select-attendece'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'attendence'); ?>
		<?php echo $form->dropDownList($model,'attendence',array("P"=>"Present","A"=>"Absent")); ?>
		<?php echo $form->error($model,'attendence'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
</div>
