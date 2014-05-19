<?php
class ZipDownload
{	
	public static function downloadZip($filesPath, $zipName)
	{
		$src = $filesPath;
		$filename = $zipName.'.zip';		

		$zip = new ZipStream($filename);

		if(is_file($src))
		{
//			$zip->addFile($src);	
			$data = file_get_contents($src);
			$zip->add_file($src, $data);
		}

		else
		{
			if(is_dir($src))
			{
			     self::recurse_zip($src, $zip);
			}		
		}
		
		$zip->finish();		
	}
	
	private static function recurse_zip($src, $zip) 
	{
		$dir = opendir($src);		

		while(false !== ( $file = readdir($dir)) ) 
		{
			if (( $file != '.' ) && ( $file != '..' )) 
			{
				if ( is_dir($src . '/' . $file) ) 
				{
				    recurse_zip($src . '/' . $file, $zip);
				}
				else 
				{
					$data = file_get_contents($src . '/' . $file);
					$zip->add_file($file, $data);
//				    $zip->addFile($src . '/' . $file, $file);
				}
			}
		}
		closedir($dir);
	}
}
?>
