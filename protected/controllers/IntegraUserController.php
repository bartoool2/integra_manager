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
		
		$rights1 = $model->getRightsByByte(1);
		$rights2 = $model->getRightsByByte(2);
		$rights3 = $model->getRightsByByte(3);
		
		$zonesToCheck = Zone::model()->findAll();
		
		$this->render('view', array(
			'model'=>$model,
			'rights1'=>$rights1,
			'rights2'=>$rights2,
			'rights3'=>$rights3,
			'zonesToCheck'=>$zonesToCheck,
		));
	}
	
	public function actionCreate()
	{
		$model = new IntegraUser;	
		
		$rights1 = Right::model()->getRightsByByte(1);
		$rights2 = Right::model()->getRightsByByte(2);
		$rights3 = Right::model()->getRightsByByte(3);
		
		$zonesToCheck = Zone::model()->findAll();
		
		if(isset($_POST['IntegraUser']))
		{
			$model->attributes = $_POST['IntegraUser'];
			
			$transaction = Yii::app()->db->beginTransaction();
			
			try 
			{
				if($model->save())
				{
					$rights = array(
						$rights1,
						$rights2,
						$rights3
					);

					$rightsSaved = true;
					foreach($rights as $rightCol)
					{
						$rightsToPass = array();
						foreach($rightCol as $right)
						{
							$userRight = new UserRight;

							$userRight->right_id = $right->id;
							$userRight->user_id = $model->id;
							$userRight->allowed = $model->{'alias_rights'.$right->byte_no.'_'.$right->bit_no};

							if(!$userRight->save())
							{
								$rightsSaved = false;
								break 2;
							}
							else
							{
								array_push($rightsToPass, $userRight);
							}
						}		
						
						$rightsSaved = $model->serializeRights($rightsToPass);
						if(!$rightsSaved)
						{
							break;
						}
					}
					
					if($rightsSaved)
					{
						$transaction->commit();
						
						$this->redirect($this->createUrl('integraUser/list'));
						
						$this->setAlert('Potwierdzenie', 'Użytkownik zapisany pomyślnie');
					}
					else
					{
						$transaction->rollback();
					}
				}
				else 
				{
					$transaction->rollback();
				}							
			}
			catch (Exception $e) 
			{
				$transaction->rollback();
			}			
		}		
		
		$this->render('form', array(
			'model'=>$model,
			'rights1'=>$rights1,
			'rights2'=>$rights2,
			'rights3'=>$rights3,
			'zonesToCheck'=>$zonesToCheck,
		));
	}
	
	public function actionUpdate($id)
	{
		$model = IntegraUser::model()->getUserForUpdate($id);	
		
		$rights1 = $model->getRightsByByte(1);
		$rights2 = $model->getRightsByByte(2);
		$rights3 = $model->getRightsByByte(3);
		
		$zonesToCheck = Zone::model()->findAll();
		
		if(isset($_POST['IntegraUser']))
		{
			$model->attributes = $_POST['IntegraUser'];
			
			$rights = array(
				$rights1,
				$rights2,
				$rights3
			);
			
			foreach($rights as $rightsCol)
			{
				foreach($rightsCol as $singleRight)
				{
					$currentAlias = $model->{'alias_rights'.$singleRight->right->byte_no.'_'.$singleRight->right->bit_no};
					if($singleRight->allowed != $currentAlias)
					{
						print $singleRight->id.'; ';
					}
				}				
			}
		}
		
		$this->render('form', array(
			'model'=>$model,
			'rights1'=>$rights1,
			'rights2'=>$rights2,
			'rights3'=>$rights3,
			'zonesToCheck'=>$zonesToCheck,
		));
	}
}
