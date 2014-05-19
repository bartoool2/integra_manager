<?php

class ZDateTime
{
	const NOW = 'NOW';
	
	const RANGE_SECONDS = 'seconds';
	const RANGE_MINUTES = 'minutes';
	const RANGE_HOURS = 'hours';
	const RANGE_DAYS = 'days';
	
	const FORMAT_SECONDS = 's';
	const FORMAT_MINUTES = 'm';
	const FORMAT_HOURS = 'h';
	const FORMAT_DAYS = 'd';
	const FORMAT_YEARS = 'y';
	
	const FORMAT_SHORT = 'Y-m-d';
	const FORMAT_LONG = 'Y-m-d H:i:s';
	
	public static function format($date = self::NOW, $format = self::FORMAT_LONG)
	{
		return $date == self::NOW ? CTimestamp::formatDate($format) : CTimestamp::formatDate($format, strtotime($date));
	}
	
	public static function add($amount, $range = self::RANGE_DAYS, $date = self::NOW, $format = self::FORMAT_LONG)
	{
		return CTimestamp::formatDate($format, strtotime(($date != self::NOW ? $date.' ' : '').' +'.$amount.' '.$range));
	}
	
	public static function compare($date1, $date2)
	{
		$result = strtotime($date2) - strtotime($date1);
		
		if ($result > 0)
		{
			return 1;
		}
		else
		{
			if ($result < 0)
			{
				return -1;
			}
			else
			{
				return 0;
			}
		}
	}
	
	public static function difference($date1, $date2, $format = ZDateTime::FORMAT_DAYS, $reverse = false)
	{
		if (!$reverse)
		{
			$result = ($date2 == ZDateTime::NOW ? time() : strtotime($date2)) - ($date1 == ZDateTime::NOW ? time() : strtotime($date1));
		}
		else
		{
			$result = ($date1 == ZDateTime::NOW ? time() : strtotime($date1)) - ($date2 == ZDateTime::NOW ? time() : strtotime($date2));
		}
		
		switch ($format)
		{
			case 's':
				return $result;
				break;
			case 'm':
				return floor($result/60);
				break;
			case 'h':
				return floor($result/3600);
				break;
			case 'd':
				return floor($result/86400);
				break;
		}
	}
}
