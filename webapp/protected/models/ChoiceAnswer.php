<?php

/**
 * This is the model class for table "C_choiceAnswer".
 *
 * The followings are the available columns in table 'C_choiceAnswer':
 * @property integer $id
 * @property integer $qId
 * @property string $text
 * @property integer $isCorrect
 * @property string $createTime
 * @property integer $createBy
 * @property integer $isDeleted
 */
class ChoiceAnswer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChoiceAnswer the static model class
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
		return 'C_choiceAnswer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('qId, text, createTime, createBy', 'required'),
			array('qId, isCorrect, createBy, isDeleted', 'numerical', 'integerOnly'=>true),
			array('text', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, qId, text, isCorrect, createTime, createBy, isDeleted', 'safe', 'on'=>'search'),
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
			'qId' => 'Q',
			'text' => 'Text',
			'isCorrect' => 'Is Correct',
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
		$criteria->compare('qId',$this->qId);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('isCorrect',$this->isCorrect);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('createBy',$this->createBy);
		$criteria->compare('isDeleted',$this->isDeleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}