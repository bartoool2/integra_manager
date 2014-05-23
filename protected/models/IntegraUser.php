<?php

/**
 * This is the model class for table "im_integra_users".
 *
 * The followings are the available columns in table 'im_integra_users':
 * @property integer $id
 * @property integer $number
 * @property integer $type
 * @property string $name
 * @property integer $rights_1
 * @property integer $rights_2
 * @property integer $rights_3
 *
 * The followings are the available model relations:
 * @property ImUserRights[] $imUserRights
 * @property ImUserZones[] $imUserZones
 */
class IntegraUser extends CActiveRecord
{
	const TYPE_NORMAL = 0;
	const TYPE_SINGLE = 1;
	const TYPE_TIME_RENEWABLE = 2;
	const TYPE_TIME_NOT_RENEWABLE = 3;
	const TYPE_DURESS = 4;
	const TYPE_MONO_OUTPUTS = 5;
	const TYPE_BI_OUTPUTS = 6;
	const TYPE_PARTITIONS_TEMP_BLOCKING = 7;
	const TYPE_ACCESS_TO_CASH_MACHINE = 8;
	const TYPE_GUARD = 9;
	const TYPE_SCHEDULE = 10;
	
	public $alias_access_zone1 = 1;
	public $alias_access_zone2 = 1;
	public $alias_access_zone3 = 1;
	public $alias_access_zone4 = 1;
	public $alias_access_zone5 = 1;
	public $alias_access_zone6 = 1;
	public $alias_access_zone7 = 1;
	public $alias_access_zone8 = 1;
	
	public $alias_rights1_0;
	public $alias_rights1_1;
	public $alias_rights1_2;
	public $alias_rights1_3;
	public $alias_rights1_4;
	public $alias_rights1_5;
	public $alias_rights1_6;
	public $alias_rights1_7;
	
	public $alias_rights2_0;
	public $alias_rights2_1;
	public $alias_rights2_2;
	public $alias_rights2_3;
	public $alias_rights2_4;
	public $alias_rights2_5;
	public $alias_rights2_6;
	public $alias_rights2_7;
	
	public $alias_rights3_0;
	public $alias_rights3_1;
	public $alias_rights3_2;
	public $alias_rights3_3;
	public $alias_rights3_4;
	public $alias_rights3_5;
	public $alias_rights3_6;
	public $alias_rights3_7;		
	
