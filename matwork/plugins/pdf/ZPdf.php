<?php

include 'source/mpdf.php';

class ZPdf extends CApplicationComponent
{
	private $_mpdf = null;
	
	public $appId;
	
	public $secret;
	
	public function init()
	{
		$this->_mpdf = new mPDF();
		
		parent::init();
	}
	
	public function __set($name, $value)
	{
		$this->_mpdf = new mPDF();
		
		$this->_mpdf->{$name} = $value;
	}
	
	public function __get($name)
	{
		$this->_mpdf = new mPDF();
		
		return $this->_facebook->{$name};
	}
	
	public function __call($name, $parameters)
	{
		if (method_exists($this->_mpdf, $name))
		{
			return call_user_func_array(array($this->_mpdf, $name), $parameters);
		}
	}
}

?>
