<?php

/**
 * This is the model class for table "employee_docs".
 * @package EduSec.modules.employee.models
 */
class EmployeeDocs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmployeeDocs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'employee_docs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_docs_path, doc_category_id, title,employee_docs_submit_date', 'required','message'=>''),
			
			array('employee_docs_desc', 'length', 'max'=>50),
			array('employee_docs_path', 'file', 'types'=>'jpeg, jpg, pdf, txt, doc, gif, png', 'maxSize'=>1024*1024*2, 'tooLarge'=>'The document was larger than 2MB. Please upload a smaller document.',),
			
			//array('title','CRegularExpressionValidator','pattern'=>'/^[a-zA-Z& ]+([-]*[a-zA-Z0-9 ]+)*$/','message'=>''),
			//array('employee_docs_desc','CRegularExpressionValidator','pattern'=>'/^([A-Za-z1-9 ]+)$/','message'=>''),
//			array('employee_docs_path', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employee_docs_id, employee_docs_desc, employee_docs_path, doc_category_id,employee_docs_submit_date, title', 'safe', 'on'=>'search'),
		);
	}


	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employee_docs_id' => 'Employee Docs',
			'employee_docs_desc' => 'Document Description',
			'employee_docs_path' => 'Document Path',
			'doc_category_id' => 'Document Category', 
			'title' => 'Title',
			'employee_docs_submit_date'=>'Submit Date'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('employee_docs_id',$this->employee_docs_id);
		$criteria->compare('doc_category_id',$this->doc_category_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('employee_docs_desc',$this->employee_docs_desc,true);
		$criteria->compare('employee_docs_path',$this->employee_docs_path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
