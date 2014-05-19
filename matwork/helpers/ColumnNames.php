<?php

class ColNames
{
        public static $FIRST_NAME = 'Imie';
        public static $LAST_NAME = 'Nazwisko';
        public static $OFFICE = 'Stanowisko';
        public static $COMPANY_NAME = 'Nazwa_firmy';
        public static $ADDRESS = 'Adres';
        public static $ADDRESS_ETC = 'Adres_cd';
        public static $TOWN = 'Miejscowosc';
        public static $ZIP_CODE = 'Kod_pocztowy';
        public static $REGION = 'Region/wojewodztwo';
        public static $COUNTRY = 'Kraj';
        public static $PHONE_NO = 'Nr_telefonu';
        public static $FAX_NO = 'Nr_faksu';
        public static $EMAIL = 'Email';
        public static $WEBSITE = 'www';        
        public static $SALES = 'Obroty';
        public static $EMPLOYMENT = 'Zatrudnienie_w_firmie';
        public static $ESTABLISHMENT = 'Rok_zalozenia';        
        
        public static $CRITERIA_SALES = 'obroty';
        public static $CRITERIA_EMPLOYMENT = 'liczba zatrudnionych';
        public static $CRITERIA_ESTABLISHMENT = 'rok zalozenia';        
        
        private $COL_NAMES = array();
        public $COL_VALS = array();
        private $CRITERIA_VALS = array();
        
        private $SALES_INTERVAL = array();
        private $ESTABLISHMENT_INTERVAL = array();
        
        public function __construct($configId, $file) 
        {
		$xlsMan = new XlsManager();
		
//                $this->COL_NAMES = array(
//                        ColNames::$FIRST_NAME,
//                        ColNames::$LAST_NAME,
//                        ColNames::$OFFICE,
//                        ColNames::$COMPANY_NAME,
//                        ColNames::$ADDRESS,
//                        ColNames::$ADDRESS_ETC,
//                        ColNames::$TOWN,
//                        ColNames::$ZIP_CODE,
//                        ColNames::$REGION,
//                        ColNames::$COUNTRY,
//                        ColNames::$PHONE_NO,
//                        ColNames::$FAX_NO,
//                        ColNames::$EMAIL,
//                        ColNames::$WEBSITE,
//                        ColNames::$SALES,
//                        ColNames::$EMPLOYMENT,
//                        ColNames::$ESTABLISHMENT
//                );
//                
//                foreach($this->COL_NAMES as $key)
//                {
//                        for($i = 1; $i <= $xlsMan->dataXls->sheets[0]['numCols']; $i++)
//                        {
//                                if(strcmp(strtolower($key), strtolower($xlsMan->getDataValue(XlsManager::HEAD_ROW_NO, $i))) == 0)
//                                {
//                                        $this->COL_VALS[$key] = $i;
//                                        break;
//                                }
//                        }                        
//                } 
                
                for($i = 2; $i < $xlsMan->configXls->sheets[1]['numCols']; $i++)
                {
                        $this->CRITERIA_VALS[trim(strtolower($xlsMan->configXls->sheets[1]['cells'][2][$i]))] = $i;
                }
                
                if($this->existsCriterion(ColNames::$CRITERIA_EMPLOYMENT))
                {       
                        for($i = 5; $i <= $xlsMan->configXls->sheets[1]['numRows']; $i++)
                        {
                                preg_match_all('!\d+!', $xlsMan->configXls->sheets[1]['cells'][$i][$this->CRITERIA_VALS[ColNames::$CRITERIA_EMPLOYMENT]], $matches);
                                
                                if($i > 5)
                                {
                                        if(count($matches[0]) == 0)
                                        {
                                                break;                                             
                                        }
                                        else
                                        {
                                                $this->SALES_INTERVAL[$i-5] = (int) $matches[0][count($matches[0])-1];
                                        }
                                }
                                else
                                {
                                        $this->SALES_INTERVAL[$i-5] = 0;
                                }                                
                        }
                }
                
                if($this->existsCriterion(ColNames::$CRITERIA_ESTABLISHMENT))
                {       
                        for($i = 5; $i <= $xlsMan->configXls->sheets[1]['numRows']; $i++)
                        {
                                $tempRow = explode('-', $xlsMan->configXls->sheets[1]['cells'][$i][$this->CRITERIA_VALS[ColNames::$CRITERIA_ESTABLISHMENT]]);
                                
                                preg_match('!\d+!', $tempRow[0], $match);
                                
                                if($i > 5)
                                {
                                        if((int) $match[0] == 0)
                                        {
                                                break;                                             
                                        }                                                                                
                                }
                                
                                $this->ESTABLISHMENT_INTERVAL[$i-5] = (int) $match[0];
                        }
                }
        }
        
