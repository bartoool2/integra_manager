<?php

class Search extends CActiveForm
{
	public $labelCssClass = 'control-label';
	
	public $fieldCssClass = 'span12';
	
	public function init()
	{
		if ($this->action === null)
		{
			$this->action = Yii::app()->controller->createUrl('event/list');
		}
		
		if (!isset($this->htmlOptions['class']))
		{
			$this->htmlOptions['class'] = 'form-horizontal-search hide';
		}
		
		parent::init();
	}
}