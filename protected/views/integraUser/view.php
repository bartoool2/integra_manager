<?php
$this->widget('application.extensions.widgets.ActionTitleBar', array(
        'title'=>$model->name,
        'items'=>array(
                array(
                        'label'=>'Edytuj',
                        'url'=>'#',
                        'class'=>'btn btn-default action-btn',
			'onclick'=>'toggle_search()'
                ),
        ),
));
?>

<div class="panel panel-default" style="margin-top: 35px">
	<div id="user-info" class='section-title panel-heading'>Dane użytkownika</div>
	<div id='user-info-content' class='section-content panel-body'>
		<div class="dual-row">
			<div class="dual-column">
				<div style='float: left; width: 40%'><?php echo CHtml::activeLabel($model, 'name'); ?></div>
				<?php echo $model->name; ?>
			</div>		
			<div class="dual-column">
				<div style='float: left; width: 40%'><?php echo CHtml::activeLabel($model, 'type'); ?></div>
				<?php echo $model->type; ?>
			</div>	
		</div>
	</div>
</div>

<div class="panel panel-default" style="margin-top: 35px">
	<div id="user-zones" class='section-title panel-heading'>Dostęp do stref</div>
	<div id='user-zones-content' class='section-content panel-body'>
		<div class="dual-row">
			<div class="dual-column">
				<div style='float: left; width: 40%'><?php echo CHtml::activeLabel($model, 'name'); ?></div>
				<?php echo $model->name; ?>
			</div>		
			<div class="dual-column">
				<div style='float: left; width: 40%'><?php echo CHtml::activeLabel($model, 'type'); ?></div>
				<?php echo $model->type; ?>
			</div>	
		</div>
	</div>
</div>

<div class="panel panel-default" style="margin-top: 35px">
	<div id="user-privilages" class='section-title panel-heading'>Uprawnienia</div>
	<div id='user-privilages-content' class='section-content panel-body'>
		<div class="dual-row">
			<div class="triple-column">
				<div style='float: left; width: 40%'><?php echo CHtml::activeLabel($model, 'name'); ?></div>
				<?php echo $model->name; ?>
			</div>		
			<div class="triple-column">
				<div style='float: left; width: 40%'><?php echo CHtml::activeLabel($model, 'type'); ?></div>
				<?php echo $model->type; ?>
			</div>	
			<div class="triple-column">
				
			</div>
		</div>
	</div>
</div>

<?php 
Yii::app()->clientScript->registerScript('expandable-sections',
	'
	$(document).ready(function () {
                
                $(".section-title").click(function(){
			$("#" + this.id + "-content").slideToggle();
		});           
	});
	', CClientScript::POS_HEAD);
?>