<?php

/**
 * This is the model class for table "C_formStats".
 *
 * The followings are the available columns in table 'C_formStats':
 * @property integer $id
 * @property string $statId
 * @property string $createTime
 * @property string $data
 * @property string $allAndrewIds
 * @property string $excuseNote
 */
class FormStats extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormStats the static model class
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
		return 'C_formStats';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('statId, createTime, data', 'required'),
			array('statId', 'length', 'max'=>256),
			array('allAndrewIds, excuseNote', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, statId, createTime, data, allAndrewIds, excuseNote', 'safe', 'on'=>'search'),
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
			'statId' => 'Stat',
			'createTime' => 'Create Time',
			'data' => 'Data',
			'allAndrewIds' => 'All Andrew Ids',
			'excuseNote' => 'Excuse Note',
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
		$criteria->compare('statId',$this->statId,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('allAndrewIds',$this->allAndrewIds,true);
		$criteria->compare('excuseNote',$this->excuseNote,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}