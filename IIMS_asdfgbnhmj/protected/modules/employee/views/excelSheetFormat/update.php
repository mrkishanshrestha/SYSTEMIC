<?php
$this->breadcrumbs=array(
	'Excel Sheet Formats'=>array('admin'),
	$model->excel_sheet_format_id,
	'Update',
);

$this->menu=array(
//	array('label'=>'', 'url'=>array('index')),
	array('label'=>'', 'url'=>array('create'),'linkOptions'=>array('class'=>'Create','title'=>'Create')),
	array('label'=>'', 'url'=>array('view', 'id'=>$model->excel_sheet_format_id),'linkOptions'=>array('class'=>'View','title'=>'View')),
	array('label'=>'', 'url'=>array('admin'),'linkOptions'=>array('class'=>'Manage','title'=>'Manage')),
);
?>

<h1>Update ExcelSheetFormat</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>