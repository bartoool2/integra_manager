<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	const ALERT_RED = 'alert-danger';
	const ALERT_YELLOW = 'alert-warning';
	const ALERT_BLUE = 'alert-info';
	const ALERT_GREEN = 'alert-success';
	
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $topmenu = array();
	
	public $mainmenu = array();
	
	public $alert_strong;
	public $alert;
	public $alert_type;
	public $navigation;
	public $title;
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
//				array(
//					'name'=>Yii::t('view', 'Pomoc'),
//					'url'=>$this->createUrl('site/help'),
//					'type'=>'item'
//				),
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
					'name'=>Yii::t('view', 'Strefy'),
					'url'=>$this->createUrl('zone/state'),
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
	
	public function displayAlert()
	{
		if($this->alert != NULL)
		{
			?>
				<div class="alert <?php echo $this->alert_type; ?> alert-dismissable">
					<strong><?php echo $this->alert_strong; ?></strong> <?php echo $this->alert; ?>
				</div>
			<?php
		}
	}
	
	public function setAlert($strong, $text, $type = self::ALERT_GREEN)
	{
		$this->alert = $text;
		$this->alert_strong = $strong;
		$this->alert_type = $type;
	}
}