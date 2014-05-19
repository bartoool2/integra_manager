<?php

Yii::import('matwork.widgets.ZList');
Yii::import('matwork.widgets.column.ZCheckBoxColumn');
Yii::import('matwork.widgets.column.ZHiddenFieldColumn');
Yii::import('matwork.widgets.column.ZDataColumn');
Yii::import('matwork.widgets.column.ZButtonColumn');

class ZGrid extends ZList
{
	public $pattern;

	public $columns = array();
	
	public $enableSorting = true;

	public $rowCssClass = array('odd', 'even');

	public $rowCssClassExpression;

	public $nullDisplay = '&nbsp;';

	public $blankDisplay = '&nbsp;';

	public $hideHeader = false;
	
	public $hideFooter = false;
	
	public $options = array();
	
	public $extraParams = array();
	
	public function init()
	{
		parent::init();
		
		$this->summaryCssClass = $this->summaryCssClass !== null ? 'summary '.$this->summaryCssClass : 'summary';
		$this->itemsCssClass = $this->itemsCssClass !== null ? 'table '.$this->itemsCssClass : 'table';
		$this->pagerCssClass = $this->pagerCssClass !== null ? 'pagination '.$this->pagerCssClass : 'pagination';

		if (!isset($this->htmlOptions['class']))
		{
			$this->htmlOptions['class'] = 'grid';
		}

		$this->initColumns();
	}

	protected function initColumns()
	{
		if ($this->columns === array())
		{
			if ($this->dataProvider instanceof CActiveDataProvider)
			{
				$this->columns = $this->dataProvider->model->attributeNames();
			}
			else if ($this->dataProvider instanceof IDataProvider)
			{
				$data = $this->dataProvider->getData();
				
				if (isset($data[0]) && is_array($data[0]))
				{
					$this->columns=array_keys($data[0]);
				}
			}
		}
		
		$id = $this->getId();
		
		foreach ($this->columns as $i=>$column)
		{
			if (!isset($column['class']))
			{
				$column['class'] = 'ZDataColumn';
			}

			$column = Yii::createComponent($column, $this);
			
			if (!$column->visible)
			{
				unset($this->columns[$i]);
				continue;
			}
			
			if ($column->id === null)
			{
				$column->id = $id.'_c'.$i;
			}
			
			$column->number = $i;
			
			$this->columns[$i] = $column;
		}

		foreach ($this->columns as $column)
		{
			$column->init();
		}
	}

	public function registerClientScript()
	{
		$cs = Yii::app()->getClientScript();
		
		$baseUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('matwork.widgets.assets'));
		
		if ($this->cssFile === null)
		{
			$this->cssFile = $baseUrl.'/css/list.css';
		}
		
		$cs->registerCssFile($this->cssFile);
		$cs->registerScriptFile($baseUrl.'/js/grid.js');
		
		$cs->registerScript($this->id, '$("#'.$this->id.'").grid('.CJavaScript::encode($this->options).');');
	}

	public function renderItems()
	{
		if ($this->dataProvider->getItemCount() > 0 || $this->showTableOnEmpty || $this->pattern !== null)
		{
			echo '<table class="'.$this->itemsCssClass.'">';
			
			$this->renderTableHeader();
			
			ob_start();
			
			$this->renderTableBody();
			
			$body = ob_get_clean();
			
			$this->renderTableFooter();
			
			echo $body;
			
			echo '</table>';
		}
		else if ($this->emptyText !== false)
		{
			$this->renderEmptyText();
		}
	}

	public function renderTableHeader()
	{
		if (!$this->hideHeader)
		{
			echo '<thead>';

			echo '<tr>';
			
			foreach ($this->columns as $column)
			{
				$column->renderHeaderCell();
			}
			
			echo '</tr>';

			echo '</thead>';
		}
	}

	public function renderTablePattern()
	{
		echo CHtml::openTag('tr', array('data-type'=>'pattern', 'data-row'=>'ROW'));
		
		foreach($this->columns as $column)
		{
			$column->renderPatternCell($this->pattern);
		}
		
		echo '</tr>';
	}

	public function renderTableFooter()
	{
		$hasFooter = $this->getHasFooter();
		
		if ($hasFooter)
		{
			echo '<tfoot>';
			
			if ($hasFooter && !$this->hideFooter)
			{
				echo '<tr>';
				
				foreach ($this->columns as $column)
				{
					$column->renderFooterCell();
				}
				
				echo '</tr>';
			}
			
			echo '</tfoot>';
		}
	}

	public function renderTableBody()
	{
		$data = $this->dataProvider->getData();
		
		$n = count($data);
		
		echo '<tbody>';
		
		if ($this->pattern !== null)
		{
			$this->renderTablePattern();
		}

		if ($n > 0)
		{
			for ($row = 0; $row < $n; ++$row)
			{
				$this->renderTableRow($row);
			}
		}
		else
		{
			if ($this->emptyText !== null)
			{
				echo '<tr><td colspan="'.sizeof($this->columns).'" class="empty">';

				$this->renderEmptyText();

				echo '</td></tr>';
			}
		}
		
		echo '</tbody>';
	}

	public function renderTableRow($row)
	{
		$htmlOptions = array();

		if ($this->rowCssClassExpression !== null)
		{
			$class = $this->evaluateExpression($this->rowCssClassExpression,array('row'=>$row, 'data'=>$this->dataProvider->data[$row]));
		}
		else if (is_array($this->rowCssClass) && ($n = count($this->rowCssClass)) > 0)
		{
			$class = $this->rowCssClass[$row % $n];
		}

		if (!empty($class))
		{
			$htmlOptions['class'] = $class;
		}
		
		$htmlOptions['data-row'] = $row;

		echo CHtml::openTag('tr', $htmlOptions);
		
		foreach($this->columns as $column)
		{
			$column->renderDataCell($row);
		}
		
		echo '</tr>';
	}

	public function getHasFooter()
	{
		foreach ($this->columns as $column)
		{
			if ($column->getHasFooter())
			{
				return true;
			}
		}
		
		return false;
	}
}
