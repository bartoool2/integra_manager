<?php

$form = $this->beginWidget('application.extensions.widgets.Search', array(
	'id'=>'search-event',
));

?>

<div class="row-fluid">
	<div class="control-group">
		<?php echo $form->activeLabel($model, 'class'); ?>
		<div class="controls">
			<?php echo $form->textField($model, 'class'); ?>
		</div>
	</div> 
</div>

<?php

$this->endWidget();

?>