<?php

class ZPayu extends CApplicationComponent
{
	const BASE_URL = 'https://www.platnosci.pl/paygw';
	
	const CODING_UTF = 'UTF';
	const CODING_ISO = 'ISO';
	const CODING_WIN = 'WIN';
	
	const PROCEDURE_CREATE = 'NewPayment';
	const PROCEDURE_STATUS = 'Payment/get';
	const PROCEDURE_CONFIRM = 'Payment/confirm';
	const PROCEDURE_CANCEL = 'Payment/cancel';
	
	const FORMAT_XML = 'XML';
	const FORMAT_TXT = 'TXT';
	
	const STATUS_NEW = 1;
	const STATUS_CANCELED = 2;
	const STATUS_REJECTED = 3;
	const STATUS_BEGUN = 4;
	const STATUS_WAITING_FOR_RECEIVING = 5;
	const STATUS_REJECTED_AFTER_PAYING = 7;
	const STATUS_FINISHED = 99;
	const STATUS_ERROR = 888;
	
	public $id;
	
	public $key1;
	
	public $key2;
	
	public $pos_id;
	
	public $pos_auth_key;
	
	public $pay_type;
	
	public $pay_gw_name;
	
	public $session_id;
	
	public $amount;
	
	public $desc;
	
	public $desc2;
	
	public $trsDesc;
	
	public $order_id;

	public $first_name;
	
	public $last_name;
	
	public $street;
	
	public $street_hn;
	
	public $street_an;
	
	public $city;
	
	public $post_code;
	
	public $country;
	
	public $phone;
	
	public $language;
	
	public $email;
	
	public $client_ip;
	
	public $ts;
	
	public $sig;
	
	public $create;
	
	public $init;
	
	public $sent;
	
	public $recv;
	
	public $cancel;
	
	public $auth_fraud;
	
	public $status;
	
	public function query($procedure, $coding = self::CODING_UTF, $format = self::FORMAT_XML)
	{
		$request = curl_init();
		
		curl_setopt($request, CURLOPT_URL, self::BASE_URL.'/'.$coding.'/'.$procedure.'/'.$format);
		curl_setopt($request, CURLOPT_POST, 1);
		curl_setopt($request, CURLOPT_POSTFIELDS, 'pos_id='.$this->pos_id.'&session_id='.$this->session_id.'&ts='.$this->ts.'&sig='.$this->sendingSig);
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
		
		$xml = new XMLReader();
		
		$xml->xml(curl_exec($request));
		
		if ($xml->read() && $xml->nodeType == XMLReader::ELEMENT && $xml->name == 'response')
		{
			$response = $xml->expand()->childNodes;
			
			for ($i = 0; $i < $response->length; $i++)
			{
				$node = $response->item($i);

				switch ($node->nodeName)
				{
					case 'status':
						if ($node->nodeValue != 'OK')
						{
							return false;
						}
						break;
					case 'trans':
						$trans = $node->childNodes;

						for ($i = 0; $i < $trans->length; $i++)
						{
							$option = $trans->item($i);
							
							switch ($option->nodeName)
							{
								case 'id':
									$this->id = $option->nodeValue;
									break;
								case 'pos_id':
									$this->pos_id = $option->nodeValue;
									break;
								case 'session_id':
									$this->session_id = $option->nodeValue;
									break;
								case 'order_id':
									$this->order_id = $option->nodeValue;
									break;
								case 'amount':
									$this->amount = $option->nodeValue;
									break;
								case 'status':
									$this->status = $option->nodeValue;
									break;
								case 'pay_type':
									$this->pay_type = $option->nodeValue;
									break;
								case 'pay_gw_name':
									$this->pay_gw_name = $option->nodeValue;
									break;
								case 'desc':
									$this->desc = $option->nodeValue;
									break;
								case 'pay_type':
									$this->pay_type = $option->nodeValue;
									break;
								case 'create':
									$this->create = $option->nodeValue;
									break;
								case 'init':
									$this->init = $option->nodeValue;
									break;
								case 'sent':
									$this->sent = $option->nodeValue;
									break;
								case 'recv':
									$this->recv = $option->nodeValue;
									break;
								case 'cancel':
									$this->cancel = $option->nodeValue;
									break;
								case 'auth_fraud':
									$this->auth_fraud = $option->nodeValue;
									break;
								case 'ts':
									$this->ts = $option->nodeValue;
									break;
								case 'sig':
									$this->sig = $option->nodeValue;
									break;
							}
						}
						break;
				}
			}
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function cancel($coding = self::CODING_UTF, $format = self::FORMAT_XML)
	{
		return $this->query(self::PROCEDURE_CANCEL, $coding, $format);
	}
	
	public function confirm($coding = self::CODING_UTF, $format = self::FORMAT_XML)
	{
		return $this->query(self::PROCEDURE_CONFIRM, $coding, $format);
	}
	
	public function status($coding = self::CODING_UTF, $format = self::FORMAT_XML)
	{
		return $this->query(self::PROCEDURE_STATUS, $coding, $format);
	}
	
	public function getReceivingSig()
	{
		return md5($this->pos_id.$this->session_id.$this->ts.$this->key2);
	}
	
	public function getSendingSig()
	{
		return md5($this->pos_id.$this->session_id.$this->ts.$this->key2);
	}
	
	public function getCreateSig()
	{
		return md5(
			$this->pos_id.$this->pay_type.$this->session_id.$this->pos_auth_key.$this->amount.$this->desc.$this->desc2.$this->trsDesc.$this->order_id.$this->first_name.$this->last_name.
			$this->street.$this->street_hn.$this->street_an.$this->city.$this->post_code.$this->country.$this->email.$this->phone.$this->language.$this->client_ip.$this->ts.$this->key1
		);
	}
}

?>
