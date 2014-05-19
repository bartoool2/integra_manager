<?php

class ZContactForm extends CFormModel
{
	public $email;
	
	public $first_name;
	
	public $last_name;
	
	public $subject;
	
	public $contents;
	
	public $verification_code;

	public function rules()
	{
		return array(
			array('email, subject, contents', 'required'),
			array('email, subject', 'length', 'max'=>200),
			array('contents', 'length', 'max'=>2000),
			array('verification_code', 'captcha'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'email'=>Yii::t('matwork', 'Email'),
			'first_name'=>Yii::t('matwork', 'First name'),
			'last_name'=>Yii::t('matwork', 'Last name'),
			'subject'=>Yii::t('matwork', 'Subject'),
			'contents'=>Yii::t('matwork', 'Contents'),
			'verification_code'=>Yii::t('matwork', 'Code from image'),
		);
	}
}
