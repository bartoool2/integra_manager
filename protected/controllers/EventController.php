<?php

class EventController extends Controller
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
				'actions'=>array('list', 'updateList'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	
	public function actionUpdateList()
	{
		$request = new Request;
		$request->saveNewRequest(Request::CODE_UPDATE_EVENTS);
		$request->save();
		
		Yii::app()->user->setAlert('Potwierdzenie', 'Trwa aktualizacja listy zdarzeń');
		$this->actionList();
	}
	
	public function actionList()
	{
		$model = new Event('search');
		
		$model->unsetAttributes();		
		
		if(isset($_POST['Event']['event_class']) && $_POST['Event']['event_class'] == 'blank')
		{
			unset($_POST['Event']['event_class']);
		}

		if (isset($_POST['Event']))
		{
			if(!isset($_POST['Event']['clear']))
			{
				$model->attributes = $_POST['Event'];
			}
			else
			{
				unset($_POST['Event']);
			}			
		}	

		$this->title = 'Lista zdarzeń';
		
		$this->render('list', array(
			'model'=>$model,
		));
	}
}
