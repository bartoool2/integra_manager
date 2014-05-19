<?php

include 'source/Facebook.php';

class ZFacebook extends CApplicationComponent
{
	private $_facebook = null;
	
	public $appId;
	
	public $secret;
	
	public function init()
	{
		$this->_facebook = new Facebook(array(
			'appId'=>$this->appId,
			'secret'=>$this->secret,
		));
		
		parent::init();
	}
	
	public function __set($name, $value)
	{
		$this->_facebook = new Facebook(array(
			'appId'=>$this->appId,
			'secret'=>$this->secret,
		));
		
		$this->_facebook->{$name} = $value;
	}
	
	public function __get($name)
	{
		$this->_facebook = new Facebook(array(
			'appId'=>$this->appId,
			'secret'=>$this->secret,
		));
		
		return $this->_facebook->{$name};
	}
	
	public function __call($name, $parameters)
	{
		if (method_exists($this->_facebook, $name))
		{
			return call_user_func_array(array($this->_facebook, $name), $parameters);
		}
	}
}

?>
