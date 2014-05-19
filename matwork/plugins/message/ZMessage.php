<?php

class ZMessage extends CApplicationComponent
{
	public function set($title, $text, $type = 'success', $name = 'default')
	{
		$_SESSION['messages'][$name] = array('title'=>$title, 'text'=>$text, 'type'=>$type);
	}
	
	public function get($name = 'default')
	{
		$message = null;
		
		if (isset($_SESSION['messages'][$name]))
		{
			$message = $_SESSION['messages'][$name];
			
			unset($_SESSION['messages'][$name]);
		}
		
		return $message;
	}
}

?>
