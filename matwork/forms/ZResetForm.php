<?php

class ZResetForm extends CFormModel
{
	public $passwordText;
	
	public $passwordRepeat;

	public function rules()
	{
		return array(
			array('passwordText, passwordRepeat', 'required'),
			array('passwordText', 'compare', 'compareAttribute'=>'passwordRepeat', 'message'=>Yii::t('matwork', 'Passwords must be the same.')),
			array('passwordText', 'length', 'min'=>Yii::app()->params['security']['password']['minLength'], 'max'=>Yii::app()->params['security']['password']['maxLength'], 'allowEmpty'=>false),
		);
	}

	public function attributeLabels()
	{
		return array(
			'passwordText'=>Yii::t('matwork', 'Password'),
			'passwordRepeat'=>Yii::t('matwork', 'Repeat password'),
		);
	}
}
