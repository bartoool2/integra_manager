<?php

class ZSecurity
{
	public static function hash($algorithm, $text)
	{
		return hash($algorithm, $text);
	}
	
	public static function random($length, $alphabet = 'a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,0,1,2,3,4,5,6,7,8,9')
	{
		$string = '';
		
		$alphabet = explode(',', $alphabet);
		
		for ($i = 0; $i < $length; $i++)
		{
			$string .= $alphabet[rand(0, sizeof($alphabet) - 1)];
		}
		
		return $string;
	}
	
	public static function randomNumber($length)
	{
		return self::random($length, '0,1,2,3,4,5,6,7,8,9');
	}
}
?>
