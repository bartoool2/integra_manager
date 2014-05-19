<?php

class ZHtml extends CHtml
{
	public static function validate($models, $summary = null)
	{
		$result = array();
		
		if (!is_array($models))
		{
			foreach ($models->getErrors() as $attribute=>$errors)
			{
				$result[get_class($models).'_'.$attribute] = array('text'=>$errors[0], 'summary'=>$summary);
			}
			
			return $result;
		}
		else
		{
			foreach ($models as $key=>$model)
			{
				foreach($model->getErrors() as $attribute=>$errors)
				{
					$result[get_class($model).'_'.$attribute] = array('text'=>$errors[0], 'summary'=>$summary);
				}
			}
			
			return $result;
		}
	}
	
	public static function icon($class, $htmlOptions = array())
	{
		$htmlOptions['class'] = isset($htmlOptions['class']) ?  $class.' '.$htmlOptions['class'] : $class;
		
		return self::tag('i', $htmlOptions, '', true);
	}
	
	public static function scope2Css($number, $scopes)
	{
		foreach ($scopes as $scope)
		{
			$from = isset($scope['from']) ? $scope['from'] : -INF;
			$to = isset($scope['to']) ? $scope['to'] : INF;
			
			if ($number >= $from && $number < $to)
			{
				return $scope['class'];
			}
		}
	}
	
	public static function value2Css($value, $labels, $prefix = null)
	{
		if (isset($labels[$value]) && $labels[$value] !== null)
		{
			return $prefix.$labels[$value];
		}
		else
		{
			return null;
		}
	}
}
