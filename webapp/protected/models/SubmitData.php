<?php

/**
 * This is the model class for table "C_submitData".
 *
 * The followings are the available columns in table 'C_submitData':
 * @property integer $id
 * @property integer $formId
 * @property string $andrewId
 * @property string $name
 * @property string $submitTime
 * @property string $picData
 * @property string $answers
 */
class SubmitData extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubmitData the static model class
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
		return 'C_submitData';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('formId, andrewId, name, submitTime, picData, answers', 'required'),
			array('formId', 'numerical', 'integerOnly'=>true),
			array('andrewId', 'length', 'max'=>128),
			array('name', 'length', 'max'=>1024),
			array('picData, answers', 'length', 'max'=>2048),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, formId, andrewId, name, submitTime, picData, answers', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'formId' => 'Form',
			'andrewId' => 'Andrew',
			'name' => 'Name',
			'submitTime' => 'Submit Time',
			'picData' => 'Pic Data',
			'answers' => 'Answers',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('formId',$this->formId);
		$criteria->compare('andrewId',$this->andrewId,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('submitTime',$this->submitTime,true);
		$criteria->compare('picData',$this->picData,true);
		$criteria->compare('answers',$this->answers,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}