<?php

class ZResendForm extends CFormModel
{
	public $name;

	public function rules()
	{
		return array(
			array('name', 'required'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'name'=>Yii::t('matwork', 'Login or email'),
		);
	}
}
