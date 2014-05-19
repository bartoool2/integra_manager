<?php

class ZDifferenceFormatter extends CApplicationComponent
{
	public function formatDateTime($date, $reference = ZDateTime::NOW, $reverse = false)
	{
		$reference = $reference == ZDateTime::NOW ? ZDateTime::format() : $reference;
		
		$days = ZDateTime::difference($date, $reference, ZDateTime::FORMAT_DAYS, $reverse);
		
		$variant = $reverse ? 'left' : 'ago';
		
		if ($days > 0)
		{
			return Yii::t('matwork', '{n} days '.$variant, $days);
		}
		else
		{
			$hours = ZDateTime::difference($date, $reference, ZDateTime::FORMAT_HOURS, $reverse);
			
			if ($hours > 0)
			{
				return Yii::t('matwork', '{n} hours '.$variant, $hours);
			}
			else
			{
				$minutes = ZDateTime::difference($date, $reference, ZDateTime::FORMAT_MINUTES, $reverse);
				
				if ($minutes > 0)
				{
					return Yii::t('matwork', '{n} minutes '.$variant, $minutes);
				}
				else
				{
					$seconds = ZDateTime::difference($date, $reference, ZDateTime::FORMAT_SECONDS, $reverse);
				
					if ($seconds > 0)
					{
						return Yii::t('matwork', '{n} seconds '.$variant, $seconds);
					}
				}
			}
		}
		
		return null;
	}
	
	public function formatCurrency($value, $reference, $currency)
	{
		return Yii::app()->numberFormatter->formatCurrency($value - $reference, $currency);
	}
}
