<?php
$this->widget('application.extensions.widgets.ActionTitleBar', array(
        'title'=>'Pulpit',
));
?>

<div class="layout-row">
     
<form method="post">
<?php

$this->widget('application.extensions.widgets.PanelForm', array(
        'id'=>'Disarm',
        'title'=>'Rozbrajanie alarmu',
        'buttonLabel'=>'Rozbrój alarm'
));

$this->widget('application.extensions.widgets.PanelForm', array(
        'id'=>'Arm',
        'cssClass'=>'right',
        'title'=>'Uzbrajanie alarmu',
        'buttonLabel'=>'Uzbrój alarm'
));

?>

</form>
</div>