<?php

class ZImage extends CWidget
{
	public $id;
	
	public $source;
	
	public $emptySource;
	
	public $htmlOptions;
	
	public function run()
	{
		$this->htmlOptions['id'] = $this->id;
		
		?>

		<img <?php echo CHtml::renderAttributes($this->htmlOptions); ?> src="<?php echo $this->source !== null ? $this->source : $this->emptySource; ?>" />

		<?php
	}
}