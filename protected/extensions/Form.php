<?php

class Form extends CActiveForm
{
	public function error($model,$attribute,$htmlOptions=array(), $enableAjaxValidation=true, $enableClientValidation=true)
	{
		$html = '<div class="alert alert-danger">';
		$html .= parent::error($model, $attribute, $htmlOptions, $enableAjaxValidation, $enableClientValidation);
		$html .= '</div>';
		return $html;
	}
}

