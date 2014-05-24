<?php

class WebUser extends CWebUser
{
	const ACCESS_DENIED = '';
	
	const ALERT_RED = 'alert-danger';
	const ALERT_YELLOW = 'alert-warning';
	const ALERT_BLUE = 'alert-info';
	const ALERT_GREEN = 'alert-success';
	
	public $alert_strong;
	public $alert;
	public $alert_type;
	
	private $_model;
	
	public function getData()
	{
		$this->loadUser(Yii::app()->user->id);
		
		return $this->_model;
	}
	
	public function displayAlert()
	{
		if(isset(Yii::app()->session['alert_message']))
		{
			echo Yii::app()->session['alert_message'];
		}
		
		unset(Yii::app()->session['alert_message']);
	}
	
	public function setAlert($strong, $text, $type = self::ALERT_GREEN)
	{
		Yii::app()->session['alert_message'] = '<div class="alert '.$type.' alert-dismissable">
					<strong>'.$strong.'</strong> '.$text.'</div>';
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
