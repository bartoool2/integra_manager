<?php
$this->widget('application.extensions.widgets.ActionTitleBar', array(
        'title'=>'Nowy użytkownik',
));

$form = $this->beginWidget('application.extensions.Form', array(
    'id'=>'control-form',    
)); 
?>

<div class="panel panel-default" style="margin-top: 25px">
	<div id="user-info" class='section-title panel-heading'>Dane użytkownika</div>
	<div id='user-info-content' class='section-content panel-body'>
		<div class="dual-row">
			<div class="dual-column">
				<div style='float: left; width: 30%'><?php echo CHtml::activeLabel($model, 'name'); ?></div>
				<?php echo $form->textField($model, 'name', array('class'=>'form-control', 'style'=>'width: 50%')); ?>
			</div>		
			<div class="dual-column">
				<div style='float: left; width: 30%'><?php echo CHtml::activeLabel($model, 'type'); ?></div>
				<?php echo $form->textField($model, 'type', array('class'=>'form-control', 'style'=>'width: 50%')); ?>
			</div>	
		</div>
	</div>
</div>

<div class="panel panel-default" style="margin-top: 15px">
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
								<input type="checkbox" <?php echo ($right->allowed ? 'checked="checked"' : ''); ?>> <?php echo $right->right->name; ?>
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
								<input type="checkbox" <?php echo ($right->allowed ? 'checked="checked"' : ''); ?>> <?php echo $right->right->name; ?>
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
								<input type="checkbox" <?php echo ($right->allowed ? 'checked="checked"' : ''); ?>> <?php echo $right->right->name; ?>
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
$this->endWidget();

Yii::app()->clientScript->registerScript('expandable-sections',
	'
	$(document).ready(function () {
                
                $(".section-title").click(function(){
			$("#" + this.id + "-content").slideToggle();
		});           
	});
	', CClientScript::POS_HEAD);
?>