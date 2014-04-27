<?php 
/* 
 * @var $this Controller 
 */ 
	$baseUrl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();	
	
	$cs->registerCssFile($baseUrl.'/themes/layout/main/style.css');
	$cs->registerCssFile($baseUrl.'/themes/layout/main/bootstrap/css/bootstrap-theme.min.css');
	$cs->registerCssFile($baseUrl.'/themes/layout/main/bootstrap/css/bootstrap.min.css');
	$cs->registerScriptFile($baseUrl.'/themes/layout/main/jquery.min.js');
	$cs->registerScriptFile($baseUrl.'/themes/layout/main/bootstrap/js/bootstrap.js');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<meta name="language" content="en" />       
	<meta name="viewport" content="width=device-width, initial-scale=1.0"></meta>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>		
	<div id="root">	
		<div class="layout-row desktop-only">
			<div class="left">
				<h1><small><a href="<?php echo Yii::app()->controller->createUrl('site/index'); ?>" id="logo">Integra manager</a></small></h1>
			</div>
			<div id="top-menu" class="right">
				<?php 
					$this->widget('application.extensions.widgets.TopMenu', array(
						'items'=>$this->topmenu
					));
				?>
			</div>
		</div>
		<div class="layout-row">
		<?php 						
			$this->widget('application.extensions.widgets.NavBar', array(
				'items'=>$this->mainmenu
			)); 
		?>
                </div>
                <?php 	
                if(!Yii::app()->user->getIsGuest())
                {
			$this->widget('application.extensions.widgets.StatusBar', array(
				'items'=>array(
                                        Status::SYSTEM_STATUS,
                                        Status::SYSTEM_STATUS,
                                )
			));
                }
		?>
                <div class="layout-row page-content">
                        <?php echo $content; ?>
                </div>
		<div class="clear"></div>
	</div>
</body>
</html>
