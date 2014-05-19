<div id="<?php echo $grid_id; ?>">
<?php

$this->widget('zii.widgets.grid.CGridView', array(	
        'dataProvider'=>$dataProvider,
        'ajaxType'=>'POST',
        'template'=>'{items}{pager}{summary}',
        'summaryText'=>'Wyświetlono {start}-{end} z {count} wyników',
        'columns'=>array(
                array(
                        'name'=>'name',
                        'htmlOptions'=>array(
                                'style'=>'width: 20%'
                        )
                ),
                array(
                        'name'=>'czuwanie',
			'type'=>'raw',
                        'value'=>'$data->_status->value == Zone::STATUS_ARMED ? CHtml::tag("span", array("class"=>"label label-success", "style"=>"display: block; width: 80%; height: 20px")) : null',
			'htmlOptions'=>array(
                                'style'=>'width: 11%'
                        )
                ),
		array(
                        'name'=>'czas na wejście',
			'type'=>'raw',
                        'value'=>'$data->_status->value == Zone::STATUS_TIME_TO_ENTER ? CHtml::tag("span", array("class"=>"label label-warning", "style"=>"display: block; width: 80%; height: 20px")) : null',
			'htmlOptions'=>array(
                                'style'=>'width: 11%'
                        )
                ),
		array(
                        'name'=>'czas na wyjście',
			'type'=>'raw',
                        'value'=>'$data->_status->value == Zone::STATUS_TIME_TO_LEAVE ? CHtml::tag("span", array("class"=>"label label-warning", "style"=>"display: block; width: 80%; height: 20px")) : null',
			'htmlOptions'=>array(
                                'style'=>'width: 11%'
                        )
                ),
		array(
                        'name'=>'alarm',
			'type'=>'raw',
                        'value'=>'$data->_status->value == Zone::STATUS_ALARM ? CHtml::tag("span", array("class"=>"label label-danger", "style"=>"display: block; width: 80%; height: 20px")) : null',
			'htmlOptions'=>array(
                                'style'=>'width: 11%'
                        )
                ),
		array(
                        'name'=>'pożar',
			'type'=>'raw',
                        'value'=>'$data->_status->value == Zone::STATUS_FIRE ? CHtml::tag("span", array("class"=>"label label-danger", "style"=>"display: block; width: 80%; height: 20px")) : null',
			'htmlOptions'=>array(
                                'style'=>'width: 11%'
                        )
                ),
		array(
                        'name'=>'był alarm',
			'type'=>'raw',
                        'value'=>'$data->_status->value == Zone::STATUS_ALARM_REGISTERED ? CHtml::tag("span", array("class"=>"label label-info", "style"=>"display: block; width: 80%; height: 20px")) : null',
			'htmlOptions'=>array(
                                'style'=>'width: 11%;'
                        )
                ),
		array(
                        'name'=>'był pożar',
			'type'=>'raw',
                        'value'=>'$data->_status->value == Zone::STATUS_FIRE_REGISTERED ? CHtml::tag("span", array("class"=>"label label-info", "style"=>"display: block; width: 80%; height: 20px")) : null',
			'htmlOptions'=>array(
                                'style'=>'width: 11%'
                        )
                ),
        ),
        'itemsCssClass'=>'table table-striped',
        'htmlOptions'=>array(
                'class'=>'desktop-only'
        )
));

$this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'ajaxType'=>'POST',
        'template'=>'{items}{pager}{summary}',
        'summaryText'=>'Wyświetlono {start}-{end} z {count} wyników',
        'columns'=>array(
                array(
                        'name'=>'name',
                        'htmlOptions'=>array(
                                'style'=>'width: 50%'
                        )
                ),
                array(
                        'name'=>'status',
			'type'=>'raw',
                        'value'=>'CHtml::tag("span", array("class"=>"label label-".$data->statusClass, "style"=>"display: block; width: 80%; height: 20px"), $data->_status->description)',
			'htmlOptions'=>array(
                                'style'=>'width: 50%'
                        )
                )
        ),
        'itemsCssClass'=>'table table-striped',
        'htmlOptions'=>array(
                'class'=>'mobile-only'
        )
));

?>
</div>