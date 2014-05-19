<?php

Yii::import('matwork.widgets.column.ZGridColumn');

class ZButtonColumn extends ZGridColumn
{
	public $buttonCssClass;
	
	public $buttons = array();
	
	protected function renderButton($button, $row, $data)
	{
		$button['visible'] = isset($button['visible']) ? $this->evaluateExpression($button['visible'], array('row'=>$row, 'data'=>$data)) : true;
		
		$button['htmlOptions']['class'] = isset($button['htmlOptions']['class']) ? 'btn '.$button['htmlOptions']['class'] : 'btn';
		
		if ($this->buttonCssClass !== null)
		{
			$button['htmlOptions']['class'] .= ' '.$this->buttonCssClass;
		}
		
		if (isset($button['cssClassExpression']))
		{
			$button['htmlOptions']['class'] .= ' '.$this->evaluateExpression($button['cssClassExpression'], array('data'=>$data, 'row'=>$row));
		}
		
		$button['url'] = isset($button['url']) ? $this->evaluateExpression($button['url'], array('data'=>$data, 'row'=>$row)) : 'javascript: void(0);';
		
		if (isset($button['ajax']) && $button['ajax'] == true)
		{							                                                        
			if (isset($button['confirmation']))
			{
				$button['htmlOptions']['onclick'] = 'javascript: ajax_grid("'.$this->grid->id.'", "'.$button['url'].'", {confirm: "'.$button['confirm'].'"})';                                                            
			}							
			else
			{
				$button['htmlOptions']['onclick'] = 'javascript: ajax_grid("'.$this->grid->id.'", "'.$url.'", {})';
			}

			$button['url'] = 'javascript: void(0);';
		}
		
		if (isset($button['htmlOptions']['onclick']))
		{
			$button['htmlOptions']['onclick'] = $this->evaluateExpression($button['htmlOptions']['onclick'], array('row'=>$row, 'data'=>$data));
		}
		
		if (true)
		{
			echo CHtml::link($button['label'], $button['url'], $button['htmlOptions']);
		}
	}
	
	protected function renderDataCellContent($row, $data)
	{
		foreach ($this->buttons as $button)
		{
			$this->renderButton($button, $row, $data);
		}
	}
	
	public function renderPatternCell($pattern)
	{
		echo CHtml::openTag('td', $this->htmlOptions);
		
		$this->renderPatternCellContent($pattern);
		
		echo '</td>';
	}
	
	public function renderPatternCellContent($pattern)
	{
		foreach ($this->buttons as $button)
		{
			$this->renderButton($button, 'ROW', $pattern);
		}
	}
}
