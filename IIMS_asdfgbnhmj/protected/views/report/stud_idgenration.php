<?php
$this->breadcrumbs=array(
	'Generating Student Identity Card',
	
);
?>
<div class="portlet box blue">
<i class="icon-reorder"></i>
 <div class="portlet-title"><span class="box-title">Generating Student Identity Card</span>
</div>
<div class="form  two-coloumn">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stu-id-card',
	'enableAjaxValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true),

)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php
	$acd = Yii::app()->db->createCommand()
		->select('*')
		->from('academic_term')
		->where('current_sem=1')
		->queryAll();
	$acdterm=CHtml::listData($acd,'academic_term_id','academic_term_name');
	$period=array();
	if(!empty($acdterm)){	
	$pe_data = AcademicTermPeriod::model()->findByPk($acd[0]['academic_term_period_id']);
	$period[$pe_data->academic_terms_period_id] = $pe_data->academic_term_period; 
	}?>
	<div class="row">
		<?php echo $form->labelEx($model,'template_name'); ?>
<?php echo $form->dropDownList($model,'template_name',CHtml::listData(IdcardFieldFormat::model()->findAll(array('condition'=>'stud_emp_type="Student"','group'=>'idtemplate_name')),'idtemplate_name','idtemplate_name'), array('empty' => 'Select Template'));?>
	<span class="status">&nbsp;</span>
	<?php echo $form->error($model,'template_name'); ?>
	</div>
	<div class="row">
		<?php echo CHtml::label('Academic Year',''); ?>
		<?php echo CHtml::dropDownList('acdm_period', null,$period,array('empty' => 'Select Year','tabindex'=>2)); ?>
	</div>
	<div class="row">
		<?php echo CHtml::label('Semester',''); ?>
		<?php echo CHtml::dropDownList('acdm_name', null, $acdterm,array('empty' => 'Select Semester','tabindex'=>3));?>
	</div>
	<div class="row">
		<?php echo CHtml::label('Branch',''); ?>
		<?php echo CHtml::dropDownList('branch_name', null, Branch::items(),
		array(
			'prompt' => 'Select Branch','tabindex'=>4,
			'ajax' => array(
			'type'=>'POST', 
			'url'=>CController::createUrl('dependent/getIdDivision'), 
			'update'=>'#div_name', //selector to update
			
			))); ?>
	</div>
	<div class="row">
		<?php echo CHtml::label('Division',''); ?>
		<?php echo CHtml::dropDownList('div_name', null,array(), array('empty' => 'Select Division','tabindex'=>5));?>
	</div>
	<div class="row">
		<?php echo CHtml::label('Enroll No',''); ?>
		<?php echo CHtml::textField('enroll_no', null, array('empty' => 'Select Enroll No','tabindex'=>6,'size'=>13));?><span class="status">&nbsp;</span>&nbsp;&nbsp;
	</div>
	<div class="row">
		<?php echo CHtml::label('Roll No',''); ?>
		<?php echo CHtml::textField('roll_no', null, array('empty' => 'Select Roll No','tabindex'=>7,'size'=>13));?><span class="status">&nbsp;</span>&nbsp;&nbsp;
	</div>


<div class="row buttons">
	<?php echo CHtml::submitButton('Generate', array('class'=>'submit','name'=>'search','tabindex'=>8)); ?>
</div>
<?php $this->endWidget(); ?>
</div>
