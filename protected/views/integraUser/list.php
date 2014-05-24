<?php
$this->widget('application.extensions.widgets.ActionTitleBar', array(
        'title'=>'Lista zdarzeń',
        'items'=>array(
                array(
                        'label'=>'Szukaj',
                        'url'=>'#',
                        'class'=>'btn btn-default action-btn',
			'onclick'=>'toggle_search()'
                ),
		array(
                        'label'=>'Utwórz',
                        'url'=>Yii::app()->controller->createUrl('integraUser/create'),
                        'class'=>'btn btn-success action-btn',
                ),
        ),
));

$form = $this->beginWidget('CActiveForm', array(
    'id'=>'search-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
)); ?>

<?php echo $form->errorSummary($model); ?>

<div id="event-search" style="display: <?php echo isset($_POST['IntegraUser']) ? 'block' : 'none'; ?>; width: 100%; padding: 20px;">	  
	<div class="dual-row">
		<div class="dual-column">
			<div style="float: left; text-align: right; padding-right: 20px; width: 30%">
				<?php echo $form->labelEx($model,'number',array('class'=>'control-label', 'style'=>'font-weight: normal')); ?>
			</div>
			<div style="float: left; width: 70%">
				<?php echo $form->textField($model,'number',array('class'=>'form-control')); ?>
			</div>
		</div>
		<div class="dual-column">
			<div style="float: left; width: 30%; text-align: right; padding-right: 20px;">
				<?php echo $form->labelEx($model,'name',array('class'=>'control-label', 'style'=>'font-weight: normal')); ?>
			</div>
			<div style="float: left; width: 70%">
				<?php //echo $form->dropDownList($model,'name',IntegraUser::getIntegraUserClasses(), array('class'=>'form-control'));
				echo $form->textField($model,'name', array('class'=>'form-control'));?>
			</div>
		</div>  
	</div>  
	<div class="single-row">
		<div style="float: left; text-align: right; padding-right: 20px; width: 15%">
			<?php echo $form->labelEx($model,'type',array('class'=>'control-label', 'style'=>'font-weight: normal')); ?>
		</div>
		<div style="float: left; width: 85%">
			<?php echo $form->dropDownList($model,'type',  IntegraUser::getTypeEnum(),array('class'=>'form-control')); ?>
		</div>
	</div>
	<div style="clear: both; width: 100%; padding-top: 10px">
		<div style="float: left; text-align: right; width: 50%">
			<button class="btn btn-primary" style="margin-right: 20px;" type="submit">Szukaj</button>
		</div>
		<div style="width: 50%; float: left">
			<button name="IntegraUser[clear]" value="1" class="btn btn-default" style="margin-left: 20px;" type="submit">Wyczyść</button>
		</div>
	</div>
</div>
</div>

<?php $this->endWidget(); ?>

<?php

$this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$model->search(),
        'ajaxType'=>'POST',
        'template'=>'{items}{pager}{summary}',
        'summaryText'=>'Wyświetlono {start}-{end} z {count} wyników',
        'columns'=>array(
		array(
                        'name'=>'number',
			'header'=>'Nr',
                        'htmlOptions'=>array(
                                'style'=>'width: 5%'
                        )
                ),		
                array(
                        'name'=>'name',
			'type'=>'raw',
			'value'=>'CHtml::link($data->name, Yii::app()->controller->createUrl(\'integraUser/view\', array(\'userId\'=>$data->id)))',
                        'htmlOptions'=>array(
                                'style'=>'width: 75%'
                        )
                ),
		array(
                        'name'=>'type',
			'type'=>'raw',
			'value'=>'$data->typeName',
                        'htmlOptions'=>array(
                                'style'=>'width: 20%',
                        )
                ),
        ),
        'itemsCssClass'=>'table table-striped',
//        'htmlOptions'=>array(
//                'class'=>'mobile-only'
//        )
));

Yii::app()->clientScript->registerScript('buyer-scan-service',
	'
	$(document).ready(function () {
                
                $(".datepicker").datepicker({
                    format: "yyyy-mm-dd"
                });  
            
            });
	
	function toggle_search()
	{
		$("#event-search").fadeToggle();
	}', CClientScript::POS_HEAD);
?>
