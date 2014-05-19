<?php

Yii::import('matwork.widgets.ZList');

class ZListing extends ZList
{
	public $pattern;
	
	public $itemView;

	public $viewData = array();

	public $sortableAttributes;
	
	public $elementCssClass;
	
	public $elementCssClassExpression;
	
	public $options = array();

	public function init()
	{
		if ($this->itemView === null)
		{
			throw new CException('The property "itemView" cannot be empty.');
		}
		
		$this->summaryCssClass = $this->summaryCssClass !== null ? 'summary '.$this->summaryCssClass : 'summary';
		$this->pagerCssClass = $this->pagerCssClass !== null ? 'pagination '.$this->pagerCssClass : 'pagination';
		
		parent::init();

		if (!isset($this->htmlOptions['class']))
		{
			$this->htmlOptions['class'] = 'list row-fluid';
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
		$cs->registerScriptFile($baseUrl.'/js/listing.js');
		
		$cs->registerScript($this->id, '$("#'.$this->id.'").listing('.CJavaScript::encode($this->options).');');
	}

	public function renderItems()
	{
		echo CHtml::openTag('ul', array('class'=>$this->itemsCssClass));
		
		$data = $this->dataProvider->getData();
		
		$owner = $this->getOwner();
			
		$viewFile = $owner->getViewFile($this->itemView);
		
		if ($this->pattern !== null)
		{	
			
			$htmlOptions = array();
				
			if ($this->elementCssClassExpression !== null)
			{
				$htmlOptions['class'] = $this->evaluateExpression($this->elementCssClassExpression, array('data'=>$this->pattern, 'index'=>'INDEX'));
			}
			
			if ($this->elementCssClass !== null)
			{
				$htmlOptions['class'] = isset($htmlOptions['class']) ? $this->elementCssClass.' '.$htmlOptions['class'] : $this->elementCssClass;
			}

			$htmlOptions['data-type'] = 'pattern';
			$htmlOptions['data-index'] = 'INDEX';
			$htmlOptions['style'] = isset($htmlOptions['style']) ? $htmlOptions['style'].' display: none;' : 'display: none;';
				
			echo CHtml::openTag('li', $htmlOptions);
			
			echo str_replace(array('<', '>'), array('BEGIN', 'END'), $owner->renderFile($viewFile, array('index'=>'INDEX', 'data'=>$this->pattern, 'widget'=>$this), true));
			
			echo CHtml::closeTag('li');
		}
		
		if (($n = count($data)) > 0)
		{
			$j = 0;

			foreach ($data as $i=>$item)
			{
				$data = $this->viewData;
				
				$data['index'] = $i;
				$data['data'] = $item;
				$data['widget'] = $this;
				
				$htmlOptions = array();
				
				if ($this->elementCssClassExpression !== null)
				{
					$htmlOptions['class'] = $this->evaluateExpression($this->elementCssClassExpression, array('data'=>$data['data'], 'index'=>$data['index']));
				}
				
				if ($this->elementCssClass !== null)
				{
					$htmlOptions['class'] = isset($htmlOptions['class']) ? $this->elementCssClass.' '.$htmlOptions['class'] : $this->elementCssClass;
				}
				
				$htmlOptions['data-index'] = $i;
				
				echo CHtml::openTag('li', $htmlOptions);
				
				$owner->renderFile($viewFile, $data);
				
				echo CHtml::closeTag('li');
			}
		}
		else
		{
			$this->renderEmptyText();
		}
		
		echo CHtml::closeTag('ul');
	}
}
