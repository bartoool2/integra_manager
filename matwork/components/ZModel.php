<?php

class ZModel extends CActiveRecord
{
	const BOOLEAN_FALSE = 0;
	const BOOLEAN_TRUE = 1;
	
	const GENDER_SINGULAR_MASCULINE = 0;
	const GENDER_SINGULAR_FEMININE = 1;
	const GENDER_SINGULAR_NEUTER = 2;
	
	const GENDER_PLURAL_MASCULINE = 3;
	const GENDER_PLURAL_NONMASCULINE = 4;
	
	const NULL_REPLACEMENT = '';

	/**
	 * Updates model attributes with new values.
	 * @param array $attributes new values (attribute=>value)
	 * @param boolean $update whether update should be executed
	 * @return boolean whether update succeded
	 */
	
	public function updateAttributes($attributes, $update = true)
	{
		if ($update)
		{
			$same = true;
		
			foreach ($attributes as $name=>$value)
			{
				if ($this->{$name} !== $value)
				{
					$same = false;
					
					$this->{$name} = $value;
				}
			}
		
			if (!$same)
			{	
				return $this->saveAttributes($attributes);
			}
			else
			{
				return true;
			}
		}
		
		return true;
	}
	
	/**
	 * @return string the model singular gender
	 */
	
	public static function singularGender()
	{
		return self::GENDER_SINGULAR_MASCULINE;
	}
	
	/**
	 * @return string the model plural gender
	 */
	
	public static function pluralGender()
	{
		return self::GENDER_PLURAL_MASCULINE;
	}
	
	/**
	 * @return array the model boolean labels
	 */
	
	public static function enumBooleanLabels()
	{
		return array(
			self::BOOLEAN_FALSE=>Yii::t('matwork', 'No'),
			self::BOOLEAN_TRUE=>Yii::t('matwork', 'Yes'),
		);
	}
}
?>
