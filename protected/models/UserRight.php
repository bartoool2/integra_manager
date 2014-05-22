<?php

/**
 * This is the model class for table "im_user_rights".
 *
 * The followings are the available columns in table 'im_user_rights':
 * @property integer $id
 * @property integer $user_id
 * @property integer $right_id
 * @property integer $allowed
 *
 * The followings are the available model relations:
 * @property ImIntegraUsers $user
 * @property ImRights $right
 */
class UserRight extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'im_user_rights';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, right_id', 'required'),
			array('user_id, right_id, allowed', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, right_id, allowed', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'IntegraUser', 'user_id'),
			'right' => array(self::BELONGS_TO, 'Right', 'right_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'Użytkownik',
			'right_id' => 'Uprawnienie',
			'allowed' => 'Wartość',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('right_id',$this->right_id);
		$criteria->compare('allowed',$this->allowed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserRight the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getRightsByByte($byte)
	{
		$criteria=new CDbCriteria;

		$criteria->with = array('right');
		$criteria->compare('right.byte_no', $byte);
		$criteria->order = 'right.bit_no DESC';

		return $this->findAll($criteria);
	}
}
