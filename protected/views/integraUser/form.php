<?php
$action = Yii::app()->controller->action->id;
$pageTitle = '';

switch ($action)
{
	case 'create':
		$pageTitle = 'Nowy użytkownik';
		break;
	case 'update':
		$pageTitle = 'Edycja użytkownika';
		break;
}

$this->widget('application.extensions.widgets.ActionTitleBar', array(
        'title'=>$pageTitle,
	'items'=>array(
		array(
                        'label'=>'Zapisz',
                        'url'=>'#',
                        'class'=>'btn btn-success action-btn',
			'onclick'=>'submit_form()'
                ),
		array(
                        'label'=>'Anuluj',
                        'url'=>Yii::app()->controller->createUrl('integraUser/list'),
                        'class'=>'btn btn-default action-btn',
                )
	)
));

$form = $this->beginWidget('application.extensions.Form', array(
    'id'=>'control-form',    
)); 

echo CHtml::errorSummary($model, "<strong>Operacja nie powiodła się, ponieważ:</strong>", null, array("class"=>"alert alert-danger", 'style'=>'margin-top: 25px'));
?>

<div class="panel panel-default" style="margin-top: 25px;">
	<div id="user-info" class='section-title panel-heading'>Dane użytkownika</div>
	<div id='user-info-content' class='section-content panel-body' style="text-align: center">
		<div class="dual-row">
			<div class="dual-column">
				<div style='float: left; width: 30%'><?php echo CHtml::activeLabel($model, 'name'); ?></div>
				<?php echo $form->textField($model, 'name', array('class'=>'form-control', 'style'=>'width: 50%')); ?>
			</div>		
			<div class="dual-column">
				<div style='float: left; width: 30%'><?php echo CHtml::activeLabel($model, 'number'); ?></div>
				<?php echo $form->textField($model, 'number', array('class'=>'form-control', 'style'=>'width: 50%')); ?>
			</div>	
		</div>
		<div class="single-row">
			<div style='float: left; width: 15%'><?php echo CHtml::activeLabel($model, 'type'); ?></div>
			<?php echo $form->dropDownList($model, 'type', IntegraUser::getTypeEnum(), array('class'=>'form-control', 'style'=>'width: 75%')); ?>
		</div>		
	</div>
</div>

<div class="panel panel-default" style="margin-top: 15px">
	<div id="user-zones" class='section-title panel-heading'>Dostęp do stref</div>
	<div id='user-zones-content' class='section-content panel-body'>
		<div>
			<div class="disarm_all_checkbox desktop-only">
				<div class="checkbox" style="padding-left: 30%">
					<label>
						<input id="check_all_checkbox" type="checkbox" checked="checked" onchange="javascript: check_all_zones()" style="margin-right: 25%" value="1"> Zaznacz wszystkie
					</label>
				</div>
			</div>
			<div class="disarm_all_button mobile-only">
				<input type="button" class="btn btn-large btn-primary" id="disarm_all_button" value="Zaznacz wszystkie" onclick="javascript: check_all_zones()" style="margin-right: 25%"/>
			</div>
		</div>
		<div style="display: table; width: 100%;">
			<?php		
				if($action == 'create')
				{
					foreach($zonesToCheck as $zone)
					{
						?>
							<div class="zone-checkbox">
								<div class="checkbox">
									<label>
										<?php echo $form->checkbox($model, 'alias_access_zone'.$zone->number, array('class'=>"zone_check_checkbox", 'style'=>'margin-left: 15%')); 
										echo CHtml::tag("span", array('style'=>'margin-left: 20%'), $zone->number.'. '.$zone->name);
										?>
									</label>
								</div>											
							</div>
						<?php
					}
				}
				else if($action == 'update')
				{
					foreach($zonesToCheck as $zone)
					{
						?>
							<div class="zone-checkbox">
								<div class="checkbox">
									<label>
										<?php echo $form->checkbox($model, 'alias_access_zone'.$zone->zone->number, array('class'=>"zone_check_checkbox", 'style'=>'margin-left: 15%')); 
										echo CHtml::tag("span", array('style'=>'margin-left: 20%'), $zone->zone->number.'. '.$zone->zone->name);
										?>
									</label>
								</div>											
							</div>
						<?php
					}
				}
			?>							
		</div>
	</div>
</div>

<?php 
if($action == 'update')
{
?>
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
								<?php echo $form->checkbox($model, 'alias_rights1_'.$right->right->bit_no); ?>
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
								<?php echo $form->checkbox($model, 'alias_rights2_'.$right->right->bit_no); ?>
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
								<?php echo $form->checkbox($model, 'alias_rights3_'.$right->right->bit_no); ?>
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
}
else if($action == 'create')
{
?>
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
								<?php echo $form->checkbox($model, 'alias_rights1_'.$right->bit_no); ?>
								<?php echo $right->name; ?>
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
								<?php echo $form->checkbox($model, 'alias_rights2_'.$right->bit_no); ?>
								<?php echo $right->name; ?>
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
								<?php echo $form->checkbox($model, 'alias_rights3_'.$right->bit_no); ?>
								<?php echo $right->name; ?>
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
}

$this->endWidget();

$this->widget('application.extensions.widgets.ActionTitleBar', array(
        'title'=>'',
	'items'=>array(
		array(
                        'label'=>'Zapisz',
                        'url'=>'#',
                        'class'=>'btn btn-success action-btn',
			'onclick'=>'submit_form()'
                ),
		array(
                        'label'=>'Anuluj',
                        'url'=>Yii::app()->controller->createUrl('integraUser/list'),
                        'class'=>'btn btn-default action-btn',
                )
	)
));

?><div style="height: 25px; width: 100%; clear: both"></div><?php

Yii::app()->clientScript->registerScript('expandable-sections',
	'
	$(document).ready(function () {
                
                $(".section-title").click(function(){
			$("#" + this.id + "-content").slideToggle();
		});           
	});
	
	function check_all_zones()
	{
		try
		{
			if($("#check_all_checkbox").prop("checked"))
			{
				$(".zone_check_checkbox").prop("checked", true);
			}		
			else
			{
				$(".zone_check_checkbox").prop("checked", false);
			}
		}
		catch(err){}
	}
	
	function submit_form()
	{
		$("#control-form").submit();
	}
	', CClientScript::POS_HEAD);
?>