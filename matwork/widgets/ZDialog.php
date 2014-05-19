<?php

class ZDialog extends CWidget
{
	public $id;
	
	public $title;
	
	public $closable = true;
	
	public $buttons = array();
	
	public $htmlOptions = array();
	
	public $headerHtmlOptions = array();
	
	public $bodyHtmlOptions = array();
	
	public $footerHtmlOptions = array();
	
	public function init()
	{
		$this->htmlOptions['id'] = $this->id;
		
		$this->headerHtmlOptions['id'] = $this->id.'-header';
		$this->bodyHtmlOptions['id'] = $this->id.'-body';
		$this->footerHtmlOptions['id'] = $this->id.'-footer';
		
		$this->htmlOptions['class'] = isset($this->htmlOptions['class']) ? 'modal '.$this->htmlOptions['class'] : 'modal hide fade';
		$this->headerHtmlOptions['class'] = isset($this->headerHtmlOptions['class']) ? 'modal-header '.$this->headerHtmlOptions['class'] : 'modal-header';
		$this->bodyHtmlOptions['class'] = isset($this->bodyHtmlOptions['class']) ? 'modal-body '.$this->bodyHtmlOptions['class'] : 'modal-body';
		$this->footerHtmlOptions['class'] = isset($this->footerHtmlOptions['class']) ? 'modal-footer '.$this->footerHtmlOptions['class'] : 'modal-footer';
		
		?>

		<div <?php echo CHtml::renderAttributes($this->htmlOptions); ?>>
		
			<div <?php echo CHtml::renderAttributes($this->headerHtmlOptions); ?>>

			<?php

			if ($this->closable)
			{
				?>
				
				<a class="close" href="javascript: void(0);" data-dismiss="modal" aria-hidden="true">&times;</a>
				
				<?php
			}

			?>

			<h3 id="<?php echo $this->id.'-title'; ?>"><?php echo $this->title; ?></h3>

			</div>
		
			<div <?php echo CHtml::renderAttributes($this->bodyHtmlOptions); ?>>
		
		<?php
	}
	
	public function run()
	{
		?>
		
		</div>
		
		<?php
		
		if (sizeof($this->buttons) > 0)
		{
			?>
			
			<div <?php echo CHtml::renderAttributes($this->footerHtmlOptions); ?>>
				
			<?php

			foreach ($this->buttons as $button)
			{
				$button['url'] = isset($button['url']) ? $button['url'] : 'javascript: void(0);';
				$button['htmlOptions']['class'] = isset($button['htmlOptions']['class']) ? 'btn '.$button['htmlOptions']['class'] : 'btn';
				
				?>
				
				<a <?php echo CHtml::renderAttributes($button['htmlOptions']); ?> href="<?php echo $button['url']; ?>"><?php echo $button['label']; ?></a>
				
				<?php
			}
			
			?>
			
			</div>
			
			<?php
		}
		
		?>

		</div>
		
		<?php
	}
}
?>