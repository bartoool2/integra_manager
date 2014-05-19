<?php

class ZConfirmForm extends CFormModel
{
	public $confirm;
	
	public $control;
	
	public $errorLabel;

	public function rules()
	{
		return array(
			array('confirm', 'confirmChecked'),
		);
	}
	
	public function confirmChecked($attribute, $params)
	{
		if ($this->{$attribute} != 1)
		{
			$this->addError($attribute, $this->errorLabel !== null ? $this->errorLabel : Yii::t('matwork', 'You have to confirm you understand operation effects.'));
			
			return false;
		}
		
		return true;
	}

	public function attributeLabels()
	{
		return array(
			'confirm'=>Yii::t('matwork', 'I confirm that I know what I am doing and I want to perform this operation.'),
		);
	}
}
