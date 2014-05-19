<?php

class ZOptions extends CWidget
{
	public $id;
	
	public $drop = 'down';
	
	public $items;
	
	public $emptyLabel = null;
	
	public $htmlOptions = array();
	
	public function run()
	{
		$this->htmlOptions['id'] = $this->id;
		
		if ($this->emptyLabel === null)
		{
			$this->emptyLabel = Yii::t('matwork', '...');
		}
		
		?>

		<div <?php echo CHtml::renderAttributes($this->htmlOptions); ?>>

		<?php
		
		foreach ($this->items as $item)
		{
			$item['label'] = isset($item['label']) ? $item['label'] : $this->emptyLabel;
			$item['url'] = isset($item['url']) ? $item['url'] : 'javascript: void(0);';
			$item['hidden'] = isset($item['hidden']) ? $item['hidden'] : false;
			$item['visible'] = isset($item['visible']) ? $item['visible'] : true;
			$item['type'] = isset($item['type']) ? $item['type'] : 'item';
			$item['items'] = isset($item['items']) ? $item['items'] : array();
			$item['htmlOptions'] = isset($item['htmlOptions']) ? $item['htmlOptions'] : array();
			
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
						<div class="btn-group" style="display: <?php echo $item['hidden'] ? 'none' : 'inline-block'; ?>">
							<?php
							$item['label'] = isset($item['label']) ? $item['label'] : $this->emptyLabel;
							$item['htmlOptions']['class'] = isset($item['htmlOptions']['class']) ? 'btn '.$item['htmlOptions']['class'].' dropdown-toggle' : 'btn dropdown-toggle';
							$item['htmlOptions']['data-toggle'] = 'dropdown';
							?>
							<a <?php echo CHtml::renderAttributes($item['htmlOptions']); ?> href="<?php echo $item['url']; ?>"><?php echo $item['label']; ?></a>
							<a <?php echo CHtml::renderAttributes($item['htmlOptions']); ?> href="<?php echo $item['url']; ?>"><b class="caret"></b></a>
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
						</div>
						<?php
					}
				}
				else
				{
					
					$item['htmlOptions']['class'] = isset($item['htmlOptions']['class']) ? 'btn '.$item['htmlOptions']['class'] : 'btn';
						
					?>
						<div class="btn-group">
						
							<a <?php echo ZHtml::renderAttributes($item['htmlOptions']); ?> href="<?php echo $item['url']; ?>"><?php echo $item['label']; ?></a>
							
						</div>
					<?php
				}
			}
		}
		
		?>

		</div>

		<?php
	}
}

?>