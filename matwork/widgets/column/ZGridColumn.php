<?php

Yii::import('zii.widgets.grid.CGridColumn');

abstract class ZGridColumn extends CGridColumn
{
	public $number;
	
	public function __construct($grid)
	{
		$this->grid = $grid;
		
		parent::__construct($grid);
	}

	public function init()
	{
		$this->htmlOptions['data-column'] = $this->number;
		
		parent::init();
	}
	
	abstract function renderPatternCell($pattern);
	
	abstract function renderPatternCellContent($pattern);
}
