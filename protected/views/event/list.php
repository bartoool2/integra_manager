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
                        'label'=>'Aktualizuj',
                        'url'=>Yii::app()->controller->createUrl('event/updateList'),
                        'class'=>'btn btn-primary action-btn',
                ),
        ),
));

$form = $this->beginWidget('CActiveForm', array(
    'id'=>'search-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
)); ?>

<?php echo $form->errorSummary($model); ?>

<div id="event-search" style="display: <?php echo isset($_POST['Event']) ? 'block' : 'none'; ?>; width: 100%; padding: 20px">	  
	<div class="dual-row">
		<div class="dual-column">
			<div style="float: left; text-align: right; padding-right: 20px; width: 30%">
				<?php echo $form->labelEx($model,'description',array('class'=>'control-label', 'style'=>'font-weight: normal')); ?>
			</div>
			<div style="float: left; width: 70%">
				<?php echo $form->textField($model,'description',array('class'=>'form-control')); ?>
			</div>
		</div>
		<div class="dual-column">
			<div style="float: left; width: 30%; text-align: right; padding-right: 20px;">
				<?php echo $form->labelEx($model,'event_class',array('class'=>'control-label', 'style'=>'font-weight: normal')); ?>
			</div>
			<div style="float: left; width: 70%">
				<?php echo $form->dropDownList($model,'event_class',Event::getEventClasses(), array('class'=>'form-control')); ?>
			</div>
		</div>  
	</div>  
	<div class="dual-row">
		<div class="dual-column">
			<div style="float: left; text-align: right; padding-right: 20px; width: 30%">
				<?php echo $form->labelEx($model,'alias_date_from',array('class'=>'control-label', 'style'=>'font-weight: normal')); ?>
			</div>
			<div style="float: left; width: 70%">
				<?php echo $form->textField($model,'alias_date_from',array('class'=>'form-control datepicker')); ?>
			</div>
		</div>
		<div class="dual-column">
			<div style="float: left; text-align: right; padding-right: 20px; width: 30%">
				<?php echo $form->labelEx($model,'alias_date_to',array('class'=>'control-label', 'style'=>'font-weight: normal')); ?>
			</div>
			<div style="float: left; width: 70%">
				<?php echo $form->textField($model,'alias_date_to',array('class'=>'form-control datepicker')); ?>
			</div>
		</div>
	</div>
	<div style="clear: both; width: 100%; padding-top: 10px">
		<div style="float: left; text-align: right; width: 50%">
			<button class="btn btn-primary" style="margin-right: 20px;" type="submit">Szukaj</button>
		</div>
		<div style="width: 50%; float: left">
			<button name="Event[clear]" value="1" class="btn btn-default" style="margin-left: 20px;" type="submit">Wyczyść</button>
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
	'pager'=>array(
		'maxButtonCount'=>6,
		'pageSize'=>15,
		'internalPageCssClass'=>'pagination-button',
		'nextPageCssClass'=>'pagination-button',
		'previousPageCssClass'=>'pagination-button',
		'header'=>''
	),
        'columns'=>array(
                'id',
                array(
                        'name'=>'description',
                        'htmlOptions'=>array(
                                'style'=>'width: 50%'
                        )
                ),
		array(
                        'name'=>'event_class',
			'type'=>'raw',
			'value'=>'CHtml::tag("span", array("class"=>"label label-".$data->classCssClass, "style"=>"display: block; width: 80%; height: 20px"), $data->className)',
                        'htmlOptions'=>array(
                                'style'=>'width: 25%',
                        )
                ),
                array(
                        'name'=>'date',			
                        'htmlOptions'=>array(
                                'style'=>'width: 12%',
                        )
                ),
		array(
                        'name'=>'time',			
                        'htmlOptions'=>array(
                                'style'=>'width: 12%',
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
