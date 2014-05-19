<?php

class ZRequestParamFilter extends CFilter
{
	public $name;
	
	public $minLength = null;
	
	public $maxLength = null;
	
	public $allowEmpty = true;
	
	protected function preFilter($filterChain)
	{
		if (!$this->allowEmpty)
		{
			if (!isset($_GET[$this->name]))
			{
				throw new CHttpException(400,Yii::t('yii','Your request is invalid.'));
			}
			else
			{
				if ($this->minLength !== null && strlen($_GET[$this->name]) < $this->minLength)
				{
					throw new CHttpException(400,Yii::t('yii','Your request is invalid.'));
				}
				
				if ($this->maxLength !== null && strlen($_GET[$this->name]) > $this->maxLength)
				{
					throw new CHttpException(400,Yii::t('yii','Your request is invalid.'));
				}
			}
		}
		
		return true;
	}

	protected function postFilter($filterChain)
	{
		
	}
}

?>
