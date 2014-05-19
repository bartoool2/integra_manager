<?php

class ZMenu extends CWidget
{
	public $id;
	
	public $drop = 'down';
	
	public $items;
	
	public $htmlOptions = array();
	
	public function run()
	{
		$this->htmlOptions['id'] = $this->id;
		
		$this->htmlOptions['class'] = isset($this->htmlOptions['class']) ? 'nav '.$this->htmlOptions['class'] : 'nav';
		
		?>

		<ul <?php echo CHtml::renderAttributes($this->htmlOptions); ?>>

		<?php
		
		foreach ($this->items as $item)
		{
			$item['url'] = isset($item['url']) ? $item['url'] : 'javascript: void(0);';
			$item['visible'] = isset($item['visible']) ? $item['visible'] : true;
			$item['type'] = isset($item['type']) ? $item['type'] : 'item';
			$item['items'] = isset($item['items']) ? $item['items'] : array();
			
			if ($item['visible'])
			{
				if (sizeof($item['items']) > 0)
				{
					$visibleExists = false;
		
					foreach ($item['items'] as $subitem)
					{
						$subitem['visible'] = isset($subitem['visible']) ? $subitem['visible'] : true;

						if ($subitem['visible'])
						{
							$visibleExists = true;

							break;
						}
					}
					
					if ($visibleExists)
					{
						?>
						<li class="dropdown">
							<a href="<?php echo $item['url']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $item['label']; ?></a>
							<ul class="dropdown-menu">
								<?php
								for ($j = 0; $j < sizeof($item['items']); $j++)
								{
									$subitem = $item['items'][$j];

									$subitem['type'] = isset($subitem['type']) ? $subitem['type'] : 'item';
									$subitem['icon'] = isset($subitem['icon']) ? $subitem['icon'] : null;
									$subitem['url'] = isset($subitem['url']) ? $subitem['url'] : 'javascript: void(0);';
									$subitem['visible'] = isset($subitem['visible']) ? $subitem['visible'] : true;

									if ($subitem['visible'] && ($subitem['type'] == 'header' || $subitem['type'] == 'divider'))
									{
										$subitem['visible'] = false;

										for ($k = $j + 1; $k < sizeof($item['items']); $k++)
										{
											$item['items'][$k]['visible'] = isset($item['items'][$k]['visible']) ? $item['items'][$k]['visible'] : true;
											$item['items'][$k]['type'] = isset($item['items'][$k]['type']) ? $item['items'][$k]['type'] : 'item';

											if ($item['items'][$k]['visible'] && ($item['items'][$k]['type'] != 'header' && $item['items'][$k]['type'] != 'divider'))
											{
												$subitem['visible'] = true;
												break;
											}
										}
									}

									if ($subitem['visible'])
									{
										$subitem['htmlOptions'] = isset($subitem['htmlOptions']) ? $subitem['htmlOptions'] : array();

										switch ($subitem['type'])
										{
											case 'item':
												?>
												<li>
													<a <?php echo CHtml::renderAttributes($subitem['htmlOptions']);?> href="<?php echo $subitem['url']; ?>"><?php echo $subitem['icon']; ?><?php echo $subitem['label']; ?></a>
												</li>
												<?php
												break;
											case 'header':
												?>
												<li class="nav-header"><?php echo $subitem['label']; ?></li>
												<?php
												break;
											case 'divider':
												?>
												<li class="divider"></li>
												<?php
												break;
										}
									}
								}
								?>
							</ul>
						</li>
						<?php
					}
				}
				else
				{
					if ($item['type'] == 'header')
					{
						?>
						<li class="nav-header"><?php echo $item['label']; ?></li>
						<?php
					}
					else
					{
						?>
						<li>
							<a href="<?php echo $item['url']; ?>"><?php echo 'dupa';//$item['label']; ?></a>
						</li>
						<?php
					}
				}
			}
		}
		
		?>

		</ul>

		<?php
	}
}

?>
