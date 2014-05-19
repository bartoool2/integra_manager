<?php

class ZIpFilter extends CFilter
{
	public $ips;
	
	protected function preFilter($filterChain)
	{
		return in_array(Yii::app()->request->userHostAddress, $this->ips);
	}

	protected function postFilter($filterChain)
	{
		
	}
}

?>
