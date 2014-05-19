<?php

class ZProgress extends CWidget
{
	public $id;
	
	public $bars = array();
	
	public $htmlOptions = array();
	
	public function run()
	{
		$this->htmlOptions['id'] = $this->id;
		
		$this->htmlOptions['class'] = isset($this->htmlOptions['class']) ? 'progress '.$this->htmlOptions['class'] : 'progress';
		
		?>

		<div <?php echo CHtml::renderAttributes($this->htmlOptions); ?>>

		<?php
		
		for ($i = 0; $i < sizeof($this->bars); $i++)
		{
			$bar = $this->bars[$i];
			
			$bar['htmlOptions']['class'] = isset($bar['htmlOptions']['class']) ? 'bar '.$bar['htmlOptions']['class'] : 'bar';
			$bar['htmlOptions']['style'] = isset($bar['htmlOptions']['style']) ? 'width: '.($bar['width']*100).'%; '.$bar['htmlOptions']['style'] : 'width: '.($bar['width']*100).'%;';
			
			?>
			
			<div <?php echo CHtml::renderAttributes($bar['htmlOptions']); ?>><?php echo isset($bar['label']) ? $bar['label'] : ''; ?></div>
			
			<?php
		}
		
		?>
			
		</div>
		
		<?php
	}
}
?>