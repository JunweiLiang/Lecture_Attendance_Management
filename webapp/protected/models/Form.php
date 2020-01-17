<?php

/**
 * This is the model class for table "C_form".
 *
 * The followings are the available columns in table 'C_form':
 * @property integer $id
 * @property string $name
 * @property string $shoutkey
 * @property string $expiredTime
 * @property integer $isActive
 * @property integer $isReady
 * @property string $createTime
 * @property integer $createBy
 * @property string $picPath
 * @property integer $isDeleted
 */
class Form extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Form the static model class
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
		return 'C_form';
	}
	public function loadQuestions($formId)
	{
		// load the form's existing question 
		$sql = "SELECT C_choiceQuestion.* FROM C_choiceQuestion WHERE C_choiceQuestion.formId=:f AND C_choiceQuestion.isDeleted=0 ORDER BY C_choiceQuestion.id ASC";
		$questions = Text::sql($sql,array(":f"=>$formId));
		// get the answer
		foreach($questions as &$question)
		{
			$question['qId'] = $question['id'];
			$sql = "SELECT C_choiceAnswer.* FROM C_choiceAnswer WHERE C_choiceAnswer.qId=:q AND C_choiceAnswer.isDeleted=0 ORDER BY C_choiceAnswer.id ASC";
			$question['answers'] = Text::sql($sql,array(":q"=>$question['qId']));
		}
		return $questions;
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('createTime, createBy', 'required'),
			array('isActive, isReady, createBy, isDeleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>512),
			array('shoutkey', 'length', 'max'=>128),
			array('picPath', 'length', 'max'=>1024),
			array('expiredTime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, shoutkey, expiredTime, isActive, isReady, createTime, createBy, picPath, isDeleted', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'shoutkey' => 'Shoutkey',
			'expiredTime' => 'Expired Time',
			'isActive' => 'Is Active',
			'isReady' => 'Is Ready',
			'createTime' => 'Create Time',
			'createBy' => 'Create By',
			'picPath' => 'Pic Path',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('shoutkey',$this->shoutkey,true);
		$criteria->compare('expiredTime',$this->expiredTime,true);
		$criteria->compare('isActive',$this->isActive);
		$criteria->compare('isReady',$this->isReady);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('createBy',$this->createBy);
		$criteria->compare('picPath',$this->picPath,true);
		$criteria->compare('isDeleted',$this->isDeleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}