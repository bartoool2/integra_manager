<?php

class WebUser extends CWebUser
{
	const ACCESS_DENIED = '';
	
	private $_model;
	
	public function getData()
	{
		$this->loadUser(Yii::app()->user->id);
		
		return $this->_model;
	}

	public function getIsUser()
	{
		$user = $this->loadUser(Yii::app()->user->id);	
		return $user !== null;
	}
	
	public function getIsLogged()
	{
		$user = $this->loadUser(Yii::app()->user->id);
		
		return $user !== null ? $this->isUser : false; 
	}
	
	public function getUserAccess()
	{
		print_r( $this->getIsUser() ? array($this->_model->email) : array(self::ACCESS_DENIED));
		return $this->getIsUser() ? array($this->_model->email) : array(self::ACCESS_DENIED);
	}
	
	public function getLoggedAccess()
	{
		return $this->isUser ? array($this->_model->email) : array(self::ACCESS_DENIED);
	}
	
	protected function loadUser($id = null)
	{
		if ($this->_model === null)
		{
			if ($id !== null)
			{
				$this->_model = User::model()->findByPk($id);
			}
		}
		return $this->_model;
	}
}

?>
