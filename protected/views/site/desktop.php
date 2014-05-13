<?php
$this->widget('application.extensions.widgets.ActionTitleBar', array(
        'title'=>'Pulpit',
));
?>

<div class="layout-row">
     
<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'control-form',    
)); ?>
	<ul class="nav nav-tabs">
		<li class="active" style="width: 33%; text-align: center"><a href="#disarm" data-toggle="tab">Rozbrajanie</a></li>
		<li style="width: 33%; text-align: center"><a href="#arm" data-toggle="tab">Uzbrajanie</a></li>
		<li style="width: 34%; text-align: center"><a href="#clear" data-toggle="tab">Kasowanie</a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane fade in active" id="disarm">
			<div class="panel panel-default" style="margin-top: 10px; border-top: none">
				<div class="panel-body">
					<div>
						<div style="width: 25%">
							<div class="checkbox" style="padding-left: 30%">
								<label>
									<input id="disarm_all_checkbox" type="checkbox" checked="checked" onchange="javascript: disarm_check_all()" style="margin-right: 25%" value="1"> Zaznacz wszystkie
								</label>
							</div>
						</div>
					</div>
					<div style="display: table; width: 100%">
						<div style="display: table-row; text-align: center">
							<div style="display: table-cell; width: 25%">
								<div class="checkbox">
									<label>
										<?php echo $form->checkbox($model, 'alias_disarm_zone1', array('class'=>"zone_disarm_checkbox", 'style'=>'margin-left: 15%')); ?>
										Strefa 1
									</label>
								</div>
							</div>
							<div style="display: table-cell; width: 25%">
								<div class="checkbox">
									<label>
										<?php echo $form->checkbox($model, 'alias_disarm_zone2', array('class'=>"zone_disarm_checkbox", 'style'=>'margin-left: 15%')); ?>
										Strefa 2
									</label>
								</div>
							</div>
							<div style="display: table-cell; width: 25%">
								<div class="checkbox">
									<label>
										<?php echo $form->checkbox($model, 'alias_disarm_zone3', array('class'=>"zone_disarm_checkbox", 'style'=>'margin-left: 15%')); ?>
										Strefa 3
									</label>
								</div>
							</div>
							<div style="display: table-cell; width: 25%">
								<div class="checkbox">
									<label>
										<?php echo $form->checkbox($model, 'alias_disarm_zone4', array('class'=>"zone_disarm_checkbox", 'style'=>'margin-left: 15%')); ?>
										Strefa 4
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="input-group" style="margin-top: 20px">
						<span class="input-group-addon">Wprowadź kod</span>
						<input name="Request[disarm_code]" id="Request_disarm_code" type="password" class="form-control">
						<span class="input-group-btn">
							<button name="Request[action_disarm]" id="Request_action_disarm" class="btn btn-primary" type="submit">Rozbrój alarm</button>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="arm">
			<div class="panel panel-default" style="margin-top: 10px; border-top: none">
				<div class="panel-body">
					<div>
						<div style="width: 25%">
							<div class="checkbox" style="padding-left: 30%">
								<label>
									<input id="arm_all_checkbox" type="checkbox" checked="checked" onchange="javascript: arm_check_all()" style="margin-right: 25%" value="1"> Zaznacz wszystkie
								</label>
							</div>
						</div>
					</div>
					<div style="display: table; width: 100%">
						<div style="display: table-row; text-align: center">
							<div style="display: table-cell; width: 25%">
								<div class="checkbox">
									<label>
										<?php echo $form->checkbox($model, 'alias_arm_zone1', array('class'=>"zone_arm_checkbox", 'style'=>'margin-left: 15%')); ?>
										Strefa 1 
									</label>
								</div>
							</div>
							<div style="display: table-cell; width: 25%">
								<div class="checkbox">
									<label>
										<?php echo $form->checkbox($model, 'alias_arm_zone2', array('class'=>"zone_arm_checkbox", 'style'=>'margin-left: 15%')); ?>
										Strefa 2
									</label>
								</div>
							</div>
							<div style="display: table-cell; width: 25%">
								<div class="checkbox">
									<label>
										<?php echo $form->checkbox($model, 'alias_arm_zone3', array('class'=>"zone_arm_checkbox", 'style'=>'margin-left: 15%')); ?>
										Strefa 3
									</label>
								</div>
							</div>
							<div style="display: table-cell; width: 25%">
								<div class="checkbox">
									<label>
										<?php echo $form->checkbox($model, 'alias_arm_zone4', array('class'=>"zone_arm_checkbox", 'style'=>'margin-left: 15%')); ?>
										Strefa 4
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="input-group" style="margin-top: 20px">
						<span class="input-group-addon">Wprowadź kod</span>
						<input name="Request[arm_code]" id="Request_arm_code" type="password" class="form-control">
						<span class="input-group-btn">
							<button name="Request[action_arm]" id="Request_action_arm" class="btn btn-primary" type="submit">Uzbrój alarm</button>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="clear">
			<div class="panel panel-default" style="margin-top: 10px;">
				<div class="panel-body">
					<div class="input-group">
						<span class="input-group-addon">Wprowadź kod</span>
						<input name="Request[clear_alarm_code]" id="Request_clear_alarm_code" type="password" class="form-control">
						<span class="input-group-btn">
							<button name="Request[action_clear_alarm]" id="Request_action_clear_alarm" class="btn btn-primary" type="submit">Kasuj alarm</button>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->endWidget(); ?>
</div>

<?php

Yii::app()->clientScript->registerScript('buyer-scan-service',
	'function disarm_check_all()
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
	
	function arm_check_all()
	{
		if($("#arm_all_checkbox").prop("checked"))
		{
			$(".zone_arm_checkbox").prop("checked", true);
		}		
		else
		{
			$(".zone_arm_checkbox").prop("checked", false);
		}
	}', CClientScript::POS_HEAD);
?>