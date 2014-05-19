<?php

Yii::import('matwork.widgets.column.ZGridColumn');

class ZCheckBoxColumn extends ZGridColumn
{
	public $field = array();
	
	public function init()
	{
		parent::init();
		
		if (!isset($this->htmlOptions['class']))
		{
			$this->htmlOptions['class'] = 'selector';
		}
		
		if (!isset($this->headerHtmlOptions['class']))
		{
			$this->headerHtmlOptions['class'] = 'selector';
		}
		
		if (!isset($this->footerHtmlOptions['class']))
		{
			$this->footerHtmlOptions['class'] = 'selector';
		}
		
		if ($this->field === null)
		{
			throw new CException('Either "field" must be specified for ZCheckBoxColumn.');
		}
	}

	protected function renderFilterCellContent()
	{
		
	}
	
	protected function renderHeaderCellContent()
	{
		
	}
	
	protected function renderDataCellContent($row,$data)
	{
		$name = isset($this->field['name']) ? $this->evaluateExpression($this->field['name'], array('row'=>$row, 'data'=>$data)) : '';
		
		$value = isset($this->field['value']) ? $this->evaluateExpression($this->field['value'], array('row'=>$row, 'data'=>$data)) : '';
		
		echo CHtml::checkBox($name, false, array('value'=>$value));
	}

	public function renderPatternCell($pattern)
	{
		echo CHtml::openTag('td', $this->htmlOptions);
		
		$this->renderPatternCellContent($pattern);
		
		echo '</td>';
	}

	public function renderPatternCellContent($pattern)
	{
		$name = isset($this->field['name']) ? $this->evaluateExpression($this->field['name'], array('row'=>'ROW', 'data'=>$pattern)) : '';
		
		$value = isset($this->field['value']) ? $this->evaluateExpression($this->field['value'], array('row'=>'ROW', 'data'=>$pattern)) : '';
		
		echo CHtml::checkBox($name, false, array('value'=>$value));
	}
}

