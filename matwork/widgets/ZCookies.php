<?php

class ZCookies extends CWidget
{
	public $id;
	
	public $text;
	
	public $cookie = 'cookies-info';
	
	public $htmlOptions = array();
	
	public function run()
	{
		if (!isset($_COOKIE[$this->cookie]))
		{
			$this->htmlOptions['id'] = $this->id;

			$this->htmlOptions['class'] = isset($this->htmlOptions['class']) ? 'cookies '.$this->htmlOptions['class'] : 'cookies';

			if ($this->text === null)
			{
				$this->text = Yii::t('matwork', 'This site uses cookie files to deliver services. You can change the cookie settings in your browser.');
			}

			?>

			<div <?php echo CHtml::renderAttributes($this->htmlOptions); ?>>

			<a class="close" href="javascript: void(0);">&times;</a>

			<span><?php echo $this->text; ?></span>

			</div>

			<?php

			Yii::app()->clientScript->registerScript('close-cookie', '
				$("#'.$this->id.' a").on("click", function()
				{
					$.cookie("'.$this->cookie.'", true, {path: "/"});

					$("#'.$this->id.'").hide();
				});
			');
		}
	}
}

?>
