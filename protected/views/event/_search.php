<?php

$form = $this->beginWidget('application.extensions.widgets.Search', array(
	'id'=>'search-event',
));

?>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->activeLabel($model, 'event_class'); ?>
		<div class="controls">
			<?php echo $form->textField($model, 'event_class'); ?>
		</div>
	</div> 
</div>

<?php

$this->endWidget();

?>