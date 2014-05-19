<?php

Yii::import('matwork.widgets.ZDetail');

class ZForm extends ZDetail
{
	public $id;
	
	public $action = '';

	public $method = 'post';

	public $stateful = false;
	
	public $errorSummaryLabel = null;
	
	public $options;

	public function init()
	{
		$this->htmlOptions['id'] = $this->id;
		
		$this->htmlOptions['class'] = isset($this->htmlOptions['class']) ? 'form '.$this->htmlOptions['class'] : 'form';
		
		if ($this->errorSummaryLabel === null)
		{
			$this->errorSummaryLabel = Yii::t('matwork', 'Oppss! Correct errors in form!');
		}
		
		if ($this->stateful)
		{
			echo CHtml::statefulForm($this->action, $this->method, $this->htmlOptions);
		}
		else
		{
			echo CHtml::beginForm($this->action, $this->method, $this->htmlOptions);
		}
		
		$cs = Yii::app()->getClientScript();
		
		$baseUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('matwork.widgets.assets')).'/js';
		
		$cs->registerScriptFile($baseUrl.'/form.js');
		
		$cs->registerScript($this->id, '$("#'.$this->id.'").form('.CJavaScript::encode($this->options).');');
	}
	
	public function run()
	{
		echo CHtml::endForm();
	}
	
	public function activeLabel($model, $attribute, $htmlOptions = array())
	{
		if (!isset($htmlOptions['class']))
		{
			$htmlOptions['class'] = $this->labelCssClass;
		}
		
		return CHtml::activeLabelEx($model, $attribute, $htmlOptions);
	}

	public function textField($model, $attribute, $htmlOptions = array())
	{
		if (!isset($htmlOptions['class']))
		{
			$htmlOptions['class'] = $this->fieldCssClass;
		}
		
		return CHtml::activeTextField($model, $attribute, $htmlOptions);
	}

	public function hiddenField($model, $attribute, $htmlOptions = array())
	{
		return CHtml::activeHiddenField($model, $attribute, $htmlOptions);
	}

	public function passwordField($model, $attribute, $htmlOptions=array())
	{
		if (!isset($htmlOptions['class']))
		{
			$htmlOptions['class'] = $this->fieldCssClass;
		}
		
		return CHtml::activePasswordField($model, $attribute, $htmlOptions);
	}

	public function textArea($model, $attribute, $htmlOptions = array())
	{
		if (!isset($htmlOptions['class']))
		{
			$htmlOptions['class'] = $this->fieldCssClass;
		}
		
		return CHtml::activeTextArea($model, $attribute, $htmlOptions);
	}

	public function fileField($model, $attribute, $htmlOptions = array())
	{
		return CHtml::activeFileField($model, $attribute, $htmlOptions);
	}

	public function radioButton($model, $attribute, $htmlOptions = array())
	{
		return CHtml::activeRadioButton($model, $attribute, $htmlOptions);
	}

	public function checkBox($model, $attribute, $htmlOptions = array())
	{
		return CHtml::activeCheckBox($model, $attribute, $htmlOptions);
	}

	public function dropDownList($model, $attribute, $data, $htmlOptions = array())
	{
		if (!isset($htmlOptions['class']))
		{
			$htmlOptions['class'] = $this->fieldCssClass;
		}
		
		return CHtml::activeDropDownList($model, $attribute, $data, $htmlOptions);
	}

	public function listBox($model, $attribute, $data, $htmlOptions = array())
	{
		if (!isset($htmlOptions['class']))
		{
			$htmlOptions['class'] = $this->fieldCssClass;
		}
		
		return CHtml::activeListBox($model, $attribute, $data, $htmlOptions);
	}

	public function checkBoxList($model, $attribute, $data, $htmlOptions = array())
	{
		return CHtml::activeCheckBoxList($model, $attribute, $data, $htmlOptions);
	}

	public function radioButtonList($model, $attribute, $data, $htmlOptions = array())
	{
		return CHtml::activeRadioButtonList($model, $attribute, $data, $htmlOptions);
	}

	public function errorSummary($id, $models)
	{
		$html = null;
		
		$contents = null;
		
		if (true)
		{
			$errors = ZHtml::validate($models, null);

			foreach ($errors as $error)
			{
				$contents .= '<li>'.$error['text'].'</li>';
			}
		}
		
		if ($contents !== null)
		{
			$html = '<div id="'.$id.'" class="alert alert-error alert-block">';

			$html .= '<a class="close" href="javascript: void(0);" onclick="javascript: $(\'#'.$id.'\').hide();">&times;</a><strong>'.$this->errorSummaryLabel.'</strong><ul>';

			$html .= $contents;
			
			$html .= '</ul></div>';
		}

		return $html;
	}
}