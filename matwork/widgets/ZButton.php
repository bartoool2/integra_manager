<?php

class ZButton extends CWidget
{
	public $id;
	
	public $label;
	
	public $url;
	
	public $linked = true;
	
	public $hidden = false;
	
	public $visible = true;
	
	public $htmlOptions = array();

	public function run()
	{
		if ($this->visible)
		{
			$this->htmlOptions['id'] = $this->id;
			
			$this->htmlOptions['class'] = isset($this->htmlOptions['class']) ? 'btn '.$this->htmlOptions['class'] : 'btn';
			
			if ($this->hidden)
			{
				$this->htmlOptions['style'] = isset($this->htmlOptions['style']) ? $this->htmlOptions['style'].' display: none;' : 'display: none;';
			}

			if ($this->url === null)
			{
				$this->url = 'javascript: void(0);';
			}
			
			if ($this->linked)
			{
				?>

				<a <?php echo CHtml::renderAttributes($this->htmlOptions); ?> href="<?php echo $this->url; ?>"><?php echo $this->label; ?></a>

				<?php
			}
			else
			{
				$this->htmlOptions['class'] = $this->htmlOptions['class'].' btn-unlinked';
				
				?>

				<span <?php echo CHtml::renderAttributes($this->htmlOptions); ?>><?php echo $this->label; ?></span>

				<?php
			}
		}
	}
}