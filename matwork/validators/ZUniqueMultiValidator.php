<?php

class ZUniqueMultiValidator extends CValidator
{
	public $assignTo;
	
	public $allowEmpty = false;

	public $caseSensitive = false;

	protected function validateAttribute($object,$attribute)
	{
		$attributes = null;
		$criteria=array('condition'=>'');
		if(false !== strpos($attribute, "+"))
		{
			$attributes = explode("+", $attribute);
		}
		else
		{
			$attributes = array($attribute);
		}
	
		foreach($attributes as $attribute)
		{
			$value = $object->$attribute;
			if($this->allowEmpty && ($value===null || $value===''))
				return;
			$column=$object->getTableSchema()->getColumn($attribute);
			if($column===null)
				throw new CException(Yii::t('yii','{class} does not have attribute "{attribute}".',
			array('{class}'=>get_class($object), '{attribute}'=>$attribute)));
			$columnName=$column->rawName;
			if(''!=$criteria['condition'])
			{
				$criteria['condition'].= " AND ";
			}
			$criteria['condition'].=$this->caseSensitive ? "$columnName=:$attribute" : "LOWER($columnName)=LOWER(:$attribute)";
			$criteria['params'][':'.$attribute]=$value;
		}
	
		if($column->isPrimaryKey)
			$exists=$object->exists($criteria);
		else
		{
			// need to exclude the current record based on PK
			$criteria['limit']=2;
			$objects=$object->findAll($criteria);
			$n=count($objects);
			if($n===1)
			{
				if(''==$object->getPrimaryKey())
				{
					$exists = true;
				}
				else
				{
					$exists=$objects[0]->getPrimaryKey()!==$object->getPrimaryKey();
				}
			}
			else
				$exists=$n>1;
		}
		if($exists)
		{
			$message = '';
			
			foreach ($attributes as $attribute)
			{
				$message .= $object->getAttributeLabel($attribute).', ';
			}
			
			$message = substr($message, 0, -2);
			
			$message = $this->message !== null ? $this->message : Yii::t('matwork', 'The combination of fields {message} should be unique in the current context.', array('{message}'=>$message));
			
			if ($this->assignTo !== null)
			{
				$this->addError($object,$this->assignTo,$message);
			}
			else
			{
				foreach ($attributes as $attribute)
				{
					$this->addError($object,$attribute,$message);
				}
			}
		}
	}
}
?>
