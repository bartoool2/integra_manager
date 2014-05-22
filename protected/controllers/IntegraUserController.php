<?php

class IntegraUserController extends Controller
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
				'actions'=>array('list', 'view', 'create', 'update'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	
	public function actionList()
	{
		$model = new IntegraUser('search');
		
		$model->unsetAttributes();

		if (isset($_POST['IntegraUser']))
		{
			if(!isset($_POST['IntegraUser']['clear']))
			{
				$model->attributes = $_POST['IntegraUser'];
			}
			else
			{
				unset($_POST['IntegraUser']);
			}			
		}	

		$this->title = 'Lista użytkowników';
		
		$this->render('list', array(
			'model'=>$model,
		));
	}
	
	public function actionView($userId)
	{
		$model = IntegraUser::model()->findByPk($userId);
		
		$this->title = 'Użytkownik: '.$model->name;
		$model->parseRights();
		
		$this->render('view', array(
			'model'=>$model,
		));
	}
	
	public function actionCreate()
	{
		$model = new IntegraUser;	
		
		$rights1 = UserRight::model()->getRightsByByte(1);
		$rights2 = UserRight::model()->getRightsByByte(2);
		$rights3 = UserRight::model()->getRightsByByte(3);
		
		$this->render('form', array(
			'model'=>$model,
			'rights1'=>$rights1,
			'rights2'=>$rights2,
			'rights3'=>$rights3,
		));
	}
}
