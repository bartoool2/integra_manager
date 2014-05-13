<?php

class ZoneController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function filters()
	{
		return array(
			'accessControl',
		);
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('state'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	
	public function actionList()
	{
                $this->render('list');
	}
	
	public function actionState()
	{
		$statuses = Status::model()->findAll();
		
		$this->render('state', array(
			'model'=>$statuses
		));
	}
        
        public function actionRefresh()
        {
                $this->render('list');
        }
}
