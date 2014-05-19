<?php

class ZFile extends CFileHelper
{
	public static function uploadFile($file, $path, $upload = true)
	{
		if ($file !== null && $upload)
		{
			if (is_object($file) && $file->saveAs($path))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		return true;
	}
	
	public static function deleteFile($path, $delete = true)
	{
		if ($delete)
		{
			return @unlink($path);
		}
	}
	
	public static function removeDirectory($dir)
	{
		if (is_dir($dir)) 
		{		
			$objects = scandir($dir);
			foreach ($objects as $object) 
			{
				if ($object != "." && $object != "..") 
				{
					if (filetype($dir."/".$object) == "dir")
					{
						self::removeDirectory($dir."/".$object); 
					}
					else 
					{
						unlink($dir."/".$object);
					}
				}
			}
			
			reset($objects);
			rmdir($dir);
		}
	}
	
	public static function mkdir($directory)
	{				
		$result = false;
		
		if(Yii::app()->params['developmentMode'])
		{
			$result = mkdir($directory);
		}
		else
		{
			$ftpConnection = ftp_connect(Yii::app()->params['ftpConnection']['address']); 
		
			$dir = strstr($directory, Yii::app()->params['ftpConnection']['homeDir']);

			if($ftpConnection)
			{
				if (ftp_login($ftpConnection, Yii::app()->params['ftpConnection']['username'], Yii::app()->params['ftpConnection']['password'])) 
				{ 
					if(self::make_directory($ftpConnection, $dir))
					{
						$result = true;
					}
				}
			}

			ftp_close($ftpConnection);
		}
		
		return $result;
	}
	
	private static function make_directory($ftp_stream, $dir)
	{
		if (self::ftp_is_dir($ftp_stream, $dir) || @ftp_mkdir($ftp_stream, $dir))
		{			
			ftp_site($ftp_stream, 'CHMOD 0777 '.$dir);
			return true;
		}

		if (!self::make_directory($ftp_stream, dirname($dir))) return false;

		$result = ftp_mkdir($ftp_stream, $dir);
		ftp_site($ftp_stream, 'CHMOD 0777 '.$dir);
		
		return $result;
	}

	private static function ftp_is_dir($ftp_stream, $dir)
	{
		$original_directory = ftp_pwd($ftp_stream);

		if ( @ftp_chdir( $ftp_stream, $dir ) ) 
		{

			ftp_chdir( $ftp_stream, $original_directory );
			return true;
		}
		else 
		{
			return false;
		}
	}
}
