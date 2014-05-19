<?php

class ZGraphics
{
	const TYPE_JPG = 'jpg';
	const TYPE_PNG = 'png';
	const TYPE_GIF = 'gif';
	const TYPE_STRING = 'string';
	
	const RESIZE_CROP_TO_FIT = 0;
	const RESIZE_LETTERBOX = 1;
	
	public static function create($source, $type = self::TYPE_JPG)
	{
		$image = null;
		
		switch ($type)
		{
			case self::TYPE_JPG:
				$image = imagecreatefromjpeg($source);
				break;
			case self::TYPE_PNG:
				$image = imagecreatefrompng($source);
				break;
			case self::TYPE_GIF:
				$image = imagecreatefromgif($source);
				break;
			case self::TYPE_STRING:
				$image = imagecreatefromstring($source);
				break;
		}
		
		return $image;
	}
	
	public static function resize($image, $destinationWidth, $destinationHeight, $resize = self::RESIZE_CROP_TO_FIT)
	{
		$imageWidth = imagesx($image); 
		$imageHeight = imagesy($image);
		
		$imageRatio = $imageWidth/$imageHeight; 
		$destinationRatio = $destinationWidth/$destinationHeight; 
		
		$destinationX = 0;
		$destinationY = 0;
		
		$imageX = 0;
		$imageY = 0;
		
		$newWidth = 0;
		$newHeight = 0;
		
		switch ($resize)
		{
			case self::RESIZE_CROP_TO_FIT:
				if ($imageRatio > $destinationRatio)
				{
					$tempWidth = (int) ($imageHeight*$destinationRatio);
					$tempHeight = $imageHeight;
					
					$imageX = (int) (($imageWidth - $tempWidth)/2);
					$imageY = 0;
				}
				else
				{
					$tempWidth = $imageWidth;
					$tempHeight = (int) ($imageWidth/$destinationRatio);
					
					$imageX = 0;
					$imageY = (int) (($imageHeight - $tempHeight)/2);
				}

				$destinationX = 0;
				$destinationY = 0;
				
				$imageWidth = $tempWidth;
				$imageHeight = $tempHeight;
				
				$newWidth = $destinationWidth;
				$newHeight = $destinationHeight;
				break;
			case self::RESIZE_LETTERBOX:
				if ($imageRatio < $destinationRatio)
				{ 
					$tempWidth = (int) ($destinationHeight*$imageRatio); 
					$tempHeight = $destinationHeight;

					$destinationX = (int) (($destinationWidth - $tempWidth)/2); 
					$destinationY = 0; 
				}
				else
				{
					$tempWidth = $destinationWidth; 
					$tempHeight = (int) ($destinationWidth/$imageRatio); 

					$destinationX = 0; 
					$destinationY = (int) (($destinationHeight - $tempHeight)/2); 
				} 

				$imageX = 0;
				$imageY = 0;
				
				$newWidth = $tempWidth;
				$newHeight = $tempHeight;
				break;
		} 
		
		$destination = imagecreatetruecolor($destinationWidth, $destinationHeight); 
		
		if ($resize == self::RESIZE_LETTERBOX)
		{ 
			imagefill($destination, 0, 0, imagecolorallocate($destination, 255, 255, 255)); 
		} 
		
		imagecopyresampled($destination, $image, $destinationX, $destinationY, $imageX, $imageY, $newWidth, $newHeight, $imageWidth, $imageHeight); 
		
		return $destination; 
	}
	
	public function save($image, $path, $type = self::TYPE_JPG, $quality = 75)
	{
		switch ($type)
		{
			case self::TYPE_JPG:
				return imagejpeg($image, $path, $quality);
				break;
			case self::TYPE_PNG:
				return imagepng($image, $path, $quality);
				break;
			case self::TYPE_GIF:
				return imagegif($image, $path, $quality);
				break;
		}
	}
}
