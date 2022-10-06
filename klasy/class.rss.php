<?php

/**
 * Rss class v1.0
 * dla CMS i innych klas - tworzenie RSS
 * @package rss class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2006 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  include("class.rss.php");

  $rss=new rss("2.0");

	$rss->setParametry(array(
		"title"=>$dane['tytul'],
		"about"=>$konfig['adres_www'],	
		"description"=>$konfig['adres_www']." ".$dane['tytul'],
		"rights"=>"Copyright &#169; ".$konfig['nazwa_www'],		
		"date"=>time()
	));	
		
  // data for a single RSS item
  $item=array(
    "about" => "",
    "title" => "",
    "link" => "",		
    "category" => "",		
    "description" => "",
    "subject" => "", // optional DC value
    "date" => time(), // optional DC value
    "author" => "", // author of item
    "comments" => "" // url to comment page rss 2.0 value
  );
  $rss->dodaj($item);

  echo $rss->zwrot();

 *
 */

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

class rss {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="rss class";

	/**
	* XML version
	*/
	private $_XMLversion="1.0";

	/**
	* RSS version
	*/
	private $_RSSversion="2.0";

	/**
	* local timezone, set to "" to disable or for GMT
	*/
	private $_timezone="";

	/**
	* iso format language
	*/
	private $_language="pl";

	/**
	* width of image
	*/
	private $_imageW=0;

	/**
	* width of image
	*/
	private $_imageH=0;

	/**
	* 'hourly' | 'daily' | 'weekly' | 'monthly' | 'yearly'
	*/
	private $_period="";

	/**
	* every X hours/days/weeks/...
	*/
	private $_frequency="";

	/**
	* date (RFC822)
	* Defines a base date to be used in concert with updatePeriod and updateFrequency to calculate the publishing schedule.
	*/
	private $_base="";

	/**
	* array with all the rss items
	*/
	private $_items=array();

	/**
	* use DC data
	*/
	private $_dcData=false;

	/**
	* use SY data
	*/
	private $_syData=false;
	
	/**
	* new line
	*/
	private $_nowa="\n";

	
	/**
	* CSS stylesheet
	* xls stylesheet
	* encoding of the XML file
	* URL where the RSS document will be made available
	* title of the rss stream
	* description of the rss stream
	* publisher of the rss stream (person, an organization, or a service)
	* creation date (RFC822)	
	* creator of the rss stream (person, an organization, or a service)
	* spatial location (a place name or geographic coordinates), temporal period (a period label, date, or date range) or jurisdiction (such as a named administrative entity)	
	* image
	* category (rss 2.0)
	* caching time in minutes (rss 2.0)
	* description
	* person, an organization, or a service	
	*/
	private $_parametry=array(
		"cssStyleSheet"=>"",
		"xlsStyleSheet"=>"",
		"encoding"=>"UTF-8",
		"about"=>"",
		"title"=>"",
		"description"=>"",
		"publisher"=>"",
		"date"=>"",		
		"creator"=>"",
		"rights"=>"",
		"coverage"=>"",		
		"image_link"=>"",
		"category"=>"",
		"cache"=>"",
		"description"=>"",
		"contributor"=>""
	);
	
	/**
	* DC parametry
	*/	
	private $_parametryDC=array(
		"publisher"=>"",
		"creator"=>"",
		"date"=>"",
		"rights"=>"",
		"coverage"=>"",		
		"contributor"=>""		
	);	


