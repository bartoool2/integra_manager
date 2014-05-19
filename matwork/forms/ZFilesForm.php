<?php

class ZFilesForm extends CFormModel
{
	public $files = array();
	
	public $uploaded;
	
	public $rejected;
	
	public $count;
	
	public $minCount;
	
	public $maxCount;
	
	public $minSize;
	
	public $maxSize;
	
	public $types;
	
	public $control;
	
	public function validate($attributes = null, $clearErrors = true)
	{
		if ($this->maxCount > 1)
		{
			$this->files = CUploadedFile::getInstances($this, 'files');
		}
		else
		{
			$file = CUploadedFile::getInstance($this, 'files');
			
			if ($file !== null)
			{
				$this->files = array($file);
			}
		}
		
		if ($this->count !== null && sizeof($this->files) != $this->count)
		{
			$this->addError('files', Yii::t('matwork', 'You have to choose {n} files.', $this->count));
			
			return false;
		}
		
		if ($this->minCount !== null && sizeof($this->files) < $this->minCount)
		{
			$this->addError('files', Yii::t('matwork', 'You have to choose at least {n} files.', $this->minCount));
			
			return false;
		}
		
		if ($this->maxCount !== null && sizeof($this->files) > $this->maxCount)
		{
			$this->addError('files', Yii::t('matwork', 'You can choose up to {n} files.', $this->maxCount));
			
			return false;
		}
		
		if ($this->maxCount > 1)
		{
			foreach ($this->files as $file)
			{
				if (!$this->check($file))
				{
					$this->rejected++;
				}
			}
		}
		else
		{
			if (!$this->check($this->files[0]))
			{
				$this->rejected++;
				
				return false;
			}
		}
		
		return true;
	}
	
	public function check($file)
	{
		$error = $file->getError();
			
		if ($error == UPLOAD_ERR_INI_SIZE || $error == UPLOAD_ERR_FORM_SIZE || $this->maxSize !== null && $file->getSize() > $this->maxSize)
		{
			$this->addError('files', Yii::t('matwork', 'The file "{file}" is too large. Its size cannot exceed {limit}.', array('{file}'=>$file->getName(), '{limit}'=>Yii::app()->format->formatSize($this->maxSize))));
		
			return false;
		}
		else
		{
			switch ($error)
			{
				case UPLOAD_ERR_PARTIAL;
					throw new CException('The file was only partially uploaded.');
					break;
				case UPLOAD_ERR_NO_TMP_DIR;
					throw new CException('Missing the temporary folder to store the uploaded file.');
					break;
				case UPLOAD_ERR_CANT_WRITE;
					throw new CException('Failed to write the uploaded file to disk.');
					break;
			}
		}

		if ($this->minSize !== null && $file->getSize() < $this->minSize)
		{
			$this->addError('files', Yii::t('matwork', 'The file "{file}" is too small. Its size cannot be smaller than {limit}.', array('{file}'=>$file->getName(), '{limit}'=>Yii::app()->format->formatSize($this->minSize))));
		
			return false;
		}

		if ($this->types !== null)
		{
			if(is_string($this->types))
			{
				$types = explode('.', strtolower($this->types));
			}
			else
			{
				$types = $this->types;
			}
			
			if (!in_array(strtolower($file->getExtensionName()), $types))
			{
				$this->addError('files', Yii::t('matwork', 'The file "{file}" has wrong extension. Only files with these extensions are allowed: {extensions}.', array('{file}'=>$file->getName(), '{extensions}'=>implode(', ',$types))));
			
				return false;
			}
		}
		
		return true;
	}
}
