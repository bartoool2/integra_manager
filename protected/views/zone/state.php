<?php
$this->widget('application.extensions.widgets.ActionTitleBar', array(
        'title'=>'Stany stref',
));

$this->renderPartial('_ajaxState', array(
	'dataProvider' => $dataProvider,
	'grid_id' => 'zones-state-grid',
));

Yii::app()->clientScript->registerScript('state-preview',
	'$(document).ready(function() 
	{
		setInterval(function(){
			$.ajax({
				url: "'.Yii::app()->controller->createUrl('zone/ajaxStateReload').'",					
			})
			.done(function(data){
				$("#zones-state-grid").html(data);
			});
		}, 4000);
	});', CClientScript::POS_HEAD);
?>