  /**
   * Public methods
   */
				
				
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
		return $this->_nazwaKlasy;
	}					


  /**
   * Returns date as an RFC822 date
   * @return a date in RFC822 format
   */
  public function rfc822($time) {
	  $date = gmdate("D, d M Y H:i:s", $time);
	  if (strlen($this->_timezone)) {
	     $date.= " ".str_replace(":", "", $this->_timezone);
	  } else {
	     $date.= " GMT";
	  }
	  return $date;
  }

  /**
   * Returns date as an iso8601 format
   * @return a date in iso8601 format
   */
  public function iso8601($time) {
	  $date = gmdate("Y-m-d\TH:i:sO",$this->unix);
	  $date = substr($date,0,22) . ':' . substr($date,-2);
	  if (strlen($this->timezone)) {
	     $date = str_replace("+00:00", $this->timezone, $date);
	  }
	  return $date;
  }
	

  /**
   * Set RSS version
   * @param string $version RSS version
   */
  public function setVersion($wersja="") {
  	if(is_string($wersja)&&strlen($wersja)){
      if(preg_match("/^(0\.91|1\.0|2\.0)$/",$wersja)) {
      	$this->_RSSversion=$wersja;
			} else {
				trigger_error("setVersion: invalid wersja value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}
		}
  }
	
	
  /**
   * Set language
   * @param string $language
   */
  public function setLanguage($jezyk="") {
  	if(!empty($jezyk)&&is_string($jezyk)){
      if(preg_match('(^([a-zA-Z]{2})$)',$jezyk)>0){
        $this->setDcData(true);
        $this->_language=$jezyk;
			} else {
				trigger_error("setLanguage: invalid jezyk value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}
		}
  }	


  /**
  * Set image parameters
  * @param int $w
  * @param int $h	
  */
  public function setImgParams($w,$h) {
  	if(!empty($w)&&!empty($h)){
      if(is_numeric($w)&&is_numeric($h)){
        $this->_imageW=$w;
        $this->_imageH=$h;
			} else {
				trigger_error("setImgParams: invalid w,h value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}
		}
  }	
	

  /**
   * Set period
   * @param string $period
   */
  public function setPeriod($period="") {
  	if(!empty($period)&&is_string($period)){
			$period=strtolower($period);
			if(preg_match("/^(hourly|daily|weekly|monthly|yearly)$/",$period)){
        $this->setSyData(true);
        $this->_period=$period;
			} else {
				trigger_error("setPeriod: invalid period value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}
		}
  }	
	
	
  /**
   * Set frequency
   * @param string $frequency
   */
  public function setFrequency($frequency="") {
  	if(!empty($frequency)){
      if(is_int($frequency)){
        $this->setSyData(true);
        $this->_frequency=$frequency;
			} else {
				trigger_error("setFrequency: invalid frequency value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}
		}
  }		

	
  /**
   * Set base
   * @param string $base
   */
  public function setBase($base="") {
  	if(is_string($base)&&strlen($base)){
      $this->setSyData(true);
      $this->_base=$base;
		}
  }		
	
	
  /**
   * ustawia znak nowej linii
   * @param string $nowa
   */
  public function setNowa($nowa="") {
  	$this->_nowa=$nowa;
  }						

	
	/**
	 * Add new RSS parameters
	 * @param array $param
	 * @return bool
	 */
	public function setParametry($param) {
  	if(!empty($param)){
      if(is_array($param)){
				reset($param);
				while(list($key,$val)=each($param)){
					if(isset($this->_parametry[$key])){
						$this->_parametry[$key]=$val;
						if(isset($this->_parametryDC[$key])){
							$this->setDcData(true);
						}
					} else {
						trigger_error("setFrequency: invalid param ".$key." ".$this->getNazwaKlasy(),E_USER_ERROR);
					}
				}			
			} else {
				trigger_error("setFrequency: invalid param value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}
		}	
	}
	
	

	/**
	 * Add new RSS items
	 * @param array $item
	 * @return bool
	 */
	public function dodaj($item) {
  	if(!empty($item)){
      if(is_array($item)&&!empty($item['title'])&&!empty($item['link'])){
			
        if (!isset($item["about"])) {
          $item["about"]="";
        }
        if (!isset($item["description"])) {
          $item["description"]="";
        }
        if (!isset($item["subject"])) {
          $item["subject"]="";
        }
        if (!isset($item["date"])) {
          $item["date"]="";
        } else {
					$item["date"]=$this->rfc822($item["date"]);
				}
        if (!isset($item["author"])) {
          $item["author"]="";
        }
        if (!isset($item["comments"])) {
          $item["comments"]="";
        }			
        if (!isset($item["category"])) {
          $item["category"]="";
        }						
        $this->_items[]=$item;
				
			} else {
				trigger_error("setFrequency: invalid frequency value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}
		}	
	}


  /**
   * Set dcData
   * @param bool $dc
   */
  public function setDcData($dc) {
  	if(!empty($dc)){
			$this->_dcData=true;
		} else {
			$this->_dcData=false;		
		}
  }		
	
	
  /**
   * Set syData
   * @param bool $dc
   */
  public function setSyData($sy) {
  	if(!empty($sy)){
			$this->_syData=true;
		} else {
			$this->_syData=false;		
		}
  }		
	
	
  /**
   * zwraca element xml
   * @param string $el
   * @param string $wartosc		
   * @param bool $pusty
   */
  public function zwrotEl($el,$wartosc,$pusty=false) {
	
		$dane="";
		
  	if(!empty($wartosc)||$pusty){
			$dane="<".$el.">".$wartosc."</".$el.">".$this->_nowa;
		}
		
		return $dane;
  }			
			
				
 /**
  * Get output
  * Returns output
  * @return output string
  */
	public function zwrot() {

  	$output="<?xml version=\"".$this->_XMLversion."\" encoding=\"".$this->_parametry['encoding']."\" ?>".$this->_nowa;
		
		if ($this->_RSSversion=="0.91") {
			$output.="<!DOCTYPE rss SYSTEM \"http://my.netscape.com/publish/formats/rss-0.91.dtd\">".$this->_nowa;
		}
		
   	if ($this->_parametry['cssStyleSheet']){
     	$output.="<?xml-stylesheet href=\"".$this->$this->_parametry['cssStyleSheet']."\" type=\"text/css\" ?>".$this->_nowa;
    }
    if ($this->_parametry['xlsStyleSheet']){
     	$output.="<?xml-stylesheet href=\"".$this->$this->_parametry['xlsStyleSheet']."\" type=\"text/xls\" ?>".$this->_nowa;
    }			
					
		if ($this->_RSSversion=="0.91"||$this->_RSSversion=="2.0") {		
			
			$output.="<rss version=\"".$this->_RSSversion."\">".$this->_nowa;
      $output.="<channel>".$this->_nowa;

			$output.=$this->zwrotEl("copyright",$this->_parametry['rights']);			
			$output.=$this->zwrotEl("pubDate",$this->rfc822($this->_parametry['date']));
			$output.=$this->zwrotEl("lastBuildDate",htmlspecialchars($this->rfc822($this->_parametry['date'])));		
			$output.=$this->zwrotEl("docs",$this->_parametry['about']);			
			$output.=$this->zwrotEl("description",$this->_parametry['description']);			
			$output.=$this->zwrotEl("link",$this->_parametry['about']);					
			$output.=$this->zwrotEl("title",$this->_parametry['title']);					
			$output.=$this->zwrotImg();
			$output.=$this->zwrotEl("managingeditor",$this->_parametry['publisher']);	
			$output.=$this->zwrotEl("webmaster",$this->_parametry['creator']);			
			$output.=$this->zwrotEl("language",$this->_language);	
			
		}

		if ($this->_RSSversion=="2.0") {
			
			$output.=$this->zwrotEl("generator",$this->_parametry['creator']);
			$output.=$this->zwrotEl("category",$this->_parametry['category']);	
			$output.=$this->zwrotEl("ttl",$this->_parametry['cache']);	
			
      reset($this->_items);
			while(list($key,$val)=each($this->_items)){
       	$output.="<item>".$this->_nowa;
				$output.=$this->zwrotEl("title",$val['title'],true);
				$output.=$this->zwrotEl("link",$val['link'],true);	
				$output.=$this->zwrotEl("description",$val['description']);
				$output.=$this->zwrotEl("category",$val['category']);
				$output.=$this->zwrotEl("pubdate",$val['date']);
				$output.=$this->zwrotEl("guid",$val['about']);								
				$output.=$this->zwrotEl("author",$val['author']);				
				$output.=$this->zwrotEl("comments",htmlspecialchars($val['comments']));							
				$output.="</item>".$this->_nowa;														
			}		
					
		} else if ($this->_RSSversion=="0.91") {
		
      reset($this->_items);
			while(list($key,$val)=each($this->_items)){
       	$output.="<item>".$this->_nowa;
				$output.=$this->zwrotEl("title",$val['title'],true);
				$output.=$this->zwrotEl("link",$val['link'],true);	
				$output.=$this->zwrotEl("description",$val['description']);
				$output.="</item>".$this->_nowa;														
			}
			
		} else if ($this->_RSSversion=="1.0") {
		
			$output.="<rdf:RDF xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\" ";
      if($this->_dcData){
      	$output.="xmlns:dc=\"http://purl.org/dc/elements/1.1/\" ";
      }
      if($this->_syData){
      	$output.="xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\" ";
      }			
			$output.="xmlns=\"http://purl.org/rss/1.0/\">".$this->_nowa;
      if ($this->_parametry['about']) {
				$output.="<channel rdf:about=\"".$this->_parametry['about']."\">".$this->_nowa;
      } else {
				$output.="<channel>".$this->_nowa;			
			}
			
			$output.=$this->zwrotEl("title",$this->_parametry['title']);		
			$output.=$this->zwrotEl("link",$this->_parametry['about']);	
			$output.=$this->zwrotEl("description",$this->_parametry['description']);	
			$output.=$this->zwrotEl("dc:publisher",$this->_parametry['publisher']);	
			$output.=$this->zwrotEl("dc:creator",$this->_parametry['creator']);				
			$output.=$this->zwrotEl("dc:language",$this->_language);															
			$output.=$this->zwrotEl("dc:date",$this->iso8601($this->_parametry['date']));	
			$output.=$this->zwrotEl("dc:rights",$this->_parametry['rights']);
			$output.=$this->zwrotEl("dc:coverage",$this->_parametry['coverage']);
			$output.=$this->zwrotEl("dc:contributor",$this->_parametry['contributor']);
			$output.=$this->zwrotEl("dc:updatePeriod",$this->_period);
			$output.=$this->zwrotEl("dc:updateFrequency",$this->_frequency);											
			$output.=$this->zwrotEl("dc:updateBase",$this->_base);									

			$output.=$this->zwrotImg();

			if(!empty($items)){
				reset($this->_items);			
				$output.="<items><rdf:seq>".$this->_nowa;
				while(list($key,$val)=each($this->_items)){			
          if (!empty($val['about'])) {
          	$output.="<rdf:li resource=\"".$val['about']."\" />".$this->_nowa;
          }				
				}
				$output.="</rdf:seq></items>".$this->_nowa;				
			}
      $output.="</channel>".$this->_nowa;
			
      reset($this->_items);
			while(list($key,$val)=each($this->_items)){		
			
      	if(!empty($val['about'])){
        	$output.="<item rdf:about=\"".$val['about']."\">".$this->_nowa;	
        } else {
        	$output.="<item>".$this->_nowa;	
        }
				
				$output.=$this->zwrotEl("title",$val['title'],true);
				$output.=$this->zwrotEl("link",$val['link'],true);	
				$output.=$this->zwrotEl("description",$val['description']);

      	if($this->_dcData){
					$output.=$this->zwrotEl("dc:subject",$val['subject']);
				}
      	if($this->_dcData){
					$output.=$this->zwrotEl("dc:date",$val['date']);				
				}				
        $output.="</item>".$this->_nowa;
			}		
			$output.="</rdf:RDF>";

    }
		
		if ($this->_RSSversion=="0.91"||$this->_RSSversion=="2.0") {				
			$output.="</channel>".$this->_nowa;	
			$output.="</rss>".$this->_nowa;	
		}

		return $output;
		
	}


 	/**
  * Get IMG output
  * @return output string
  */	
	public function zwrotImg(){
	
		$output="";
		
    if ($this->_parametry['image_link']) {		
      $output.="<image>".$this->_nowa;
			$output.=$this->zwrotEl("title",htmlspecialchars($this->_parametry['title']),true);
			$output.=$this->zwrotEl("url",$this->_parametry['image_link'],true);
			$output.=$this->zwrotEl("link",$this->_parametry['about'],true);												
			$output.=$this->zwrotEl("width",$this->_imageW);								
			$output.=$this->zwrotEl("height",$this->_imageH);		
			$output.=$this->zwrotEl("description",$this->$this->_parametry['description']);
      $output.="</image>".$this->_nowa;	
		}
		
		return $output;
		
	}
	

	/**
   * class constructor php5	
   * @param    string $wersja wersja RSS	
   */	
	public function __construct($wersja) {	
		$this->_date=date("Y-m-d\TH:i:sO");
		$this->setVersion($wersja);			
  }	


}

?>