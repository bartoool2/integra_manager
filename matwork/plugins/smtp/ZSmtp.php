<?php

include 'Mail.php';
include 'Mail/mime.php';

class ZSmtp extends CApplicationComponent
{
	public $host;
	
	public $port = 25;
	
	public $auth = 'PLAIN';
	
	public $username;
	
	public $password;
	
	public $senderMail;
	
	public $senderName;
	
	public function send($recipientMail, $recipientName, $subject, $body, $attachments = array(), $replyTo = null, $send = true)
	{
		if ($send)
		{
			$text = strip_tags($body);
			$html = $body;
			$crlf = PHP_EOL;

			$headers = array(
				'From'=>'"'.$this->senderName.'" <'.$this->senderMail.'>',
				'Return-Path'=>$this->senderMail,
				'Subject'=>$subject,
				'To'=>'"'.$recipientName.'" <'.$recipientMail.'>',
				'X-Mailer'=>__CLASS__,
			);
			
			if ($replyTo !== null)
			{
				$headers['Reply-To'] = '"'.$replyTo.'"';
			}

			$mime = new Mail_mime($crlf);

			$mime->setTXTBody($text);
			$mime->setHTMLBody($html);

			foreach ($attachments as $attachment)
			{
				$mime->addAttachment($attachment['file'], $attachment['cType'], $attachment['name'], $attachment['isFile']);
			}

			$mimeparams = array(
				'text_encoding'=>'7bit',
				'text_charset'=>'UTF-8',
				'html_charset'=>'UTF-8',
				'head_charset'=>'UTF-8',
			);

			$mail = Mail::factory('smtp', array(
				'host'=>$this->host,
				'port'=>$this->port,
				'auth'=>$this->auth,
				'username'=>$this->username,
				'password'=>$this->password,
			));

			$result = $mail->send($recipientMail, $mime->headers($headers), $mime->get($mimeparams));

			return $result;
		}
		
		return true;
	}
}

?>
