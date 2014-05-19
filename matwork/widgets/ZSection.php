<?php

class ZSection extends CWidget
{
	public $id;
	
	public $title;
	
	public $toggable = false;
	
	public $headerHtmlOptions = array();
	
	public $contentsHtmlOptions = array();
	
	public function init()
	{
		$this->headerHtmlOptions['id'] = $this->id.'-header';
		
		if ($this->toggable)
		{
			Yii::app()->clientScript->registerScript($this->id.'-toggle', '
				$("#'.$this->id.'-header").click(function(){
					$("#'.$this->id.'-contents").slideToggle();
				});
			');
		}
		
		?>

		<legend <?php echo CHtml::renderAttributes($this->headerHtmlOptions); ?>>
		
		<?php
		
		echo $this->title;
		
		$this->contentsHtmlOptions['id'] = $this->id.'-contents';
		
		?>
		
		</legend>
		
		<fieldset <?php echo CHtml::renderAttributes($this->contentsHtmlOptions); ?>>
			
		<?php
	}
	
	public function run()
	{
		?>
			
		</fieldset>
		
		<?php
	}
}
?>