<?php

class ZOperationForm extends CFormModel
{
	public $accepted = array();
	
	public $rejected = array();
	
	public $control;
	
	public $single = false;
	
	public $redirect = array();
	
	public $messages = array();
	
	public $affected = 0;
	
	public function getObjectsCount()
	{
		return sizeof($this->accepted) + sizeof($this->rejected);
	}
	
	public function beginOperation()
	{
		if (sizeof($this->accepted) + sizeof($this->rejected) == 0)
		{
			$messages = $this->messages + self::enumMessages();
			
			Yii::app()->message->set(Yii::t('view', 'Oppss! Something went wrong!'), Yii::t('messages', $messages['empty']), 'error');
			
			Yii::app()->controller->redirect(is_array($this->redirect) ? $this->redirect['multiple'] : $this->redirect);
		}
	}
	
	public function endOperation()
	{
		$messages = $this->messages + self::enumMessages();
		
		if ($this->single)
		{
			if ($this->affected > 0)
			{
				Yii::app()->message->set(Yii::t('matwork', 'Yeah! Everything is ok!'), Yii::t('messages', $messages['single']['success']), 'success');
				
				Yii::app()->controller->redirect(is_array($this->redirect) ? (is_array($this->redirect['single']) ? $this->redirect['single']['success'] : $this->redirect['single']) : $this->redirect);
			}
			else
			{
				Yii::app()->message->set(Yii::t('matwork', 'Oppss! Something went wrong!'), Yii::t('messages', $messages['single']['error']), 'error');
				
				Yii::app()->controller->redirect(is_array($this->redirect) ? (is_array($this->redirect['single']) ? $this->redirect['single']['error'] : $this->redirect['single']) : $this->redirect);
			}
		}
		else
		{
			if ($this->affected == 0)
			{
				Yii::app()->message->set(Yii::t('matwork', 'Oppss! Something went wrong!'), Yii::t('messages', $messages['multiple']['error']), 'error');
			}
			else
			{
				if ($this->affected == sizeof($this->accepted))
				{
					Yii::app()->message->set(Yii::t('matwork', 'Yeah! Everything is ok!'), Yii::t('messages', $messages['multiple']['success']), 'success');
				}
				else
				{
					Yii::app()->message->set(Yii::t('matwork', 'Yeah! Everything is ok!'), Yii::t('messages', $messages['multiple']['particular'], array($this->affected, '{number}'=>sizeof($this->accepted))), 'warning');
				}
			}
			
			Yii::app()->controller->redirect(is_array($this->redirect) ? $this->redirect['multiple'] : $this->redirect);
		}
	}
	
	public static function enumRedirects()
	{
		return Yii::app()->controller->createUrl('showList');
	}
	
	public static function enumMessages()
	{
		return array(
			'empty'=>'You have to select at least one item to perform this operation.',
			'single'=>array(
				'success'=>'Operation has been executed successfully.',
				'error'=>'Operation has not been executed.',
			),
			'multiple'=>array(
				'success'=>'Operation has been executed successfully.',
				'particular'=>'Operation has been executed on {n} from {number} items.',
				'error'=>'Operation has not been executed.',
			),
		);
	}
}
