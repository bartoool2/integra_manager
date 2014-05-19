<?php

class ZController extends CController
{
	public function init()
	{
		$this->packages();
		
		parent::init();
	}
	
	public function packages()
	{
		$cs = Yii::app()->getClientScript();
		
		Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('matwork.assets'));
		
		$cs->registerPackage('jquery');
		$cs->registerPackage('bootstrap');
		$cs->registerPackage(Yii::app()->language);
	}
	
	public function render($view, $data = null, $return = false)
	{
		if (!is_array($data))
		{
			$data = array();
		}
		
		$data = $data + array('action'=>$this->getAction()->getId());
		
		parent::render($view, $data, $return);
	}
}