        public function getColNum($fieldName)
        {                
                return $this->COL_VALS[$fieldName];
        }
        
        public function existsCriterion($name)
        {
                return array_key_exists($name, $this->CRITERIA_VALS);
        }
        
        public function getCriteriaColNum($name)
        {
                return $this->CRITERIA_VALS[$name];
        }
        
        public function evalCriterion($criterionName)
        {        
		$xlsMan = new XlsManager;		
		$criterionName = strtolower($criterionName);
		
		if($xlsMan->getReader($_SESSION['currentSite']) != $xlsMan->dataXls)
		{
			$xls = $xlsMan->configXls;
			$criteriaNum = $xls->sheets[0]['cells'][6][2];
			$outputReader = $xlsMan->getOutputReader();
			$row = $xlsMan->getRowNo($xlsMan->getOutputReader(), $_SESSION['currentSite'], false);
			$criteriaCol = $this->CRITERIA_VALS[$criterionName];
			$col = $outputReader->sheets[0]['numCols'] - $criteriaNum - 2 + $criteriaCol;

			return $outputReader->sheets[0]['cells'][$row][$col] / $xls->sheets[1]['cells'][3][$criteriaCol];
		}		                
                
		if(isset($_SESSION['inputIsOutput']))
		{
			$xls = $xlsMan->configXls;
			$criteriaNum = $xls->sheets[0]['cells'][6][2];
			$criteriaCol = $this->CRITERIA_VALS[$criterionName];
			$row = $xlsMan->getRowNo($xlsMan->dataXls, $_SESSION['currentSite'], false);
			$col = $xlsMan->dataXls->sheets[0]['numCols'] - $criteriaNum - 2 + $criteriaCol;
			
			return $xlsMan->dataXls->sheets[0]['cells'][$row][$col] / $xls->sheets[1]['cells'][3][$criteriaCol];
		}
                else if(array_key_exists($criterionName, $this->CRITERIA_VALS))
                {                        
                        $criterionDataCol = null;
                        $criteriaInterval = null;
                        
                        if(strcmp($criterionName, ColNames::$CRITERIA_EMPLOYMENT) == 0)
                        {
                                $criterionDataCol = $this->COL_VALS[ColNames::$EMPLOYMENT];
                                $criteriaInterval = $this->SALES_INTERVAL;
                        }
                        else if(strcmp($criterionName, ColNames::$CRITERIA_ESTABLISHMENT) == 0)
                        {
                                $criterionDataCol = $this->COL_VALS[ColNames::$ESTABLISHMENT];
                                $criteriaInterval = $this->ESTABLISHMENT_INTERVAL;
                        }
                        
                        if($criterionDataCol == null || $criteriaInterval == null)
                        {                                
                                return 0;
                        }  
                        
                        if(strcmp($criterionName, ColNames::$CRITERIA_EMPLOYMENT) == 0)
                        {
                                for($i = 0; $i < count($criteriaInterval); $i++)
                                {
                                        if($xlsMan->getDataValue($xlsMan->getCurrentSiteRowNo(), $criterionDataCol) <= $criteriaInterval[$i])
                                        {
                                                return $i;
                                        }
                                }
                                
                                return count($criteriaInterval)-1;
                        }
                        else if(strcmp($criterionName, ColNames::$CRITERIA_ESTABLISHMENT) == 0)
                        {
                                if($xlsMan->getDataValue($xlsMan->getCurrentSiteRowNo(), $criterionDataCol) == null
                                        || intval($xlsMan->getDataValue($xlsMan->getCurrentSiteRowNo(), $criterionDataCol)) == 0)
                                {
                                        return 0;
                                }
                                
                                for($i = 1; $i < count($criteriaInterval); $i++)
                                {
                                        if($xlsMan->getDataValue($xlsMan->getCurrentSiteRowNo(), $criterionDataCol) >= $criteriaInterval[$i])
                                        {
                                                return $i;
                                        }
                                }
                                
                                return count($criteriaInterval)-1;
                        }                                                                        
                }
                else
                {
                        return 0;
                }
        }
}

?>
