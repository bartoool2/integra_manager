<?php

class ZSystem
{
	public static function browserLanguage()
	{
		if (strlen($_SERVER['HTTP_ACCEPT_LANGUAGE']) > 1)
		{
			echo substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}
		else
		{
			return 'en';
		}
	}
}
