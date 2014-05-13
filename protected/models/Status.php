<?php

/**
 * This is the model class for table "im_system_statuses".
 *
 * The followings are the available columns in table 'im_system_statuses':
 * @property integer $id
 * @property string $name
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property ImSystemStatusValues $status0
 */
class Status extends CActiveRecord
{
	const SYSTEM_STATUS = 1;
	const ZONE_1_STATUS = 2;
	const ZONE_2_STATUS = 3;
	const ZONE_3_STATUS = 4;
	const ZONE_4_STATUS = 5;
	
	const STATUS_DISARMED = 0;
	const STATUS_ARMED = 1;	
	const STATUS_TIME_TO_ENTER = 2;
	const STATUS_TIME_TO_LEAVE = 3;
	const STATUS_ALARM = 4;
	const STATUS_FIRE = 5;
	const STATUS_ALARM_REGISTERED = 6;
	const STATUS_FIRE_REGISTERED = 7;
        
	public function tableName()
	{
		return 'im_system_statuses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, status', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>80),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, status', 'safe', 'on'=>'search'),
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
			'_status' => array(self::BELONGS_TO, 'StatusValue', 'status'),
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
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Status the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getStatus($statusId)
        {
                $criteria=new CDbCriteria;

		$criteria->compare('id', $statusId);

		return self::model()->find($criteria);
        }
	
	public function getStatusClass()
	{
		switch($this->_status->value)
		{
			case self::STATUS_ARMED:
				return 'success';
			case self::STATUS_TIME_TO_ENTER:
			case self::STATUS_TIME_TO_LEAVE:
				return 'warning';
			case self::STATUS_ALARM:
			case self::STATUS_FIRE:
				return 'danger';
			case self::STATUS_ALARM_REGISTERED:
			case self::STATUS_FIRE_REGISTERED:
				return 'info';
			default:
				return '';
		}
	}
        
        public function getGraphic()
        {
                $result = Yii::app()->baseUrl.'/images/statuses/';
                $result .= $this->_status->value ? 'armed.png' : 'disarmed.png';
                
                return $result;
        }
}
