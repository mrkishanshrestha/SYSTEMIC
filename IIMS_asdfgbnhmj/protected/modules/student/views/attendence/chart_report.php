<script>
$(document).ready(function(){
    $('select').change(function() {
        $(this).parents('form').submit();
    });
});
</script>
<?php
$this->breadcrumbs=array(
	'Chart Report',
);

?>
<div class="portlet box blue">
<i class="icon-reorder"></i>
 <div class="portlet-title"><span class="box-title">Select Criterias</span>
</div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'attendence-form',
	'enableAjaxValidation'=>true,

)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<?php echo $form->errorSummary($model); ?>		
	
	<div class="row">
		<?php echo $form->labelEx($model,'sem_id'); ?>
		<?php echo $form->dropDownList($model,'sem_id',AcademicTermPeriod::items(), array('empty' => 'Select Year','tabindex'=>1)); ?>
		
	</div>
	
	

<?php $this->endWidget(); ?>

</div><!-- form -->

</div>

