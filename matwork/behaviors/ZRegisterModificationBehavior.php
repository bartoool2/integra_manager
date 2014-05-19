<?php

class ZRegisterModificationBehavior extends CActiveRecordBehavior
{
	public $modifiedAtAttribute = 'modified_at';

	public $modifiedByAttribute = 'modified_by';

	public function beforeSave($event)
	{
		$this->owner->{$this->modifiedAtAttribute} = $this->modifiedAtExpression();

		$this->owner->{$this->modifiedByAttribute} = $this->modifiedByExpression();
	}
	
	public function modifiedAtExpression()
	{
		return ZDateTime::format();
	}
	
	public function modifiedByExpression()
	{
		return Yii::app()->user->id;
	}
}

?>