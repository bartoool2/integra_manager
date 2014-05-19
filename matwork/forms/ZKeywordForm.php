<?php

class ZKeywordForm extends CFormModel
{
	public $keyword;

	public function rules()
	{
		return array(
			array('keyword', 'safe'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'keyword'=>Yii::t('matwork', 'Keyword'),
		);
	}
}
