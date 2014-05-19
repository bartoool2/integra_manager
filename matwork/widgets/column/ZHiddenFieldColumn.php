<?php

Yii::import('matwork.widgets.column.ZGridColumn');

class ZHiddenFieldColumn extends ZGridColumn
{
	public $field = array();
	
	public function init()
	{
		parent::init();
		
		$this->htmlOptions['style'] = 'display: none;';
		$this->headerHtmlOptions['style'] = 'display: none;';
		$this->footerHtmlOptions['style'] = 'display: none;';
		
		if ($this->field === null)
		{
			throw new CException('Either "field" must be specified for ZHiddenFieldColumn.');
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
		
		echo CHtml::hiddenField($name, $value);
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
		
		echo CHtml::hiddenField($name, $value);
	}
}

