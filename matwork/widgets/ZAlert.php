<?php

class ZAlert extends CWidget
{
	public $id;
	
	public $title;
	
	public $text;
	
	public $closable = true;
	
	public $block = false;
	
	public $visible = true;
	
	public $htmlOptions = array();
	
	public function run()
	{
		if ($this->visible)
		{
			$this->htmlOptions['id'] = $this->id;

			$this->htmlOptions['class'] = isset($this->htmlOptions['class']) ? 'alert '.$this->htmlOptions['class'] : 'alert';

			$tag = 'span';

			if ($this->block)
			{
				$tag = 'p';

				$this->htmlOptions['class'] .= ' alert-block';
			}
			
			$this->htmlOptions['style'] = isset($this->htmlOptions['style']) ? $this->htmlOptions['class'] : '';

			if ($this->text === null)
			{
				$this->htmlOptions['style'] = 'display: none; '.$this->htmlOptions['style'];
			}
			
			if (!$this->closable)
			{
				$this->htmlOptions['style'] .= ' padding-right: 8px;';
			}

			?>

			<div <?php echo CHtml::renderAttributes($this->htmlOptions); ?>>
				
			<?php
			if ($this->closable)
			{
				?>

				<a class="close" href="javascript: void(0);" onclick="javascript: $('#<?php echo $this->id; ?>').hide();">&times;</a>

				<?php
			}
			?>

			<strong><span id="<?php echo $this->id; ?>-title"><?php echo $this->title; ?></span></strong> <<?php echo $tag; ?> id="<?php echo $this->id; ?>-text"><?php echo $this->text; ?></<?php echo $tag; ?>>

			</div>

			<?php
		}
	}
}

?>
