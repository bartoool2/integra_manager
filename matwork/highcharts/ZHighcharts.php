<?php

class ZHighcharts extends CWidget
{
	public $options = array();

	public function run()
	{
		?>

		<div id="<?php echo $this->id; ?>">

		</div>
		
		<?php
		
		$this->registerClientScript();
	}

	public function registerClientScript()
	{
		$cs = Yii::app()->getClientScript();
		
		$baseUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('matwork.highcharts.assets')).'/js';
		
		$cs->registerScriptFile($baseUrl.'/highcharts.js');
		
		$cs->registerScript(__CLASS__.'#'.$this->id, '$("#'.$this->id.'").highcharts('.CJavaScript::encode($this->options).');');
	}
}
