<?php
$this->widget('application.extensions.widgets.ActionTitleBar', array(
        'title'=>'Pulpit',
));

//$zonesToArm = array(1, 2, 3, 4,5,6);
//$zonesToDisarm = array(1, 2, 3, 4,5,6);
$zonesToDisarm = Zone::getZonesToDisarm();
$zonesToArm = Zone::getZonesToArm();
$zonesToClear = Zone::getZonesToClear();
//$zonesToClear = $zonesToDisarm;
//$zonesToArm = $zonesToDisarm;

?>

<div class="layout-row">
     
<?php $form = $this->beginWidget('application.extensions.Form', array(
    'id'=>'control-form',    
)); 

echo CHtml::errorSummary($model, "<strong>Operacja nie powiodła się, ponieważ:</strong>", null, array("class"=>"alert alert-danger"));
//echo $form->();
?>
	<ul class="nav nav-tabs">
		<li class="active" style="width: 33%; text-align: center"><a href="#disarm" data-toggle="tab">Rozbrajanie</a></li>
		<li style="width: 33%; text-align: center"><a href="#arm" data-toggle="tab">Uzbrajanie</a></li>
		<li style="width: 34%; text-align: center"><a href="#clear" data-toggle="tab">Kasowanie</a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane fade in active" id="disarm">
			<div class="panel panel-default" style="margin-top: 10px; border-top: none; display: <?php echo count($zonesToDisarm) > 0 ? 'block' : 'none'; ?>">
				<div class="panel-body">
					<div>
						<div class="disarm_all_checkbox desktop-only">
							<div class="checkbox" style="padding-left: 30%">
								<label>
									<input id="disarm_all_checkbox" type="checkbox" checked="checked" onchange="javascript: disarm_check_all()" style="margin-right: 25%" value="1"> Rozbrój cały system
								</label>
							</div>
						</div>
						<div class="disarm_all_button mobile-only">
							<input type="button" class="btn btn-large btn-primary" id="disarm_all_button" value="Rozbrój cały system" onclick="javascript: disarm_check_all()" style="margin-right: 25%"/>
						</div>
					</div>
					<div style="display: table; width: 100%;">
						<?php							
							foreach($zonesToDisarm as $zone)
							{
								?>
									<div class="zone-checkbox">
										<div class="checkbox">
											<label>
												<?php echo $form->checkbox($model, 'alias_disarm_zone'.$zone->number, array('class'=>"zone_disarm_checkbox", 'style'=>'margin-left: 15%')); 
												echo CHtml::tag("span", array('style'=>'margin-left: 20%'), $zone->number.'. '.$zone->name);
												?>
											</label>
										</div>											
									</div>
								<?php
							}
						?>							
					</div>
					<div class="input-group" style="margin-top: 20px">
						<span class="input-group-addon desktop-only-table-cell">Wprowadź kod</span>
						<span class="input-group-addon mobile-only-table-cell">Kod</span>
						<input name="Request[disarm_code]" id="Request_disarm_code" type="password" class="form-control">
						<span class="input-group-btn">
							<button name="Request[action_disarm]" id="Request_action_disarm" class="btn btn-primary" type="submit">Rozbrój alarm</button>
						</span>
					</div>
				</div>
			</div>
			<div style="display: <?php echo count($zonesToDisarm) == 0 ? 'block' : 'none'; ?>">
				<div class="alert alert-success" style="text-align: center; margin-top: 20px"><strong>Wszystkie strefy są obecnie rozbrojone</strong></div>				
			</div>
		</div>
		<div class="tab-pane fade" id="arm">
			<div class="panel panel-default" style="margin-top: 10px; border-top: none; display: <?php echo count($zonesToArm) > 0 ? 'block' : 'none'; ?>">
				<div class="panel-body">
					<div>
						<div class="disarm_all_checkbox desktop-only">
							<div class="checkbox" style="padding-left: 30%">
								<label>
									<input id="arm_all_checkbox" type="checkbox" checked="checked" onchange="javascript: arm_check_all()" style="margin-right: 25%" value="1"> Uzbrój cały system
								</label>
							</div>
						</div>
						<div class="arm_all_button mobile-only">
							<input type="button" class="btn btn-large btn-primary" id="arm_all_button" value="Uzbrój cały system" onclick="javascript: arm_check_all()" style="margin-right: 25%"/>
						</div>
					</div>	
					<div style="display: table; width: 100%;">
						<?php							
							foreach($zonesToArm as $zone)
							{
								?>
									<div class="zone-checkbox">
										<div class="checkbox">
											<label>
												<?php echo $form->checkbox($model, 'alias_disarm_zone'.$zone->number, array('class'=>"zone_arm_checkbox", 'style'=>'margin-left: 15%')); 
												echo CHtml::tag("span", array('style'=>'margin-left: 20%'), $zone->number.'. '.$zone->name);
												?>
											</label>
										</div>											
									</div>
								<?php
							}
						?>							
					</div>
					<div class="input-group" style="margin-top: 20px">
						<span class="input-group-addon desktop-only-table-cell">Wprowadź kod</span>
						<span class="input-group-addon mobile-only-table-cell">Kod</span>
						<input name="Request[arm_code]" id="Request_arm_code" type="password" class="form-control">
						<span class="input-group-btn">
							<button name="Request[action_arm]" id="Request_action_arm" class="btn btn-primary" type="submit">Uzbrój alarm</button>
						</span>
					</div>
				</div>
			</div>
			<div style="display: <?php echo count($zonesToArm) == 0 ? 'block' : 'none'; ?>">
				<div class="alert alert-success" style="text-align: center; margin-top: 20px"><strong>Wszystkie strefy są obecnie uzbrojone</strong></div>
			</div>				
		</div>
		<div class="tab-pane fade" id="clear">
			<div class="panel panel-default" style="margin-top: 10px; border-top: none; display: <?php echo count($zonesToClear) > 0 ? 'block' : 'none'; ?>">
				<div class="panel-body">
					<div>
						<div class="clear_all_checkbox desktop-only">
							<div class="checkbox" style="padding-left: 25%">
								<label>
									<input id="clear_all_checkbox" type="checkbox" checked="checked" onchange="javascript: clear_check_all()" style="margin-right: 25%" value="1"> Skasuj wszystkie alarmy
								</label>
							</div>
						</div>
						<div class="arm_all_button mobile-only">
							<input type="button" class="btn btn-large btn-primary" id="clear_all_button" value="Skasuj wszystkie alarmy" onclick="javascript: clear_check_all()" style="margin-right: 25%"/>
						</div>
					</div>	
					<div style="display: table; width: 100%;">
						<?php							
							foreach($zonesToClear as $zone)
							{
								?>
									<div class="zone-checkbox">
										<div class="checkbox">
											<label>
												<?php echo $form->checkbox($model, 'alias_clear_zone'.$zone->number, array('class'=>"zone_clear_checkbox", 'style'=>'margin-left: 15%')); 
												echo CHtml::tag("span", array('style'=>'margin-left: 20%'), $zone->number.'. '.$zone->name);
												?>
											</label>
										</div>											
									</div>
								<?php
							}
						?>							
					</div>
					<div class="input-group">
						<span class="input-group-addon desktop-only-table-cell">Wprowadź kod</span>
						<span class="input-group-addon mobile-only-table-cell">Kod</span>
						<input name="Request[clear_alarm_code]" id="Request_clear_alarm_code" type="password" class="form-control">
						<span class="input-group-btn">
							<button name="Request[action_clear_alarm]" id="Request_action_clear_alarm" class="btn btn-primary" type="submit">Kasuj alarm</button>
						</span>
					</div>
				</div>
			</div>
			<div style="display: <?php echo count($zonesToClear) == 0 ? 'block' : 'none'; ?>">
				<div class="alert alert-success" style="text-align: center; margin-top: 20px"><strong>Brak alarmów do skasowania</strong></div>
			</div>	
		</div>
	</div>
<?php $this->endWidget(); ?>
</div>

<?php

Yii::app()->clientScript->registerScript('buyer-scan-service',
	'function disarm_check_all()
	{
		try
		{
			if($("#disarm_all_checkbox").prop("checked"))
			{
				$(".zone_disarm_checkbox").prop("checked", true);
			}		
			else
			{
				$(".zone_disarm_checkbox").prop("checked", false);
			}
		}
		catch(err){}
	}
	
	function clear_check_all()
	{
		try
		{
			if($("#clear_all_checkbox").prop("checked"))
			{
				$(".zone_clear_checkbox").prop("checked", true);
			}		
			else
			{
				$(".zone_clear_checkbox").prop("checked", false);
			}
		}
		catch(err){}
	}
	
	function arm_check_all()
	{
		try
		{
			if($("#arm_all_checkbox").prop("checked"))
			{
				$(".zone_arm_checkbox").prop("checked", true);
			}		
			else
			{
				$(".zone_arm_checkbox").prop("checked", false);
			}
		}
		catch(err){}
	}', CClientScript::POS_HEAD);
?>