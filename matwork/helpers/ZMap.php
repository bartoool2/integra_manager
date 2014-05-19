<?php

class ZMap extends CMap
{
	public static function pushArray(&$source, $data)
	{
		foreach ($data as $element)
		{
			array_push($source, $element);
		}
	}
}
