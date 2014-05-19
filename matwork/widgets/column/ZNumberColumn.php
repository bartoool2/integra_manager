<?php

Yii::import('matwork.widgets.column.ZGridColumn');

class ZNumberColumn extends ZGridColumn
{	
	protected function renderDataCellContent($row, $data)
	{
		if ($this->grid->dataProvider->pagination)
		{
			echo $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row + 1;
		}
		else
		{
			echo $row + 1;
		}
	}
	
	public function renderPatternCell($pattern)
	{
		echo CHtml::openTag('td', $this->htmlOptions);
		
		$this->renderPatternCellContent($pattern);
		
		echo '</td>';
	}
	
	public function renderPatternCellContent($data)
	{
		
	}
}
