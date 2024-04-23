<div class="portlet box blue">
 <div class="portlet-title"><i class="fa fa-plus"></i><span class="box-title">Fill Details</span>
</div>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-docs-trans-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($stud_doc,'doc_category_id'); ?>
		<?php echo $form->dropDownList($stud_doc,'doc_category_id',CHtml::listData(DocumentCategoryMaster::model()->findAll(),'doc_category_id','doc_category_name'),array('empty' => 'Select Category')); ?><span class="status">&nbsp;</span>
		<?php echo $form->error($stud_doc,'doc_category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($stud_doc,'title'); ?>
		<?php echo $form->textField($stud_doc,'title',array('size'=>17,'maxlength'=>20)); ?><span class="status">&nbsp;</span>
		<?php echo $form->error($stud_doc,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($stud_doc,'student_docs_desc'); ?>
		<?php echo $form->textArea($stud_doc,'student_docs_desc',array('rows'=>3,'cols'=>16)); ?><span class="status">&nbsp;</span>
		<?php echo $form->error($stud_doc,'student_docs_desc'); ?>
	</div>
	
	

	<div class="row">
		<?php echo $form->labelEx($stud_doc,'student_docs_submit_date'); ?>
		<?php 
			    $this->widget('CustomDatePicker', array(
			    'model'=>$stud_doc,
			    'attribute'=>'student_docs_submit_date',
			    'options'=>array(
			    'dateFormat'=>'dd-mm-yy',
			    'changeYear'=>'true',
			    'changeMonth'=>'true',
			    'showAnim' =>'slide',
			    'yearRange'=>'1900:'.(date('Y')+1),	
			    'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.png',           
			    ),
			    'htmlOptions'=>array(
			    'style'=>'width:165px;vertical-align:top'
			    ),
           
			));
			
		?>
		
		<span class="status">&nbsp;</span>
		<?php echo $form->error($stud_doc,'student_docs_submit_date'); ?>
	</div>
	
	<div class="row">	
		<?php echo $form->labelEx($stud_doc,'student_docs_path'); ?>
		<?php echo $form->fileField($stud_doc, 'student_docs_path',array('size'=>'15')); ?>
	      	<?php echo $form->error($stud_doc,'student_docs_path'); ?>
	</div>
	<div class="hint"><b>Hint:-</b>&nbsp;Upload Only Jpeg, Jpg, Pdf, Txt, Doc, Gif, Png Type Document</div>
	 <div>&nbsp;</div>
</div><!-- form -->
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('class'=>'submit')); ?>
 		<?php echo CHtml::link('Cancel', Yii::app()->request->urlReferrer , array('class'=>'btnCan')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
