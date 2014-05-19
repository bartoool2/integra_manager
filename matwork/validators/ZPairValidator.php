<?php

class ZPairValidator extends CValidator
{
	public $forceAttribute = null;
	
	protected function validateAttribute($object, $attribute)
	{
		if ($object->{$attribute} != null && $object->{$this->forceAttribute} == null)
		{
			$object->addError($this->forceAttribute, Yii::t('matwork', 'Jeśli podano wartość atrybutu '.$object->getAttributeLabel($attribute).', to wartość atrybutu '.$object->getAttributeLabel($this->forceAttribute).' nie może być pusta.'));
		
			return false;
		}
		
		return true;
	}
}
?>
