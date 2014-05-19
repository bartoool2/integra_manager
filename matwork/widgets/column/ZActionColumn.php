<?php

Yii::import('matwork.widgets.column.ZGridColumn');

class ZActionColumn extends ZGridColumn
{
	public $label;
	
	public $actions = array();

	protected function renderDataCellContent($row, $data)
	{
		$visibleExists = false;
		
		foreach ($this->actions as $action)
		{
			$visible = isset($action['visible']) ? $this->evaluateExpression($action['visible'], array('data'=>$data, 'row'=>$row)) : true;
			
			if ($visible)
			{
				$visibleExists = true;
				
				break;
			}
		}
		
		if ($visibleExists)
		{
			if ($this->label === null)
			{
				$this->label = Yii::t('matwork', '...');
			}
			
			?>

			<div class="btn-group" style="text-align: left;">

			<a class="btn btn-small" data-toggle="dropdown"><?php echo $this->label; ?></a>

			<a class="btn btn-small dropdown-toggle" data-toggle="dropdown"><span class="caret"></b></a>	

			<ul class="dropdown-menu">
				
			<?php

			for ($j = 0; $j < sizeof($this->actions); $j++)
			{
				$subitem = $this->actions[$j];

				$subitem['type'] = isset($subitem['type']) ? $subitem['type'] : 'item';
				$subitem['url'] = isset($subitem['url']) ? $this->evaluateExpression($subitem['url'], array('data'=>$data, 'row'=>$row)) : 'javascript: void(0);';
				$subitem['visible'] = isset($subitem['visible']) ? $this->evaluateExpression($subitem['visible'], array('data'=>$data, 'row'=>$row)) : true;
				
				$subitem['htmlOptions'] = isset($subitem['htmlOptions']) ? $subitem['htmlOptions'] : array();

				if ($subitem['visible'])
				{
					if ($subitem['visible'] && ($subitem['type'] == 'header' || $subitem['type'] == 'divider'))
					{
						$subitem['visible'] = false;

						for ($k = $j + 1; $k < sizeof($this->actions) - 1; $k++)
						{
							$this->actions[$j + 1]['visible'] = isset($this->actions[$j + 1]['visible']) ? $this->actions[$j + 1]['visible'] : true;

							if ($this->actions[$j + 1]['visible'] && ($subitem['type'] != 'header' && $subitem['type'] != 'divider'))
							{
								$subitem['visible'] = true;
							}
						}
					}

					switch ($subitem['type'])
					{
						case 'item':
							?>
							<li>
								<a <?php echo CHtml::renderAttributes($subitem['htmlOptions']); ?> href="<?php echo $subitem['url']; ?>"><?php echo $subitem['label']; ?></a>
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

	public function renderPatternCell($pattern)
	{
		
	}

	public function renderPatternCellContent($pattern)
	{
		
	}
}
