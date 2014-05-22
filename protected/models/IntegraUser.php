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
	/**
	 * @return string the associated database table name
	 */
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
			array('number', 'required'),
			array('number, type, rights_1, rights_2, rights_3', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, type, name, rights_1, rights_2, rights_3', 'safe', 'on'=>'search'),
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
	}
}
