<?php

class ZHistory extends CApplicationComponent
{
	public function set($name, $value)
	{
		$_SESSION['history'][$name] = $value;
	}
	
	public function get($name, $default)
	{
		$url = null;
		
		if (isset($_SESSION['history'][$name]))
		{
			$url = $_SESSION['history'][$name];
		}
		else
		{
			$url = $default;
		}
		
		return $url;
	}
	
	public function clear()
	{
		unset($_SESSION['history']);
	}
}

?>
