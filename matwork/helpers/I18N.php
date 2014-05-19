<?php

class I18N
{
	private $lang;
	
	const LANG_PL = 0;
	const LANG_EN = 1;
	
	private static $pl = array(
		'no'=>'Lp.',
		'note'=>'Ocena',
		'meaning'=>'Znaczenie',
		'ptsGained'=>'PRZYZNANE PUNKTY',
		'criterionWeight'=>'Waga kryterium:',
		'reliabilityPts'=>'Liczba punktów za wiarygodność:',
		'criterionOverall'=>'Łącznie za to kryterium:',
		'grounds'=>'UZASADNIENIE',
		'ptsSummary'=>'PODSUMOWANIE PUNKTACJI',
		'ptsSummary2'=>'ŁĄCZNA LICZBA PUNKTÓW',
		'reliabilityOverall'=>'Łączna liczba punktów zdobytych za wiarygodność: ',
		'basicInfo'=>'INFORMACJE PODSTAWOWE',
		'companyName'=>'Nazwa firmy:',
		'address'=>'Adres:',
		'addressCont'=>'Adres c.d.:',
		'addressCity'=>'Adres (miejscowość):',
		'addressZipCode'=>'Adres (kod pocztowy):',
		'region'=>'Region:',
		'manager'=>'OSOBA ZARZĄDZAJĄCA',
		'firstName'=>'Imię:',
		'lastName'=>'Nazwisko:',
		'office'=>'Stanowisko:',
		'contact'=>'DANE KONTAKTOWE',
		'phone'=>'Telefon:',
		'fax'=>'Fax:',
		'email'=>'Adres email:',
		'website'=>'STRONA INTERNETOWA',
		'websiteUrl'=>'Adres:',
		'executor'=>'Wykonawca:',
		'client'=>'Klient:',
		'companyLabel'=>'Firma:',
		'page'=>'Strona:',
		'pts'=>'pkt',
		'noteDescription'=>'Opis oceny',
	);
	
	private static $en = array(
		'no'=>'Id',
		'note'=>'Evaluation',
		'meaning'=>'Meaning',
		'ptsGained'=>'POINTS AWARDED',
		'criterionWeight'=>'Criterion weight:',
		'reliabilityPts'=>'Points awarded for reliability:',
		'criterionOverall'=>'Criterion overall:',
		'grounds'=>'SUBSTANTIATION',
		'ptsSummary'=>'SCORE SUMMARY',
		'ptsSummary2'=>'POINTS TOTAL',
		'reliabilityOverall'=>'Overall points awarded for reliability: ',
		'basicInfo'=>'BASIC INFORMATION',
		'companyName'=>'Company name:',
		'address'=>'Address:',
		'addressCont'=>'Address (continued):',
		'addressCity'=>'Address (city):',
		'addressZipCode'=>'Address (zip code):',
		'region'=>'Region:',
		'manager'=>'MANAGER',
		'firstName'=>'First name:',
		'lastName'=>'Last name:',
		'office'=>'Office:',
		'contact'=>'CONTACT DETAILS',
		'phone'=>'Phone no:',
		'fax'=>'Fax:',
		'email'=>'Email address:',
		'website'=>'WEBSITE',
		'websiteUrl'=>'Web address:',
		'executor'=>'Executor:',
		'client'=>'Client:',
		'companyLabel'=>'Firm:',
		'page'=>'Page:',
		'pts'=>'pts',
		'noteDescription'=>'Note description',
	);
	
	public function __construct($lang) 
	{
		switch ($lang)
		{
			case self::LANG_EN:
			{
				$this->lang = self::$en;
				break;
			}
			default:
			{
				$this->lang = self::$pl;
				break;
			}
		}		
	}
	
	public function getLabel($name)
	{
		return $this->lang[$name];
	}
}

?>
