<?php

Yii::import('matwork.widgets.ZForm');

class ZSearch extends ZForm
{
	public $method = 'get';
	
	public $searchLabel = null;
	
	public $clearLabel = null;
	
	public function init()
	{
		if ($this->searchLabel === null)
		{
			$this->searchLabel = Yii::t('matwork', 'Search');
		}
		
		if ($this->clearLabel === null)
		{
			$this->clearLabel = Yii::t('matwork', 'Clear');
		}
		
		parent::init();
		
		?>

		<fieldset>

		<?php
	}
	
	public function run()
	{
		?>
			
		<div class="row-fluid" style="text-align: center;">

			<a class="btn btn-primary btn-small" href="javascript: void(0);" onclick="javascript: $('#<?php echo $this->id; ?>').form('submit');"><?php echo $this->searchLabel; ?></a>
			<a class="btn btn-small" href="javascript: void(0);" onclick="javascript: $('#<?php echo $this->id; ?>').form('clear');"><?php echo $this->clearLabel; ?></a>

		</div>
			
		</fieldset>

		<?php
		
		parent::run();
	}
	
	public function dropDownList($model, $attribute, $data, $htmlOptions = array())
	{
		$htmlOptions['empty'] = '';
		
		return parent::dropDownList($model, $attribute, $data, $htmlOptions);
	}
}