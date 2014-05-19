<?php

class ZLoginForm extends CFormModel
{
	public $username;
	
	public $password;

	private $_identity;

	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('password', 'authenticate'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'username'=>Yii::t('matwork', 'Login'),
			'password'=>Yii::t('matwork', 'Password'),
		);
	}

	public function authenticate($attribute, $params)
	{
		if (!$this->hasErrors())
		{
			$this->_identity = new UserIdentity($this->username, $this->password);
			
			if (!$this->_identity->authenticate())
			{
				$this->addError($attribute, Yii::t('matwork', 'Incorrect login or password.'));
			}
			else
			{
				Yii::app()->user->login($this->_identity);

				Yii::app()->user->setLevel();

				return true;
			}
		}
	}
}
