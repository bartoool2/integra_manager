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
		$model->parseZones();
		
		$rights1 = $model->getRightsByByte(1);
		$rights2 = $model->getRightsByByte(2);
		$rights3 = $model->getRightsByByte(3);
		
		$this->render('view', array(
			'model'=>$model,
			'rights1'=>$rights1,
			'rights2'=>$rights2,
			'rights3'=>$rights3,
			'zonesToCheck'=>$model->userZones,
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
					$zonesSaved = true;
					foreach($zonesToCheck as $zone)
					{
						$userZone = new UserZone;
						
						$userZone->zone_id = $zone->id;
						$userZone->user_id = $model->id;
						$userZone->allowed = $model->{'alias_access_zone'.$zone->number};

						if(!$userZone->save())
						{
							$zonesSaved = false;
							break;
						}
					}
					
					if($zonesSaved)
					{
						$zonesSaved = $model->serializeZones();
					}
					
					if($zonesSaved)
					{
						$rights = array(
							$rights1,
							$rights2,
							$rights3
						);

						$allDataSaved = true;
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
									$allDataSaved = false;
									break 2;
								}
								else
								{
									array_push($rightsToPass, $userRight);
								}
							}		

							$allDataSaved = $model->serializeRights($rightsToPass);
							
							if(!$allDataSaved)
							{
								break;
							}
						}										

						if($allDataSaved)
						{
							$transaction->commit();

							Yii::app()->user->setAlert('Potwierdzenie', 'Użytkownik zapisany pomyślnie');

							$this->redirect($this->createUrl('integraUser/list'));
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
		
		$zonesToCheck = $model->userZones;
		
		if(isset($_POST['IntegraUser']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			
			try 
			{
				$model->attributes = $_POST['IntegraUser'];
			
				$zonesSaved = true;
				
				foreach($zonesToCheck as $zone)
				{
					if($zone->allowed != $model->{'alias_access_zone'.$zone->zone->number})
					{
						$zone->allowed = $model->{'alias_access_zone'.$zone->zone->number};
						
						if(!$zone->save())
						{
							$zonesSaved = false;
							break;
						}
					}
				}
				
				if($zonesSaved)
				{
					$zonesSaved = $model->serializeZones();
				}
				
				if($zonesSaved)
				{
					$rights = array(
						$rights1,
						$rights2,
						$rights3
					);

					$allChangesSaved = $model->save();

					if($allChangesSaved)
					{
						foreach($rights as $rightsCol)
						{
							foreach($rightsCol as $singleRight)
							{
								$currentAlias = $model->{'alias_rights'.$singleRight->right->byte_no.'_'.$singleRight->right->bit_no};
								if($singleRight->allowed != $currentAlias)
								{
									$singleRight->allowed = $currentAlias;
									if(!$singleRight->save())
									{
										$allChangesSaved = false;
										break 2;
									}
								}
							}

							$allChangesSaved = $model->serializeRights($rightsCol);
							if(!$allChangesSaved)
							{
								break;
							}
						}

						if($allChangesSaved)
						{
							$transaction->commit();

							Yii::app()->user->setAlert('Potwierdzenie', 'Dane użytkownika zostały zaktualizowane');

							$this->redirect($this->createUrl('integraUser/view', array('userId'=>$model->id)));												
						}
					}
				}
			} 
			catch (Exception $ex) 
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
}
