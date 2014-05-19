<?php

class ZDaySchedule extends CWidget
{
	public $id;
	
	public $time_from;
	
	public $time_to;
	
	public $items;
	
	public $color;
	
	public $empty;
	
	public $step = 'quarter';
	
	public $htmlOptions = array();
	
	public $busyHtmlOptions = array();
	
	public function run()
	{
		$this->registerClientScript();
		
		$this->htmlOptions['id'] = $this->id;
		$this->htmlOptions['class'] = isset($this->htmlOptions['class']) ? ' schedule-day'.$this->htmlOptions['class'] : 'schedule-day';
		
		?>

		<table<?php echo ZHtml::renderAttributes($this->htmlOptions); ?>>
			
		<?php
		
		$test = 0;
		
		for ($i = $this->time_from; ZDateTime::compare($this->time_to, $i) < 0; $i = ZDateTime::add(15, ZDateTime::RANGE_MINUTES, $i))
		{
			$class = null;
			
			if (ZDateTime::format($i, 'i') == 0)
			{
				$class = 'schedule-day-hour';
			}
			
			if (($this->step == 'quarter' || $this->step == 'half') && ZDateTime::format($i, 'i') == 30)
			{
				$class = 'schedule-day-half';
			}
			
			if ($this->step == 'quarter' && (ZDateTime::format($i, 'i') == 15 || ZDateTime::format($i, 'i') == 45))
			{
				$class = 'schedule-day-quarter';
			}
			
			?>
			
			<tr class="<?php echo $class; ?>">
				<td class="schedule-day-label">
				<?php echo Yii::app()->dateFormatter->formatDateTime($i, null, 'short'); ?>
				</td>
				<?php
				
				$item = $this->itemAt($i);

				if ($item !== null)
				{
					$test = isset($item['length']) ? $item['length'] : 1;
					?>
					<td class="schedule-day-item" rowspan="<?php echo $test; ?>">
						<table style="width: 100%; height: 100%;">
							<tr>
								<td class="schedule-busy" style="background-color: green;">
								<?php echo $item['label']; ?>
								</td>	
							</tr>
						</table>
					</td>
					<?php
					$test--;
				}
				else
				{
					if ($test == 0)
					{
						extract(array('time'=>  ZDateTime::format($i, 'H:i')));
						
						$empty = eval('return '.$this->empty.';');
						?>
						<td class="schedule-day-item"><?php echo $empty; ?></td>
						<?php
					}
					else
					{
						$test--;
					}
				}
				?>
			</tr>
			
			<?php
		}
		
		?>
		
		</table>
		
		<?php
	}
	
	public function itemAt($time)
	{
		$found = null;
		
		foreach ($this->items as $item)
		{
			if (ZDateTime::format($item['time_from'], 'H:i') == ZDateTime::format($time, 'H:i'))
			{
				$item['length'] = ZDateTime::difference(ZDateTime::format($item['time_from']), ZDateTime::format($item['time_to']), ZDatetime::FORMAT_MINUTES)/15;
				
				$found = $item;
				break;
			}
		}
		
		return $found;
	}
	
	public function registerClientScript()
	{
		$cs = Yii::app()->getClientScript();
		
		$baseUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('matwork.widgets.assets'));
		
		$cs->registerCssFile($baseUrl.'/css/schedule.css');
	}
}
?>