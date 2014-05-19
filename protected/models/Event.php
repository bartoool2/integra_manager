<?php

/**
 * This is the model class for table "im_events".
 *
 * The followings are the available columns in table 'im_events':
 * @property integer $id
 * @property integer $index_1
 * @property integer $index_2
 * @property integer $index_3
 * @property integer $call_index_1
 * @property integer $call_index_2
 * @property integer $call_index_3
 * @property string $time
 * @property string $description
 */
class Event extends CActiveRecord
{
	const CLASS_ZAT_ALARMS = 0;
	const CLASS_PAE_ALARMS = 1;
	const CLASS_ARM_DISARM_CLEAR = 2;
	const CLASS_BYPASSES = 3;
	const CLASS_ACCESS_CONTROL = 4;
	const CLASS_TROUBLES = 5;
	const CLASS_USER_FUNCTIONS = 6;
	const CLASS_SYSTEM_EVENTS = 7;
	
	public $alias_date_from = '';
	public $alias_date_to = '';
		
	
	public function tableName()
	{
		return 'im_events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('index_1, index_2, index_3, call_index_1, call_index_2, call_index_3, date, time', 'required'),
			array('index_1, index_2, index_3, call_index_1, call_index_2, call_index_3, class', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, index_1, index_2, index_3, call_index_1, call_index_2, call_index_3,
				 alias_date_from, alias_date_to, date, time, description, class', 'safe', 'on'=>'search'),
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
			'index_1' => 'Index 1',
			'index_2' => 'Index 2',
			'index_3' => 'Index 3',
			'call_index_1' => 'Call Index 1',
			'call_index_2' => 'Call Index 2',
			'call_index_3' => 'Call Index 3',
			'time' => 'Czas',
			'description' => 'Opis',
			'class'=>'Klasa zdarzenia',
			'alias_date_from'=>'Data od',
			'alias_date_to'=>'Data do'
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
		$criteria->compare('index_1',$this->index_1);
		$criteria->compare('index_2',$this->index_2);
		$criteria->compare('index_3',$this->index_3);
		$criteria->compare('call_index_1',$this->call_index_1);
		$criteria->compare('call_index_2',$this->call_index_2);
		$criteria->compare('call_index_3',$this->call_index_3);
//		$criteria->compare('time',$this->time,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('class',$this->class,true);
		
		if($this->alias_date_from != '')
		{
			$criteria->addCondition('date >= "'.$this->alias_date_from.'" ');
		}
		
		if($this->alias_date_to != '')
		{
			$criteria->addCondition('date <= "'.$this->alias_date_to.'" ');
		}
		
//		print_r($criteria);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Event the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getEventClasses()
	{
		return array(
			'blank'=>'',
			self::CLASS_ZAT_ALARMS=>'Alarmy z wejść i sabotażowe',
			self::CLASS_PAE_ALARMS=>'Alarmy ze stref i sabotażowe',
			self::CLASS_ARM_DISARM_CLEAR=>'Rozbrojenia i uzbrojenia',
			self::CLASS_BYPASSES=>'Blokady wejść',
			self::CLASS_ACCESS_CONTROL=>'Kontrola dostępu',
			self::CLASS_TROUBLES=>'Diagnostyka',
			self::CLASS_USER_FUNCTIONS=>'Użyte funkcje',
			self::CLASS_SYSTEM_EVENTS=>'Zdarzenia systemowe',
		);
	}
	
	public function getClassCssClass()
	{
		$classes = array(
			self::CLASS_ZAT_ALARMS=>'danger',
			self::CLASS_PAE_ALARMS=>'danger',
			self::CLASS_ARM_DISARM_CLEAR=>'success',
			self::CLASS_BYPASSES=>'warning',
			self::CLASS_ACCESS_CONTROL=>'success',
			self::CLASS_TROUBLES=>'warning',
			self::CLASS_USER_FUNCTIONS=>'info',
			self::CLASS_SYSTEM_EVENTS=>'info',
		);
		
		return $classes[$this->class];
	}
	
	public function getClassName()
	{
		$names = array(
			self::CLASS_ZAT_ALARMS=>'Alarmy z wejść i sabotażowe',
			self::CLASS_PAE_ALARMS=>'Alarmy ze stref i sabotażowe',
			self::CLASS_ARM_DISARM_CLEAR=>'Rozbrojenia i uzbrojenia',
			self::CLASS_BYPASSES=>'Blokady wejść',
			self::CLASS_ACCESS_CONTROL=>'Kontrola dostępu',
			self::CLASS_TROUBLES=>'Diagnostyka',
			self::CLASS_USER_FUNCTIONS=>'Użyte funkcje',
			self::CLASS_SYSTEM_EVENTS=>'Zdarzenia systemowe',
		);
		
		return $names[$this->class];
	}
}
