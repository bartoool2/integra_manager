<?php

class ZCarousel extends CWidget
{
	public $id;
	
	public $drop = 'down';
	
	public $class;
	
	public $items;
	
	public $showIndicators = true;
	
	public $showNavigation = true;
	
	public $htmlOptions;
	
	public function run()
	{
		?>

		<div class="carousel slide">

		<?php
		
		if ($this->showIndicators)
		{
			?>
			<div class="carousel-indicators">
				<ol>
				<?php
					for ($i = 0; $i < sizeof($this->items); $i++)
					{
						?>
						<li data-target="#<?php echo $this->id; ?>" data-slide-to="<?php echo $i; ?>"></li>
						<?php
					}
				?>
				</ol>
			</div>
			<?php
		}

		?>
		<div class="carousel-inner">
		<?php
			for ($i = 0; $i < sizeof($this->items); $i++)
			{
				$item = $this->items[$i];
				
				$item['htmlOptions']['class'] = isset($item['htmlOptions']['class']) ? 'item '.$item['htmlOptions']['class'] : 'item';
				
				if ($i == 0)
				{
					$item['htmlOptions']['class'] = $item['htmlOptions']['class'].' active';
				}
				
				$item['image']['htmlOptions'] = isset($item['image']['htmlOptions']) ? $item['image']['htmlOptions'] : array();
				
				?>
				<div <?php echo CHtml::renderAttributes($item['htmlOptions']); ?>>
					<?php
					if (isset($item['image']['link']))
					{
						?>
						<a href="<?php echo $item['image']['link']; ?>"><img <?php echo CHtml::renderAttributes($item['image']['htmlOptions']); ?> src="<?php echo $item['image']['source']; ?>" /></a>
						<?php
					}
					else
					{
						?>
						<img <?php echo CHtml::renderAttributes($item['image']['htmlOptions']); ?> src="<?php echo $item['image']['source']; ?>" />
						<?php
					}
					if (isset($item['title']))
					{
						$item['title']['htmlOptions'] = isset($item['title']['htmlOptions']) ? $item['title']['htmlOptions'] : array();
						?>
						<div class="carousel-caption">
							<?php
							if (isset($item['title']['link']))
							{
								?>
								<a href="<?php echo $item['title']['link']; ?>"><h5 <?php echo CHtml::renderAttributes($item['title']['htmlOptions']); ?>><?php echo $item['title']['text']; ?></h5></a>
								<?php
							}
							else
							{
								?>
								<h5 <?php echo CHtml::renderAttributes($item['title']['htmlOptions']); ?>><?php echo $item['title']['text']; ?></h5>
								<?php
							}
							if (isset($item['caption']['description']))
							{
								?>
								<p><?php echo $item['caption']['description']; ?></p>
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
		?>
		</div>
		<?php
		
		if ($this->showNavigation)
		{
			?>
			<a class="left carousel-control" href="<?php echo $this->id; ?>" data-slide="prev">‹</a>
			<a class="right carousel-control" href="<?php echo $this->id; ?>" data-slide="next">‹</a>
			<?php
		}
		
		?>

		</div>

		<?php
	}
}

?>
