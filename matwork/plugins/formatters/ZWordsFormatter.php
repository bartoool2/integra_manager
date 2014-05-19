<?php

class ZWordsFormatter extends CApplicationComponent
{
	public function getUnitName($unit)
	{
		$value = null;
		
		switch ($unit)
		{
			case 0:
				$value = Yii::t('matwork', 'zero');
				break;
			case 1: 
				$value = Yii::t('matwork', 'one');
				break;
			case 2: 
				$value = Yii::t('matwork', 'two');
				break;
			case 3: 
				$value = Yii::t('matwork', 'three');
				break;
			case 4: 
				$value = Yii::t('matwork', 'four');
				break;
			case 5: 
				$value = Yii::t('matwork', 'five');
				break;
			case 6: 
				$value = Yii::t('matwork', 'six');
				break;
			case 7: 
				$value = Yii::t('matwork', 'seven');
				break;
			case 8: 
				$value = Yii::t('matwork', 'eight');
				break;
			case 9: 
				$value = Yii::t('matwork', 'nine');
				break;
			case 10: 
				$value = Yii::t('matwork', 'ten');
				break;
			case 11: 
				$value = Yii::t('matwork', 'eleven');
				break;
			case 12: 
				$value = Yii::t('matwork', 'twelve');
				break;
			case 13: 
				$value = Yii::t('matwork', 'thirteen');
				break;
			case 14: 
				$value = Yii::t('matwork', 'fourteen');
				break;
			case 15: 
				$value = Yii::t('matwork', 'fifteen');
				break;
			case 16: 
				$value = Yii::t('matwork', 'sixteen');
				break;
			case 17: 
				$value = Yii::t('matwork', 'seventeen');
				break;
			case 18: 
				$value = Yii::t('matwork', 'eighteen');
				break;
			case 19: 
				$value = Yii::t('matwork', 'nineteen');
				break;
		}
		
		return $value;
	}
	
	public function getTenName($ten)
	{
		$value = null;
		
		switch ($ten)
		{
			case 1: 
				$value = Yii::t('matwork', 'ten');
				break;
			case 2: 
				$value = Yii::t('matwork', 'twenty');
				break;
			case 3: 
				$value = Yii::t('matwork', 'thirty');
				break;
			case 4: 
				$value = Yii::t('matwork', 'fourty');
				break;
			case 5: 
				$value = Yii::t('matwork', 'fifty');
				break;
			case 6: 
				$value = Yii::t('matwork', 'sixty');
				break;
			case 7: 
				$value = Yii::t('matwork', 'seventy');
				break;
			case 8: 
				$value = Yii::t('matwork', 'eighty');
				break;
			case 9: 
				$value = Yii::t('matwork', 'ninety');
				break;
		}
		
		return $value;
	}
	
	public function getHundredName($hundred)
	{
		$value = null;
		
		switch ($hundred)
		{
			case 1: 
				$value = Yii::t('matwork', 'one hundred');
				break;
			case 2: 
				$value = Yii::t('matwork', 'two hundreds');
				break;
			case 3: 
				$value = Yii::t('matwork', 'three hundreds');
				break;
			case 4: 
				$value = Yii::t('matwork', 'four hundreds');
				break;
			case 5: 
				$value = Yii::t('matwork', 'five hundreds');
				break;
			case 6: 
				$value = Yii::t('matwork', 'six hundreds');
				break;
			case 7: 
				$value = Yii::t('matwork', 'seven hundreds');
				break;
			case 8: 
				$value = Yii::t('matwork', 'eight hundreds');
				break;
			case 9: 
				$value = Yii::t('matwork', 'nine hundreds');
				break;
		}
		
		return $value;
	}
	
	public function getLevelName($level, $quantity)
	{
		$value = null;
		
		switch ($level)
		{
			case 1000: 
				$value = Yii::t('matwork', 'thousands', $quantity);
				break;
			case 1000000: 
				$value = Yii::t('matwork', 'millions', $quantity);
				break;
			case 1000000000: 
				$value = Yii::t('matwork', 'milliards', $quantity);
				break;
			case 1000000000000: 
				$value = Yii::t('matwork', 'billions', $quantity);
				break;
		}
		
		return $value;
	}
	
	public function resolveDecimalPart($part)
	{
		return ($part).'/100';
	}
	
	public function resolveSmallPart($part, $level = 1)
	{
		$result = '';
		
		if ($part < 20)
		{
			if ($part != 0)
			{
				$result .= $this->getUnitName((int) $part);
			}
		}
		else
		{
			$ten = substr($part, 0, 1);
			$unit = substr($part, 1, 1);
			
			if ($unit > 0)
			{
				$result .= $this->getTenName((int) $ten).' '.$this->getUnitName((int) $unit);
			}
			else
			{
				$result .= $this->getTenName((int) $ten);
			}
		}
		
		if ($level != 1)
		{
			$result .= ' '.$this->getLevelName($level, $part);
		}
		
		return $result;
	}
	
	public function resolveBigPart($part, $level = 1)
	{
		$result = '';
		
		$hundred = substr($part, 0, 1);
		
		$small = substr($part, 1, 2);

		if ($hundred > 0)
		{
			$result .= $this->getHundredName((int) $hundred).' ';
		}
		
		$result .= self::resolveSmallPart($small, $level);
		
		return $result;
	}
	
	public function formatInteger($amount)
	{
		$result = null;
		
		$part = explode('.', number_format($amount, 2, '.', ''));
		
		$big = $part[0];
		
		if (strlen($big) % 3 != 0)
		{
			$big = '0'.$big;
			
			if (strlen($big) % 3 != 0)
			{
				$big = '0'.$big;
			}
		}
		
		$level = pow(1000, strlen($big)/3 - 1);
		
		for ($i = 0; $i < strlen($big) - 2; $i = $i + 3)
		{
			$result .= self::resolveBigPart(substr($big, $i, 3), $level).' ';
			
			$level /= 1000;
		}
		
		return $result;
	}
	
	public function formatDecimal($amount)
	{
		$part = explode('.', number_format($amount, 2, '.', ''));
		
		return self::resolveDecimalPart($part[1]);
	}
	
	public function formatValue($value, $format = 'long')
	{
		$formatted = null;
		
		switch ($format)
		{
			case 'integer':
				$formatted = $this->formatInteger();
				break;
			case 'decimal':
				$formatted = $this->formatDecimal();
				break;
			case 'long':
				$formatted = $this->formatInteger($value).' '.$this->formatDecimal($value);
				break;
		}
		
		return $formatted;
	}
	
	public function formatCurrency($value, $currency, $format = 'long')
	{
		$formatted = null;
		
		switch ($format)
		{
			case 'integer':
				$formatted = $this->formatInteger().' '.Yii::app()->locale->getCurrencySymbol($currency);
				break;
			case 'decimal':
				$formatted = $this->formatDecimal().' '.Yii::app()->locale->getCurrencySymbol($currency);
				break;
			case 'long':
				$formatted = $this->formatInteger($value).' '.Yii::app()->locale->getCurrencySymbol($currency).' '.$this->formatDecimal($value);
				break;
		}
		
		return $formatted;
	}
}
?>