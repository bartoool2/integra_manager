<?php

class ZTabItem extends CWidget
{
        public $id;
	
	public $active = false;
	
	public $htmlOptions = array();
        
	public function init()
	{
		$this->htmlOptions['id'] = $this->id;
		
		$this->htmlOptions['class'] =  isset($this->htmlOptions['class']) ? 'tab-pane '.$this->htmlOptions['style'] : 'tab-pane';
		
		if ($this->active)
		{
			$this->htmlOptions['class'] .= ' active';
		}

		?>

		<div <?php echo CHtml::renderAttributes($this->htmlOptions); ?>>

		<?php
	}
	
        public function run()
	{
		?>
		
		</div>

		<?php
	}
}

?>
