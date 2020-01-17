<?php

/**
 * This is the model class for table "C_choiceQuestion".
 *
 * The followings are the available columns in table 'C_choiceQuestion':
 * @property integer $id
 * @property integer $formId
 * @property string $text
 * @property integer $isSingleChoice
 * @property string $createTime
 * @property integer $createBy
 * @property integer $isDeleted
 */
class ChoiceQuestion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChoiceQuestion the static model class
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
		return 'C_choiceQuestion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('formId, text, createTime, createBy', 'required'),
			array('formId, isSingleChoice, createBy, isDeleted', 'numerical', 'integerOnly'=>true),
			array('text', 'length', 'max'=>2048),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, formId, text, isSingleChoice, createTime, createBy, isDeleted', 'safe', 'on'=>'search'),
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
			'text' => 'Text',
			'isSingleChoice' => 'Is Single Choice',
			'createTime' => 'Create Time',
			'createBy' => 'Create By',
			'isDeleted' => 'Is Deleted',
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
		$criteria->compare('text',$this->text,true);
		$criteria->compare('isSingleChoice',$this->isSingleChoice);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('createBy',$this->createBy);
		$criteria->compare('isDeleted',$this->isDeleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}