<?php
$this->widget('application.extensions.widgets.ActionTitleBar', array(
        'title'=>$model->name,
        'items'=>array(
                array(
                        'label'=>'Edytuj',
                        'url'=>Yii::app()->controller->createUrl('integraUser/update', array('id'=>$model->id)),
                        'class'=>'btn btn-primary action-btn',
                ),
		array(
                        'label'=>'Anuluj',
                        'url'=>Yii::app()->controller->createUrl('integraUser/list'),
                        'class'=>'btn btn-default action-btn',
                ),
        ),
));
?>

<div class="panel panel-default" style="margin-top: 35px">
	<div id="user-info" class='section-title panel-heading'>Dane użytkownika</div>
	<div id='user-info-content' class='section-content panel-body' style="text-align: center">
		<div class="dual-row">
			<div class="dual-column">
				<div style='float: left; width: 30%'><?php echo CHtml::activeLabel($model, 'name'); ?></div>
				<?php echo $model->name; ?>
			</div>		
			<div class="dual-column">
				<div style='float: left; width: 30%'><?php echo CHtml::activeLabel($model, 'number'); ?></div>
				<?php echo $model->number; ?>
			</div>	
		</div>
		<div class="dual-row">
			<div class="dual-column">
				<div style='float: left; width: 30%'><?php echo CHtml::activeLabel($model, 'type'); ?></div>
				<?php echo $model->typeName; ?>
			</div>		
			<div class="dual-column">

			</div>		
		</div>
	</div>
</div>

<div class="panel panel-default" style="margin-top: 35px">
	<div id="user-zones" class='section-title panel-heading'>Dostęp do stref</div>
	<div id='user-zones-content' class='section-content panel-body'>
		<div style="display: table; width: 100%;">
			<?php							
				foreach($zonesToCheck as $zone)
				{
					?>
						<div class="zone-checkbox">
							<div class="checkbox">
								<label>
									<?php echo CHtml::checkBox('checkbox', $zone->allowed, array('style'=>'margin-left: 15%', 'disabled'=>'true')); 
									echo CHtml::tag("span", array('style'=>'margin-left: 20%'), $zone->zone->number.'. '.$zone->zone->name);
									?>
								</label>
							</div>											
						</div>
					<?php
				}
			?>							
		</div>
	</div>
</div>

<div class="panel panel-default" style="margin-top: 15px">
	<div id="user-privilages" class='section-title panel-heading'>Uprawnienia</div>
	<div id='user-privilages-content' class='section-content panel-body'>
		<div class="dual-row">
			<div class="triple-column">
				<?php
					foreach($rights1 as $right)
					{
					?>
						<div class="checkbox">
							<label>
								<?php echo CHtml::checkBox('checkbox', $right->allowed, array('disabled'=>'true')); ?>
								<?php echo $right->right->name; ?>
							</label>
						</div>
					<?php					
					}
				?>
			</div>	
			<div class="triple-column">
				<?php
					foreach($rights2 as $right)
					{
					?>
						<div class="checkbox">
							<label>
								<?php echo CHtml::checkBox('checkbox', $right->allowed, array('disabled'=>'true')); ?>
								<?php echo $right->right->name; ?>
							</label>
						</div>
					<?php					
					}
				?>
			</div>		
			<div class="triple-column">
				<?php
					foreach($rights3 as $right)
					{
					?>
						<div class="checkbox">
							<label>
								<?php echo CHtml::checkBox('checkbox', $right->allowed, array('disabled'=>'true')); ?>
								<?php echo $right->right->name; ?>
							</label>
						</div>
					<?php					
					}
				?>
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