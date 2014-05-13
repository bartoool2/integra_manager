<?php

/**
 * This is the model class for table "im_request_stack".
 *
 * The followings are the available columns in table 'im_request_stack':
 * @property integer $id
 * @property string $request_code
 * @property string $pass_code
 * @property string $additional_data
 * @property integer $status
 * @property string $time
 * @property integer $priority
 */
class Request extends CActiveRecord
{
	const CODE_DISARM = 1;
	const CODE_ARM = 2;
	const CODE_CLEAR_ALARM = 3;
	
	const STATUS_UNDONE = 0;
	const STATUS_DONE = 1;
	
	const PRIORITY_HIGH = 10;
	const PRIORITY_NORMAL = 5;
	const PRIORITY_LOW = 1;
	
	public $alias_disarm_zone1 = 1;
	public $alias_disarm_zone2 = 1;
	public $alias_disarm_zone3 = 1;
	public $alias_disarm_zone4 = 1;
	
	public $alias_arm_zone1 = 1;
	public $alias_arm_zone2 = 1;
	public $alias_arm_zone3 = 1;
	public $alias_arm_zone4 = 1;
	
	public $action_disarm = self::CODE_DISARM;
	public $action_arm = self::CODE_ARM;
	public $action_clear_alarm = self::CODE_CLEAR_ALARM;
	
	public $disarm_code;
	public $arm_code;
	public $clear_alarm_code;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'im_request_stack';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_code, additional_data, time', 'required'),
			array('status, priority', 'numerical', 'integerOnly'=>true),
			array('disarm_code, arm_code, clear_alarm_code', 'numerical', 'integerOnly'=>true, 'on'=>'Control'),
			array('request_code', 'length', 'max'=>45),
			array('pass_code', 'length', 'max'=>4),
			array('disarm_code, arm_code, clear_alarm_code', 'length', 'max'=>4, 'on'=>'Control'),
			array('additional_data', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('alias_disarm_zone1, alias_disarm_zone2, alias_disarm_zone3, alias_disarm_zone4, alias_arm_zone1, 
				alias_arm_zone2, alias_arm_zone3, alias_arm_zone4, action_disarm, action_arm, action_clear_alarm, 
				disarm_code, arm_code, clear_alarm_code', 
				'safe'),
			array('id, request_code, pass_code, additional_data, status, time, priority', 'safe', 'on'=>'search'),			
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
			'request_code' => 'Request Code',
			'pass_code' => 'Pass Code',
			'additional_data' => 'Additional Data',
			'status' => 'Status',
			'time' => 'Time',
			'priority' => 'Priority',
		);
	}
	
	public function saveNewRequest($type)
	{
		$this->request_code = $type;			
		
		$additionalData = array();
		if($this->request_code == Request::CODE_DISARM)
		{
			$this->pass_code = $this->disarm_code;
			if($this->alias_disarm_zone1)
			{
				array_push($additionalData, 1);
			}
			if($this->alias_disarm_zone2)
			{
				array_push($additionalData, 2);
			}
			if($this->alias_disarm_zone3)
			{
				array_push($additionalData, 3);
			}
			if($this->alias_disarm_zone4)
			{
				array_push($additionalData, 4);
			}
		}
		else if($this->request_code == Request::CODE_ARM)
		{
			$this->pass_code = $this->arm_code;
			if($this->alias_arm_zone1)
			{
				array_push($additionalData, 1);
			}
			if($this->alias_arm_zone2)
			{
				array_push($additionalData, 2);
			}
			if($this->alias_arm_zone3)
			{
				array_push($additionalData, 3);
			}
			if($this->alias_arm_zone4)
			{
				array_push($additionalData, 4);
			}
		}
		else if($this->request_code == Request::CODE_CLEAR_ALARM)
		{
			$this->pass_code = $this->clear_alarm_code;
		}
		
		$this->additional_data = json_encode($additionalData);
		$this->status = Request::STATUS_UNDONE;
		$this->time = date('Y-m-d H:i:s');
		$this->priority = Request::PRIORITY_HIGH;
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
		$criteria->compare('request_code',$this->request_code,true);
		$criteria->compare('pass_code',$this->pass_code,true);
		$criteria->compare('additional_data',$this->additional_data,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('priority',$this->priority);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Request the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
