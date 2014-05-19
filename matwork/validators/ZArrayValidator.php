<?php

class ZArrayValidator extends CValidator
{
	public $minLength = null;
	
	public $maxLength = null;
	
	public $tooSmall = null;
	
	public $tooBig = null;
	
	protected function validateAttribute($object, $attribute)
	{
		if ($this->maxLength !== null && sizeof($object->{$attribute}) > $this->maxLength)
		{
			$object->addError($attribute, Yii::t('matwork', $this->tooBig !== null ? $this->tooBig : 'List {attribute} can contain up to {n} elements.', array($this->maxLength, '{attribute}'=>$object->getAttributeLabel($attribute))));
		
			return false;
		}
		
		if ($this->minLength !== null && sizeof($object->{$attribute}) < $this->minLength)
		{
			$object->addError($attribute, Yii::t('matwork', $this->tooSmall !== null ? $this->tooSmall : 'List {attribute} must contain at least {number} elements.', array($this->minLength, '{attribute}'=>$object->getAttributeLabel($attribute))));
		
			return false;
		}
		
		return false;
	}
}

?>
