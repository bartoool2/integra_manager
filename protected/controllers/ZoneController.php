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
				'actions'=>array('state', 'ajaxStateReload'),
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
		$dataProvider=new CActiveDataProvider('Zone', array(
				'criteria'=>array(
					'condition'=>'id<>1',
			))
		);
		
		$this->render('state', array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionAjaxStateReload()
	{
		$dataProvider=new CActiveDataProvider('Zone', array(
				'criteria'=>array(
					'condition'=>'id<>1',
			))
		);
		
		$this->renderPartial('_ajaxState', array(
			'dataProvider' => $dataProvider,
			'grid_id' => 'zones-state-grid',
		));
	}
        
        public function actionRefresh()
        {
                $this->render('list');
        }
}
