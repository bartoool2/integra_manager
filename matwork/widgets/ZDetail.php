<?php

class ZDetail extends CWidget
{
	public $emptyValue;
	
	public $labelCssClass;
	
	public $fieldCssClass;
	
	public $htmlOptions = array();
	
	public function init()
	{
		$this->htmlOptions['id'] = $this->id;
		
		$this->htmlOptions['class'] = isset($this->htmlOptions['class']) ? 'form '.$this->htmlOptions['class'] : 'form';
		
		?>

		<div <?php echo CHtml::renderAttributes($this->htmlOptions); ?>>

		<?php
	}
	
	public function run()
	{
		?>

		</div>

		<?php
	}
	
	public function staticText($text, $htmlOptions = array())
	{
		return CHtml::openTag('span', $htmlOptions).($text !== null ? $text : $this->emptyValue).CHtml::closeTag('span');
	}
	
	public function activeText($model, $attribute, $htmlOptions = array())
	{
		$value = $model->{$attribute};
		
		return $value !== null ? CHtml::tag('span', $htmlOptions, $value) : $this->emptyValue;
	}
	
	public function staticLabel($label, $htmlOptions = array())
	{
		if (!isset($htmlOptions['class']))
		{
			$htmlOptions['class'] = $this->labelCssClass;
		}
		
		return CHtml::tag('span', $htmlOptions, $label);
	}
	
	public function activeLabel($model, $attribute, $htmlOptions = array())
	{
		if (!isset($htmlOptions['class']))
		{
			$htmlOptions['class'] = $this->labelCssClass;
		}
		
		return CHtml::tag('span', $htmlOptions, $model->getAttributeLabel($attribute));
	}
}