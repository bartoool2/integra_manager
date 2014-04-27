<?php
$this->widget('application.extensions.widgets.ActionTitleBar', array(
        'title'=>'Lista zdarzeń',
        'items'=>array(
                array(
                        'label'=>'Odśwież',
                        'url'=>Yii::app()->controller->createUrl('event/refresh'),
                        'class'=>'btn btn-primary action-btn'
                ),
        ),
));

$dataProvider=new CActiveDataProvider('Event');

$this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'ajaxType'=>'POST',
        'template'=>'{items}{pager}{summary}',
        'summaryText'=>'Wyświetlono {start}-{end} z {count} wyników',
        'columns'=>array(
                'id',
                array(
                        'name'=>'description',
                        'htmlOptions'=>array(
                                'style'=>'width: 65%'
                        )
                ),
                array(
                        'name'=>'time',
                        'htmlOptions'=>array(
                                'style'=>'width: 30%',
                        )
                ),
        ),
        'itemsCssClass'=>'table table-striped',
//        'htmlOptions'=>array(
//                'class'=>'mobile-only'
//        )
));

?>