	public function tableName()
	{
		return 'im_integra_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number, type, name', 'required'),
			array('number', 'unique'),
			array('number', 'numerical', 'integerOnly'=>true, 'min'=>1, 'max'=>240),
			array('number, type, rights_1, rights_2, rights_3', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, type, name, rights_1, rights_2, rights_3', 'safe', 'on'=>'search'),
			array('alias_rights1_0, alias_rights1_1, alias_rights1_2, alias_rights1_3, alias_rights1_4, alias_rights1_5, alias_rights1_6, alias_rights1_7, '
				. 'alias_rights2_0, alias_rights2_1, alias_rights2_2, alias_rights2_3, alias_rights2_4, alias_rights2_5, alias_rights2_6, alias_rights2_7, '
				. 'alias_rights3_0, alias_rights3_1, alias_rights3_2, alias_rights3_3, alias_rights3_4, alias_rights3_5, alias_rights3_6, alias_rights3_7, '
				. 'alias_access_zone1, alias_access_zone2, alias_access_zone3, alias_access_zone4, alias_access_zone5, alias_access_zone6, alias_access_zone7, alias_access_zone8', 'safe'),
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
			'imUserRights' => array(self::HAS_MANY, 'UserRight', 'user_id'),
			'imUserZones' => array(self::HAS_MANY, 'ImUserZones', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Numer',
			'type' => 'Typ',
			'name' => 'Nazwa',
			'rights_1' => 'Rights 1',
			'rights_2' => 'Rights 2',
			'rights_3' => 'Rights 3',
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
		$criteria->compare('number',$this->number);
		$criteria->compare('type',$this->type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('rights_1',$this->rights_1);
		$criteria->compare('rights_2',$this->rights_2);
		$criteria->compare('rights_3',$this->rights_3);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IntegraUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTypeName()
	{
		$types = array(
			self::TYPE_NORMAL=>'Normalny',
			self::TYPE_TIME_RENEWABLE=>'Odnawialny czasowo',
			self::TYPE_TIME_NOT_RENEWABLE=>'Nieodnawialny czasowo',
			self::TYPE_DURESS=>'Przymusowy',
			self::TYPE_MONO_OUTPUTS=>'Wyjścia MONO',
			self::TYPE_BI_OUTPUTS=>'Wyjścia BI',
			self::TYPE_PARTITIONS_TEMP_BLOCKING=>'Tymczasowo blokujący strefy',
			self::TYPE_ACCESS_TO_CASH_MACHINE=>'Dostęp do kas',
			self::TYPE_GUARD=>'Strażnik',
			self::TYPE_SCHEDULE=>'Schemat'
		);
		
		return $types[$this->type];
	}
	
	public function parseRights()
	{
		if(count($this->imUserRights) == 0)
		{
			if($this->rights_1 != null && $this->rights_2 != null && $this->rights_3 != null)
			{
				for($i = 1; $i < 4; $i++)
				{
					$rights = Right::model()->getRightsByByte($i);
					$rightsNumber = $this->{'rights_'.$i};
					$bin = str_pad(decbin($rightsNumber), 8, "0", STR_PAD_LEFT);
					
					for($x = 0; $x < 8; $x++)
					{
						$userRight = new UserRight;
						
						$userRight->user_id = $this->id;
						$userRight->right_id = $rights[$x]->id;
						$userRight->allowed = intval($bin[$x]);
						
						$userRight->save();
					}				
				}				
			}
		}
		else
		{
//			for($i = 1; $i < 4; $i++)
//			{
//				$rights = Right::model()->getRightsByByte($i);
//				$rightsNumber = $this->{'rights_'.$i};
//				$bin = str_pad(decbin($rightsNumber), 8, "0", STR_PAD_LEFT);
//
//				for($x = 0; $x < 8; $x++)
//				{
//					$userRight = new UserRight;
//
//					$userRight->user_id = $this->id;
//					$userRight->right_id = $rights[$x]->id;
//					$userRight->allowed = intval($bin[$x]);
//
//					$userRight->save();
//				}				
//			}	
		}
	}
	
	public function getUserForUpdate($id)
	{
		$model = $this->findByPk($id);
		
		//przepisanie uprawnień do aliasów
	}
	
	public function getRightsByByte($byte)
	{
		$criteria=new CDbCriteria;

		$criteria->with = array('right');
		$criteria->compare('right.byte_no', $byte);
		$criteria->compare('user_id', $this->id);
		$criteria->order = 'right.bit_no DESC';

		return UserRight::model()->findAll($criteria);
	}
	
	public function serializeRights($rights)
	{
		$rightsString = '';
		$byte_no = -1;
		
		foreach($rights as $right)
		{
			$rightsString .= $right->allowed;
			$byte_no = $right->right->byte_no;
		}
		
		$this->{'rights_'.$byte_no} = bindec($rightsString);
		
		return $this->save();
	}
	
	public static function getTypeEnum()
	{
		return array(
			self::TYPE_NORMAL=>'Normalny',
			self::TYPE_TIME_RENEWABLE=>'Odnawialny czasowo',
			self::TYPE_TIME_NOT_RENEWABLE=>'Nieodnawialny czasowo',
			self::TYPE_DURESS=>'Przymusowy',
			self::TYPE_MONO_OUTPUTS=>'Wyjścia MONO',
			self::TYPE_BI_OUTPUTS=>'Wyjścia BI',
			self::TYPE_PARTITIONS_TEMP_BLOCKING=>'Tymczasowo blokujący strefy',
			self::TYPE_ACCESS_TO_CASH_MACHINE=>'Dostęp do kas',
			self::TYPE_GUARD=>'Strażnik',
			self::TYPE_SCHEDULE=>'Schemat'
		);
	}
}
