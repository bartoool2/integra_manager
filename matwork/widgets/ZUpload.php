<?php

class ZUpload extends CWidget
{
	public $id = 'files';
	
	public $form;
	
	public $model;
	
	public $attribute;
	
	public $options = array();
	
	public $htmlOptions = array();
	
	public function run()
	{
		$this->htmlOptions['id'] = $this->id;
		
		$this->options = CMap::mergeArray(array(
			'namePrefix'=>CHtml::resolveName($this->model, $this->attribute),
		), $this->options);
		
		$this->registerClientScript();
		
		?>

		<div <?php echo CHtml::renderAttributes($this->htmlOptions); ?>>

		</div>

		<?php
	}

	public function registerClientScript()
	{
		$baseUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('matwork.widgets.assets')).'/js';
		
		$cs = Yii::app()->getClientScript();
		
		$cs->registerScriptFile($baseUrl.'/upload.js');
		
		$cs->registerScript($this->id, '$("#'.$this->id.'").upload('.CJavaScript::encode($this->options).');');
	}
}

?>
