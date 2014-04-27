<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $topmenu = array();
	
	public $mainmenu = array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public function init()
	{
		$logoutUrl = null;
		
		if (Yii::app()->user->isUser)
		{
			$this->topmenu = array(	
				array(
					'name'=>Yii::t('view', 'Pomoc'),
					'url'=>$this->createUrl('site/help'),
					'type'=>'item'
				),
				array(
					'name'=>Yii::t('view', 'Wyloguj'),
					'url'=>$this->createUrl('site/logout'),
					'type'=>'item'
				),
			);
			
			$this->mainmenu = array(
				array(
					'name'=>Yii::t('view', 'Pulpit'),
					'url'=>$this->createUrl('site/desktop'),
					'type'=>'item'
				),
				array(
					'name'=>Yii::t('view', 'Zdarzenia'),
					'url'=>$this->createUrl('event/list'),
					'type'=>'item'
				),
				array(
					'type'=>'divider',
//					'class'=>'mobile-only'
				),
				array(
					'name'=>Yii::t('view', 'Wyloguj'),
					'url'=>$this->createUrl('site/logout'),
					'type'=>'item',
					'class'=>'mobile-only'
				),
			);
		}
		else
		{
			$this->topmenu = array(	
				array(
					'name'=>Yii::t('view', 'Zaloguj'),
					'url'=>$this->createUrl('site/login'),
					'type'=>'item'
				),
			);
			
			$this->mainmenu = array(
				array(
					'name'=>Yii::t('view', 'Zaloguj'),
					'url'=>$this->createUrl('site/login'),
					'type'=>'item',
					'class'=>'mobile-only'
				),				
				array(
					'type'=>'divider',
//					'class'=>'mobile-only'
				),
				array(
					'name'=>Yii::t('view', 'Strona główna'),
					'url'=>$this->createUrl('site/index'),
					'type'=>'item'
				),
			);
		}
		
		parent::init();
	}
}