<?php
$this->breadcrumbs=array(
	'Reset Employee Login ID',
	
);
?>
<div class="portlet box blue">
<div class="portlet-title"><i class="fa fa-openid"></i><span class="box-title">Reset Employee Login</span>
</div>
<?php
$dataProvider = $model->search();
if(Yii::app()->user->getState("pageSize",@$_GET["pageSize"]))
$pageSize = Yii::app()->user->getState("pageSize",@$_GET["pageSize"]);
else
$pageSize = Yii::app()->params['pageSize'];
$dataProvider->getPagination()->setPageSize($pageSize);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employee-transaction-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'ajaxUpdate'=>false,
	'columns'=>array(
		array(
		'header'=>'SI No',
		'class'=>'IndexColumn',
		),
		array(
		      'header' => 'Employee No',
		      'name' => 'employee_no',
	              'value' => '$data->Rel_Emp_Info->employee_no',
                     ),
		array(
		      'header' => 'Attendence Card No',
		      'name' => 'employee_attendance_card_id',
	              'value' => '$data->Rel_Emp_Info->employee_attendance_card_id',
                     ),
		 array(
		      'header' => 'Name',
		      'name' => 'employee_first_name',
	              'value' => '$data->Rel_Emp_Info->employee_first_name',
                     ),

		 array(
		      'header' => 'Surname',
		      'name' => 'employee_last_name',
	              'value' => '$data->Rel_Emp_Info->employee_last_name',
                     ),
		 
		 array(
			'header' => 'Designation',
			'name'=>'employee_transaction_designation_id',
			'value'=>'EmployeeDesignation::model()->findByPk($data->employee_transaction_designation_id)->employee_designation_name',
			'filter' =>CHtml::listData(EmployeeDesignation::model()->findAll(),
'employee_designation_id','employee_designation_name'),

		),
		array(
			'header' => 'Department',		
			'name'=>'employee_transaction_department_id',
			'value'=>'Department::model()->findByPk($data->employee_transaction_department_id)->department_name',
			'filter' =>CHtml::listData(Department::model()->findAll(),'department_id','department_name'),

		), 
		array(
			'header' => 'User Email ID',		
			'name'=>'user_organization_email_id',
			'value'=>'$data->Rel_user1->user_organization_email_id',

		), 		
		array('class'=>'CButtonColumn',
			'template' => '{Reset Loginid}',
	                'buttons'=>array(
                        'Reset Loginid' => array(
                                'label'=>'login id', 

				'url'=>'Yii::app()->createUrl("user/updateemploginid", array("id"=>$data->Rel_user1->user_id))',
                                'imageUrl'=> Yii::app()->baseUrl.'/images/Reset Password.png',  
                        ),
		   ),

		),		
	),
	'pager'=>array(
		'class'=>'AjaxList',
		'maxButtonCount'=>$model->count(),
		'header'=>''
	    ),
)); ?>
</div>
