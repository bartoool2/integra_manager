<?php

class XlsManager
{
	const HEAD_ROW_NO = 1;
	
	const MODE_CONFIG = 0;
	const MODE_DATA = 1;
	
	public $dataXls;
	public $configXls;
	private $writerXls;
	private $writerWorksheet;
	private $config;	
	private $criterionOrder;
	
	private $mode;
	private $maxCols;
	
	public function __construct($file, $mode, $config = null) 
	{		
		if($config != null)
		{
			$this->config = $config;
			$this->criterionOrder = array();
		}
		
		$this->mode = $mode;
		$this->maxCols = null;
		
		$reader = PHPExcel_IOFactory::createReaderForFile($file);
		$reader->setReadDataOnly(true);
				
		switch($mode)
		{
			case self::MODE_CONFIG:
				$this->configXls = $reader->load($file);
				
				break;
			case self::MODE_DATA:	
				$this->dataXls = $reader->load($file);
				
				break;
		}
	}
	
	public function insertContent($country)
	{					
		$this->openWriter();
		
		$maxCol = $this->getColsNum();
		
		if($country->status == ClientCountry::STATUS_OUTPUT_AS_INPUT)
		{
			$this->maxCols = $maxCol - sizeof($country->client->config->criteria) - 1;
		}
		
		$firms = Firm::model()->getEvaluatedItemsByCountry($country->id);
		$colNums = Firm::getColNumbers($this, $country->id);
		
		$this->insertHeadRow($country);
		
		$iIndex = 2;
		
		foreach($firms as $firm)
		{			
			foreach($colNums as $colName=>$colIndex)
			{
				switch($colName)
				{
					case Firm::LP:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->lp);
						break;
					case Firm::FIRST_NAME:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->first_name);
						break;
					case Firm::LAST_NAME:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->last_name);
						break;
					case Firm::OFFICE:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->office);
						break;
					case Firm::COMPANY_NAME:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->company_name);
						break;
					case Firm::ADDRESS:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->address);
						break;
					case Firm::ADDRESS_ETC:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->address_etc);
						break;
					case Firm::TOWN:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->town);
						break;
					case Firm::ZIP_CODE:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->zip_code);
						break;
					case Firm::REGION:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->region);
						break;
					case Firm::COUNTRY:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->country_name);
						break;
					case Firm::PHONE_NO:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->phone_no);
						break;
					case Firm::FAX_NO;
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->fax_no);
						break;
					case Firm::EMAIL:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->email);
						break;
					case Firm::WEBSITE:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->website);
						break;
					case Firm::SALES:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->sales);
						break;
					case Firm::EMPLOYMENT:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->employment);
						break;
					case Firm::ESTABLISHMENT:
						$this->writerWorksheet->setCellValueByColumnAndRow($colIndex, $iIndex, $firm->establishment);
						break;
				}				
			}
			
			$inputFirmRow = 0;
			for($i = 1; $i <= $this->getRowsNum(); $i++)
			{
				if($this->getDataValue($colNums[Firm::LP], $i))
				{
					if($this->getDataValue($colNums[Firm::LP], $i) == $firm->lp)
					{
						$inputFirmRow = $i;
						break;
					}
				}
			}
			
			if($inputFirmRow > 0)
			{				
				foreach($country->otherCols as $otherCol)
				{	
					if($this->getDataValue($otherCol->col_no, $inputFirmRow))
					{						
						$this->writerWorksheet->setCellValueByColumnAndRow($otherCol->col_no, $iIndex, $this->getDataValue($otherCol->col_no, $inputFirmRow));
					}
				}
			}	
			
			$ranking = 0;
			
			foreach($firm->eval as $eval)
			{				
				$summaryNote = $eval->criterion->weight*$eval->note;
				
				$this->writerWorksheet->setCellValueByColumnAndRow($this->criterionOrder[$eval->criterion_id], $iIndex, $summaryNote);
				$ranking += $summaryNote;
			}
			
			$this->writerWorksheet->setCellValueByColumnAndRow($this->criterionOrder['rank'], $iIndex, $ranking);
			
			$iIndex++;
			
			unset($firm);
		}
		
		unset($firms);
		
		$this->closeWriter($country->fullPath.'output.xlsx');
	}
	
	public function insertHeadRow()
	{	     
		$col = 0;			
		
		for ($i = 0; $i <= $this->getColsNum(); $i++)
		{
			$this->writerWorksheet->setCellValueByColumnAndRow($col, 1, $this->getDataValue($i, self::HEAD_ROW_NO));
			$col++;
		}   
		
		$col--;
		foreach($this->config->criteria as $criterion)
		{
			$this->writerWorksheet->setCellValueByColumnAndRow($col, 1, $criterion->name);				
			$this->criterionOrder[$criterion->id] = $col;
			$col++;
		}
		
		$this->criterionOrder['rank'] = $col;
		$this->writerWorksheet->setCellValueByColumnAndRow($col, 1, 'RANKING');			
	}
	
	public function getOutputReader()
	{
		$reader = new Spreadsheet_Excel_Reader();
		$reader->setOutputEncoding(ColNames::ENCODING);
		
		switch($this->fileMode)
		{
			case AccessControl::FILE_MANAGEMENT_MODE_NOTE:
				$reader->read($_SESSION["currentPathName"].'/'.$_SESSION["outputFileName"]);
				break;
			case AccessControl::FILE_MANAGEMENT_MODE_PDF:
				$reader->read($_SESSION["currentPathName"].'/'.$_SESSION["inputDataFileName"]);
				break;
		}		
		
		return $reader;
	}
	
	private function openWriter()
	{
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
		$cacheSettings = array( 'memoryCacheSize' => '32MB');
		
//		$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_discISAM;
//		$cacheSettings = array( 'dir'  => Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'temp');
		
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		
		$this->writerXls = new PHPExcel();
		$this->writerWorksheet = new PHPExcel_Worksheet($this->writerXls, 'Arkusz 1');
		
		$this->writerXls->addSheet($this->writerWorksheet, 0);
		
		$sheetIndex = $this->writerXls->getIndex($this->writerXls->getSheetByName('Worksheet'));
		$this->writerXls->removeSheetByIndex($sheetIndex);
	}
	
	private function closeWriter($file)
	{
		$objWriter = PHPExcel_IOFactory::createWriter($this->writerXls, "Excel2007");
		$objWriter->setUseDiskCaching(true, Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'temp');
		$objWriter->save($file);
	}
	
	public function getRowNo($reader, $lp, $forWriting = true)
	{		
		for($i = 1; $i <= $reader->sheets[0]['numRows']; $i++)
		{
			if($lp == $reader->sheets[0]['cells'][$i][1])
			{				
				return $forWriting ? ($i - 1) : $i;
			}
		}
		
		return $reader->sheets[0]['numRows'];
	}
	
	public function getReader($lp)
	{
		$outReader = $this->getOutputReader();
		
		for($i = 1; $i <= $outReader->sheets[0]['numRows']; $i++)
		{
			if($lp == $outReader->sheets[0]['cells'][$i][1])
			{
				return $outReader;
			}
		}
		
		return $this->dataXls;
	}
	
	public function getCurrentSiteRowNo()
	{
		for($i = 1; $i <= $this->dataXls->sheets[0]['numRows']; $i++)
		{
			if($_SESSION['currentSite'] == $this->dataXls->sheets[0]['cells'][$i][1])
			{				
				return $i;
			}
		}
		
		return -1;
	}
	
	public function lpExists($lp)
	{
		for($i = 1; $i <= $this->dataXls->sheets[0]['numRows']; $i++)
		{
			if($lp == $this->dataXls->sheets[0]['cells'][$i][1])
			{
				return true;
			}
		}
		
		return false;
	}
	
	public function getDataValue($col, $row)
	{
		return $this->dataXls->getSheet(0)->getCellByColumnAndRow($col, $row)->getValue();
	}
	
	public function getConfigValue($sheet, $col, $row)
	{
		return $this->configXls->getSheet($sheet)->getCellByColumnAndRow($col, $row)->getValue();
	}	
	
	public function getRowsNum($sheet = 0)
	{
		switch($this->mode)
		{
			case self::MODE_CONFIG:
				return $this->configXls->getSheet($sheet)->getHighestRow();
				
				break;
			case self::MODE_DATA:	
				return $this->dataXls->getSheet($sheet)->getHighestRow();
				
				break;
		}
	}
	
	public function getColsNum($sheet = 0)
	{
		switch($this->mode)
		{
			case self::MODE_CONFIG:
				$col = $this->configXls->getSheet($sheet)->getHighestColumn();				
				return PHPExcel_Cell::columnIndexFromString($col);
				
				break;
			case self::MODE_DATA:	
				if($this->maxCols != null)
				{
					return $this->maxCols;
				}
				else
				{
					$col = $this->dataXls->getSheet($sheet)->getHighestColumn();
					return PHPExcel_Cell::columnIndexFromString($col);
				}				
				
				break;
		}
	}
}

?>
