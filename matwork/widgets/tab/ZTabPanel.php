<?php

class ZTabPanel extends CWidget
{
        public $id;
	
	public $items;
	
	public $active;
	
	public $htmlOptions = array();
        
        public function init()
	{
		$this->htmlOptions['id'] = $this->id;
		
		$this->htmlOptions['class'] = isset($this->htmlOptions['class']) ? 'nav '.$this->htmlOptions['class'] : 'nav';
		
		?>

		<ul <?php echo CHtml::renderAttributes($this->htmlOptions); ?>>

		<?php

		foreach ($this->items as $item)
		{
			$item['visible'] = isset($item['visible']) ? $item['visible'] : true;
			
			if ($item['visible'])
			{
				$item['htmlOptions'] = isset($item['htmlOptions']) ? $item['htmlOptions'] : array();
				
				if ($this->active == $item['id'])
				{
					?>
						<li class="active"><a <?php echo CHtml::renderAttributes($item['htmlOptions']); ?> href="#<?php echo $item['id']; ?>" data-toggle="tab"><?php echo $item['label']; ?></a></li>        
					<?php  
				}
				else 
				{
					?>
						<li><a <?php echo CHtml::renderAttributes($item['htmlOptions']); ?> href="#<?php echo $item['id']; ?>" data-toggle="tab"><?php echo $item['label']; ?></a></li>        
					<?php   
				}
			}
		}

		?>

		</ul>

		<div class="tab-content">

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
