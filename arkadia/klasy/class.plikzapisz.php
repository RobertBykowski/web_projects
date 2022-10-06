<?php

/**
 * PlikZapisz class v1.0
 * dla CMS i innych klas - obsluga odczyt, zapisu grafiki i innych plikow; * All rights reserved
 * @package PlikZapisz class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2006 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  require_once("class.plikzapisz.php");
	
  $plik=new plikZapisz("1_zdjecie.[rozs]");  // parametr to docelowa nazwa pliku wraz ze sciazka,  [rozs] - wstaw rozszerzenie [oryginal] - wstaw oryginalna nazwe [md5orygina] -wstaw md5 nazwy pliku
	$plik->zmiennaFiles("pic");	 //pobieraz z $_FILES dana zmienna
	$plik->getImgSkala(3);	//skalowanie 0- brak, 1- wysokosc, 2-szerokosc, 3-proporcjonalnie, 4- staly wymiar - skalowanie w dol, 5- staly wymiar skalowanie w dol i w gore, 6 - staly wymiar  z przycinaniem
	$plik->zapiszImg();  //podaj false jako argument jesli wygenerowac na ekran plik jpg/png
	
 *
 */
		
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

require_once(konf::get()->getKonfigTab('klasy')."class.swfheader.php");


class plikZapisz {

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */		

	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="pliki class";
	
	/**
	 * poprawnosc wykonania zadania
	 */		
	private $_ok=false;
	
	/**
	 * nazwa pliku
	 */				
	private $_nazwa="";	
	
	/**
	 * nazwa zmiennej w tablicy _FILES
	 */				
	private $_zmiennaFiles="";
	
	/**
	 * kopiowany plik
	 */				
	private $_kopiujPlik="";	
	
	/**
	 * max file size
	 */				
	private $_sizeMax=0;
	
	/**
	 * img width/height min/max
	 */				
	private $_imgSize=array("wmax"=>0,"wmin"=>0,"hmax"=>0,"hmin"=>0);	
	
	/**
	 * img typ skalowania 0- bez skalowania, 1-> na wysokosc, 2 -> na szerokosc, 3-> proporcjonalnie, 4->na staly wymiar w dol, 5-> na staly wymiar w dol i w gore, 6 - staly wymiar  z przycinaniem
	 */				
	private $_imgSkala=0;		
	
	/**
	 * img typy
	 */				
	private $_imgTypy=array();
	
	/**
	 * chmod
	 */				
	private $_chmod=0766;	
	
	/**
	 * bezpieczna nazwa pliku
	 */				
	private $_nazwaBezpieczna=true;
	
	
	/**
	 * lista dopuszczalnych rozszerzen */			
  private $_rozszerzeniaOk = array();
		
		
	/**
	 * lista niedopuszczalnych rozszerzen */			
  private $_rozszerzeniaZle = array('php', 'phtm', 'phtml', 'php3', 'php5', 'inc');	
	
	
	/**
	 * lista dopuszczalnych rozszerzen */			
  private $_mimeOk = array();
				
	/**
	 * lista niedopuszczalnych rozszerzen */			
  private $_mimeZle = array('application/x-httpd-php');		
	
		/*
	
    $mimes = array(
      'hqx'   =>  'application/mac-binhex40',
      'cpt'   =>  'application/mac-compactpro',
      'doc'   =>  'application/msword',
      'bin'   =>  'application/macbinary',
      'dms'   =>  'application/octet-stream',
      'lha'   =>  'application/octet-stream',
      'lzh'   =>  'application/octet-stream',
      'exe'   =>  'application/octet-stream',
      'class' =>  'application/octet-stream',
      'psd'   =>  'application/octet-stream',
      'so'    =>  'application/octet-stream',
      'sea'   =>  'application/octet-stream',
      'dll'   =>  'application/octet-stream',
      'oda'   =>  'application/oda',
      'pdf'   =>  'application/pdf',
      'ai'    =>  'application/postscript',
      'eps'   =>  'application/postscript',
      'ps'    =>  'application/postscript',
      'smi'   =>  'application/smil',
      'smil'  =>  'application/smil',
      'mif'   =>  'application/vnd.mif',
      'xls'   =>  'application/vnd.ms-excel',
      'ppt'   =>  'application/vnd.ms-powerpoint',
      'wbxml' =>  'application/vnd.wap.wbxml',
      'wmlc'  =>  'application/vnd.wap.wmlc',
      'dcr'   =>  'application/x-director',
      'dir'   =>  'application/x-director',
      'dxr'   =>  'application/x-director',
      'dvi'   =>  'application/x-dvi',
      'gtar'  =>  'application/x-gtar',
      'php'   =>  'application/x-httpd-php',
      'php4'  =>  'application/x-httpd-php',
      'php3'  =>  'application/x-httpd-php',
      'phtml' =>  'application/x-httpd-php',
      'phps'  =>  'application/x-httpd-php-source',
      'js'    =>  'application/x-javascript',
      'swf'   =>  'application/x-shockwave-flash',
      'sit'   =>  'application/x-stuffit',
      'tar'   =>  'application/x-tar',
      'tgz'   =>  'application/x-tar',
      'xhtml' =>  'application/xhtml+xml',
      'xht'   =>  'application/xhtml+xml',
      'zip'   =>  'application/zip',
      'mid'   =>  'audio/midi',
      'midi'  =>  'audio/midi',
      'mpga'  =>  'audio/mpeg',
      'mp2'   =>  'audio/mpeg',
      'mp3'   =>  'audio/mpeg',
      'aif'   =>  'audio/x-aiff',
      'aiff'  =>  'audio/x-aiff',
      'aifc'  =>  'audio/x-aiff',
      'ram'   =>  'audio/x-pn-realaudio',
      'rm'    =>  'audio/x-pn-realaudio',
      'rpm'   =>  'audio/x-pn-realaudio-plugin',
      'ra'    =>  'audio/x-realaudio',
      'rv'    =>  'video/vnd.rn-realvideo',
      'wav'   =>  'audio/x-wav',
      'bmp'   =>  'image/bmp',
      'gif'   =>  'image/gif',
      'jpeg'  =>  'image/jpeg',
      'jpg'   =>  'image/jpeg',
      'jpe'   =>  'image/jpeg',
      'png'   =>  'image/png',
      'tiff'  =>  'image/tiff',
      'tif'   =>  'image/tiff',
      'css'   =>  'text/css',
      'html'  =>  'text/html',
      'htm'   =>  'text/html',
      'shtml' =>  'text/html',
      'txt'   =>  'text/plain',
      'text'  =>  'text/plain',
      'log'   =>  'text/plain',
      'rtx'   =>  'text/richtext',
      'rtf'   =>  'text/rtf',
      'xml'   =>  'text/xml',
      'xsl'   =>  'text/xml',
      'mpeg'  =>  'video/mpeg',
      'mpg'   =>  'video/mpeg',
      'mpe'   =>  'video/mpeg',
      'qt'    =>  'video/quicktime',
      'mov'   =>  'video/quicktime',
      'avi'   =>  'video/x-msvideo',
      'movie' =>  'video/x-sgi-movie',
      'doc'   =>  'application/msword',
      'word'  =>  'application/msword',
      'xl'    =>  'application/excel',
      'eml'   =>  'message/rfc822'
    );
		
	*/	
	
	
	/**
	 * czy testowac palete CMYK dla JPG i odrzucac?
	 */				
	private $_checkCmyk=false;		
	
	/**
	 * jakosc jpg/png
	 */				
	private $_jakosc=82;
	
	/**
	
	 * rotate picture
	 */				
	private $_obrot=0;	
	
	
	/**
	 * wyostrzanie
	 */		
	private $_wyostrz=true;	
		
	
	/**
	 * zwracane komunikaty
	 */			
	private $_komunikat=array();	
	
	
	/**
	 * bierzacy plik
	 */				
	private $_plik=array(
		'name'=>"",
		'type'=>"",
	  'size'=>0,
		'w'=>0,
		'h'=>0,
		'imgtyp'=>0,
		'swf'=>0,
	  'tmp_name'=>"",
		'nazwa_pliku'=>"",
		'rozs'=>"",
		'komunikat'=>"",
	  'error'=>""
	);
	
	
	/**
	 * domyslne rozszerzenia dla IMG
	 */			
	private $_rozsTab=array(
		1=>"gif",
		2=>"jpg",
		3=>"png",
		4=>"swf",
		6=>"bmp",
		13=>"swf"
	);
	
	
	/**
	 * img crop
	 */				
	private $_imgCrop=array("x1"=>0,"x2"=>0,"y1"=>0,"y2"=>0);		


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
   * zmienna w tablicy _FILES
   * @param string $zmienna
   */		
	public function setZmiennaFiles($zmienna){
	
		if($zmienna==""){
			$this->dodajBlad("setZmiennaFiles: empty zmienna value",$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_zmiennaFiles=$zmienna;
		}
	}
	
	
  /**
   * maks. rozmiar pliku w bajtach
   * @param int $size
   */		
	public function setSizeMax($size){
		$size=$size+0;
		if(empty($size)||!is_integer($size)||$size<0){
			$this->_sizeMax=0;
		} else {
			$this->_sizeMax=$size;
		}
	}	
	
	
  /**
   * rozmiary graniczne obrazkow  
		* @param array $size
   */		
	public function setImgSize($size){
		if(empty($size)||!is_array($size)){
			$size=array();
		}
		
		reset($this->_imgSize);
		
		while(list($key,$val)=each($this->_imgSize)){
			if(!empty($size[$key])){
				$size[$key]=$size[$key]+0;
			}
			if(!empty($size[$key])&&is_integer($size[$key])&&$size[$key]>0){
				$this->_imgSize[$key]=$size[$key];
			} else {
				$this->_imgSize[$key]=0;
			}
		}

	}	
		

  /**
   * typ skalowania
   * @param int $skala
   */		
	public function setImgSkala($skala){
	
		$skala=$skala+0;
		
		if(empty($skala)||!is_integer($skala)||$skala<0){
			$this->_imgSkala=0;
		} else {
			$this->_imgSkala=$skala;
		}
		
	}	
	
	
	
  /**
   * rotate
   * @param int obrot
   */		
	public function setObrot($obrot){
	
		$obrot=$obrot+0;
		
		if(empty($obrot)||!is_integer($obrot)||($obrot!=90&&$obrot!=180&&$obrot!=270)){
			$this->_obrot=0;
		} else {
			$this->_obrot=$obrot;
		}
		
	}	
		
	
	
	
  /**
   * dozwolone typy plikow graficznych
   * @param array $typy
   */		
	public function setImgTypy($typy){
	
		if(!empty($typy)||is_array($typy)){
			$this->_imgTypy=array();
			
			reset($typy);
			
			while(list($key,$val)=each($typy)){
				if(!empty($val)&&is_integer($val)&&$val>0){
					$this->_imgTypy[$val]=$val;
				}
			}
		}
	}	
	
	
  /**
   * crop parameters
   * @param int $x1
   * @param int $x2		
   * @param int $y1
   * @param int $y2				
   */		
	public function setCrop($x1=0,$x2=0,$y1=0,$y2=0){
		$x1=$x1+0;
		$x2=$x2+0;
		$y1=$y1+0;
		$y2=$y2+0;					
		
		if($x1!=''&&$x1>=0){
			$this->_imgCrop['x1']=$x1;
		}
		
		if($x2!=''&&$x2>=0&&($x2>0&&$x2>=$this->_imgCrop['x1'])){
			$this->_imgCrop['x2']=$x2;
		}		
		
		if($y1!=''&&$y1>=0){
			$this->_imgCrop['y1']=$y1;
		}
		
		if($y2!=''&&$y2>=0&&($y2>0&&$y2>=$this->_imgCrop['y1'])){
			$this->_imgCrop['y2']=$y2;
		}				
		
	}		
	
  /**
   * check crop parameters
   * @param string $param
   * @param int $rozmiar		
   */		
	public function sprCrop($param,$rozmiar){

		if(!isset($this->_imgCrop[$param])||$this->_imgCrop[$param]>$rozmiar){
			$this->_imgCrop[$param]=0;
		}
		
	}
		
		
  /**
   * uprawnienia pliku po zapisie
   * @param string $chmod
   */		
	public function setChmod($chmod){
		if(!empty($chmod)&&strlen($chmod)<6){
			$this->_chmod=$chmod;
		}
	}	
	
	
  /**
   * jakosc png/jpg
   * @param int $jakosc
   */		
	public function setJakosc($jakosc){
		$jakosc=$jakosc+0;
		if(!empty($jakosc)&&is_integer($jakosc)&&$jakosc>0&&$jakosc<=100){
			$this->_jakosc=$jakosc;
		} 
	}		
	
	
	
  /**
   * czy nazwa bezpieczna
   * @param bool $bezpieczna
   */		
	public function setNazwaBezpieczna($bezpieczna){
		if($bezpieczna){
			$this->_nazwaBezpieczna=true;
		} else {
			$this->_nazwaBezpieczna=false;
		}
	}	
	
	
	
  /**
   * czy wyostrzac
   * @param bool $wyostrz
   */		
	public function setWyostrz($wyostrz){
		if($wyostrz){
			$this->_wyostrz=true;
		} else {
			$this->_wyostrz=false;
		}
	}	
		
	
  /**
   * dodaj typy danych
   * @param array $typy
   */		
	private function setTypy($typy,$table){
	
		if(!empty($typy)&&is_array($typy)&&!empty($table)){
		
			$this->_{$table}=array();
			
			reset($typy);
			
			while(list($key,$val)=each($typy)){
				if($val!=""){
					$this->_{$table}[]=$val;
				}
			}
		}
	}			
	
  /**
   * dozwolone rozszerzenia plikow
   * @param array $typy
   */		
	public function setRozszerzeniaOk($typy){
	
		$this->setTypy($typy,"rozszerzeniaOk");

	}	
	
	
  /**
   * dozwolone mime plikow
   * @param array $typy
   */		
	public function setMimeOk($typy){
	
		$this->setTypy($typy,"mimeOk");	

	}			
				
		
  /**
   * niedozwolone rozszerzenia plikow
   * @param array $typy
   */		
	public function setRozszerzeniaZle($typy){
	
		$this->setTypy($typy,"rozszerzeniaZle");		

	}		
	
	
  /**
   * niedozwolone mime plikow
   * @param array $typy
   */		
	public function setMimeZle($typy){
	
		$this->setTypy($typy,"mimeZle");		

	}			
		
  /**
   * formatuje nazwe pliku na bezpieczna
   *
   * @param    string $nazwa   nazwa pliku
   * @return   string nazwa po konwersji
   */
  public function nazwaBezpieczna($nazwa){	
	  $noalpha = 'ąęóżźłĄĘÓŻŹŁ';
	  $alpha   = 'aeozzlAEOZZL';
	  $nazwa = strtr($nazwa, $noalpha, $alpha);
	  // inne znaki zamien na "_"
	  return preg_replace('/[^a-zA-Z0-9,._=\+\()\-]/', '_', $nazwa);
  }	
	

  /**
   * wyciaga rozszerzenie z nazwy
   *
   * @param    string $nazwa   nazwa pliku
   * @return   string rozszerzenie
   */	
  public function rozszerzenie($nazwa){	
		$rozs="";
		
    if (($pos = strrpos($nazwa,".")) !== false) {
			$rozs = strtolower(substr($nazwa, $pos + 1));
    }	
		
		return $rozs;
		
	}
	
  /**
   * testuje rozszerzenie
   *
   * @param    string $rozs   nazwa rozszerzenia
   * @return   bool 
   */		
	public function rozszerzenieSpr($rozs){
		$ok=true;
		
		if(!empty($this->_rozszerzeniaZle)){
			if(in_array($rozs, $this->_rozszerzeniaZle)){
				$ok=false;
			}
		}
		
		if(!empty($this->_rozszerzeniaOk)){
			if(in_array($rozs, $this->_rozszerzeniaOk)){
				$ok=true;
			} else {
				$ok=false;
			}
		}		
		
		if(!$ok){
			$this->_komunikat[]="upload_rozs";
		}
		
		return $ok;
	}
	
	
  /**
   * testuje mime
   * @param string $mime nazwa mime
   * @return bool 
   */		
	public function mimeSpr($mime){
		$ok=true;
		
		if(!empty($this->_mimeZle)){
			if(in_array($mime, $this->_mimeZle)){
				$ok=false;
			}
		}
		
		if(!empty($this->_mimeOk)){
			if(in_array($mime, $this->_mimeOk)){
				$ok=true;
			} else {
				$ok=false;
			}
		}		
		
		if(!$ok){
			$this->_komunikat[]="upload_rozs";
		}
		
		return $ok;
	}	
	
	
  /**
   * pobiera plik z podanej lokacji na serwerze
   * @param   string $plik - nazwa zrodlowego pliku ze sciezka
   * 
   */		
	public function kopiujPlik($plik){
	
		$this->_ok=true;	
		$plik=trim($plik);		
		$this->_kopiujPlik=$plik;
		
		if(!empty($this->_kopiujPlik)){	
		
			if(!is_file($this->_kopiujPlik)){
				$this->_ok=false;
				$this->_komunikat[]="kopiuj_brak";
			}
			
			if($this->_ok){
				$this->_plik["tmp_name"]=$this->_kopiujPlik;
				$this->_plik["name"]=basename($this->_kopiujPlik);
				
				if($this->_plik["name"]==""||$this->_plik["name"]=="."||$this->_plik["name"]==".."){
					$this->_ok=false;
					$this->_komunikat[]="kopiuj_bladname";				
				} else {
				
					$this->_plik["size"]=filesize($this->_kopiujPlik);
					if(!is_integer($this->_plik["size"])){
						$this->_plik["size"]=0;
						$this->_ok=false;
						$this->_komunikat[]="kopiuj_bladsize";
					}
				}
			
			}
			
			if($this->_ok){
				if(empty($this->_plik["rozs"])){
				  $this->_plik["rozs"]=$this->rozszerzenie($this->_plik["name"]);
				}
			}					

		} else {
			$this->_ok=false;
			trigger_error("kopiujFiles: empty zmienna value",E_USER_ERROR);			
		}
		
	}
	
	
  /**
   * pobiera plik z _FILES
   * @param string $zmienna nazwa w tablicy _FILES 
   */		
	public function zmiennaFiles($zmienna){
	
		$this->_ok=true;
	
		$zmienna=trim($zmienna);
		
		$this->_zmiennaFiles=$zmienna;
		
		if(!empty($zmienna)){
		
			//sprawdzamy czy jest plik
			if(!empty($_FILES)&&!empty($_FILES[$zmienna])){
				$this->_plik=$_FILES[$zmienna];			
			} else {
				$this->_ok=false;
			}
			
			//sprawdzamy cz sa bledy
			if($this->_ok&&!empty($this->_plik["error"])){			
				$this->_ok=false;
				$this->_komunikat[]="upload_".$this->_plik["error"];
			}
			
			//sprawdzamy czy istnieje plik tmp
			if($this->_ok&&empty($this->_plik["tmp_name"])&&empty($this->_plik["name"])||!is_file($this->_plik["tmp_name"])){
				$this->_ok=false;
				$this->_komunikat[]="upload_brak";
			}							
			
			if($this->_ok){
			  $this->_plik["rozs"]=$this->rozszerzenie($this->_plik["name"]);
			}	else {
			  $this->_plik["rozs"]="";			
			}	
			
		} else {
			$this->_ok=false;
			trigger_error("zmiennaFiles: empty zmienna value",E_USER_ERROR);			
		}
	
	}
	
	
  /**
   * formatowanie nazwy
   * 
   * @param    string $rozs rozszerzenie 		
   */		
	public function nazwaFormatuj(){	
	
		if($this->_nazwaBezpieczna){
			$this->_plik["name"]=$this->nazwaBezpieczna($this->_plik["name"]);	
		}
				
		$this->_nazwa=str_replace("[rozs]",$this->_plik['rozs'],$this->_nazwa);
		$this->_nazwa=str_replace("[oryginal]",$this->_plik['name'],$this->_nazwa);		
		$this->_nazwa=str_replace("[md5oryginal]",md5($this->_plik['name'].time()),$this->_nazwa);		
				
		$this->_plik['nazwa_pliku']=basename($this->_nazwa);
		
	}
	
	
  /**
   * zapisuje plik
   * 
   */		
	public function zapisz(){
		
		if(!$this->rozszerzenieSpr($this->_plik["rozs"])){
			$this->_ok=false;
		}

		if(isset($this->_plik["type"])&&!$this->mimeSpr($this->_plik["type"])){
			$this->_ok=false;
		}		
		
		//sprawdzamy size
		if($this->_ok&&(!empty($this->_sizeMax)&&$this->_sizeMax<$this->_plik["size"])){
			$this->_ok=false;
			$this->_komunikat[]="upload_sizemax";
		}				
	
		if($this->_ok){
			
			$this->nazwaFormatuj();
		
			//plik z formularza
			if($this->_zmiennaFiles){
				
	    	if(move_uploaded_file($this->_plik["tmp_name"],$this->_nazwa)){
					$this->_ok=true;
				} else {
					$this->_ok=false;
					$this->_plik=array();
					trigger_error("zapisz: error upload file",E_USER_ERROR);	
				}		
			
				unset($_FILES[$this->_zmiennaFiles]);
				
			//kopiowanie pliku
			} else {
				if (copy($this->_plik["tmp_name"],$this->_nazwa)) {
					$this->_ok=true;		
				} else {
					$this->_ok=false;
					$this->_plik=array();
					trigger_error("zapisz: error copy file",E_USER_ERROR);	
				}	
					
			}
			
			if($this->_ok){
    		chmod($this->_nazwa,$this->_chmod);
			}					
			
		}
		
		return $this->zwrot();
	
	}
	
	
  /**
   * sprawdza czy modyfikowac img
   * 
   * @param array $size	
   * @param array $size_new		
	 * @return bool	
   */		
	private function modyfikacja($size,$size_new){
	
		$modyfikacja=false;
		
		if(!empty($this->_imgSkala)&&
			($size[2]==2||$size[2]==3)&&
			(
			 $size[0]!=$size_new[0]||
			 $size[1]!=$size_new[1]||
			 (!empty($this->_sizeMax)&&$this->_sizeMax<$this->_plik["size"])||
			 (!empty($this->imgCrop['x1'])||!empty($this->imgCrop['x2'])||!empty($this->imgCrop['y1'])||!empty($this->imgCrop['y2']))	
			)
		){
			$modyfikacja=true;
		}
			
		return $modyfikacja;
		
	}
	
	
    /**
     * @link http://pl.php.net/manual/en/function.imagecopyresampled.php
     * replacement to imagecopyresampled that will deliver results that are almost identical except MUCH faster (very typically 30 times faster)
     *
     * @static 
     * @access public
     * @param string $dst_image
     * @param string $src_image
     * @param int $dst_x
     * @param int $dst_y
     * @param int $src_x
     * @param int $src_y
     * @param int $dst_w
     * @param int $dst_h
     * @param int $src_w
     * @param int $src_h
     * @param int $quality
     * @return boolean
     */
    public static function fastImageCopyResampled (&$dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $quality = 5){		
      if (empty($src_image) || empty($dst_image)) {
          return false;
      }
      if ($quality <= 1) {
          $temp = imagecreatetruecolor ($dst_w + 1, $dst_h + 1);
          imagecopyresized ($temp, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w + 1, $dst_h + 1, $src_w, $src_h);
          imagecopyresized ($dst_image, $temp, 0, 0, 0, 0, $dst_w, $dst_h, $dst_w, $dst_h);
          imagedestroy ($temp);
      } elseif ($quality < 5 && (($dst_w * $quality) < $src_w || ($dst_h * $quality) < $src_h)) {
          $tmp_w = $dst_w * $quality;
          $tmp_h = $dst_h * $quality;
          $temp = imagecreatetruecolor ($tmp_w + 1, $tmp_h + 1);
          imagecopyresized ($temp, $src_image, 0, 0, $src_x, $src_y, $tmp_w + 1, $tmp_h + 1, $src_w, $src_h);
          imagecopyresampled ($dst_image, $temp, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $tmp_w, $tmp_h);
          imagedestroy ($temp);
      } else {
          imagecopyresampled ($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
      }

      return true;
    }	
	
	
  /**
   * zapisuje plik IMG
	 *
   * @param  bool $zapis czy zapisywac plik (false - tylko generowanie grafiki)					
   *
   */		
	public function zapiszImg($zapis=true){
	
		if(empty($this->_imgTypy)){
			$this->setImgTypy(array(2=>2));		
		}
		
		$this->_plik['w']=0;
		$this->_plik['h']=0;		
		$this->_plik['imgtyp']=0;		
		$this->_plik['swf']=0;				
	
		if($this->_ok){
			
	  	$size=GetImageSize($this->_plik["tmp_name"]);   // 0-width; 1-height; 2-typ; (bits, channels)
			
			//swf	
			if (in_array(4,$this->_imgTypy)&&(empty($size)&&($size[2]!=1&&$size[2]!=6&&$size[2]!=2||$size[2]!=3))){ 
				$swf=new swfHeader($this->_plik["tmp_name"]);
				if($swf->valid){
					if($this->_imgSkala==6){
						$this->_imgSkala=3;
					}
					$size[2]=4;
					$size[0]=$swf->width;
					$size[1]=$swf->height;
					$this->_plik['swf']=$swf->version;
				}	else {
					$size[2]="";				
				}
				if(!empty($this->_rozsTab[$size[2]])){
					$this->_plik["rozs"]=$this->_rozsTab[$size[2]];
				}
			}			
		}
					
		if(!$this->_ok||!in_array($size[2],$this->_imgTypy)){
			$this->_komunikat[]="upload_nieimg";
			$this->_ok=false;			
		}			
				
		//czy wymiary >0
		if($this->_ok&&($size[0]==0||$size[1]==0)){
			$this->_ok=false;
			$this->_komunikat[]="upload_imgsize";
		}			
		
		//dla jpg sprawdzamy CMYK
		if($this->_checkCmyk){
			if($this->_ok&&$size[2]==2&&$size['channels']!=3){
				$this->_ok=false;
				$this->_komunikat[]="upload_imgcmyk";		 		
			}		
		}
		
		$zmieniono=false;
		
		if($this->_ok){

			//nie skalowac lub nieskalowalne typy plikow
			if(empty($this->_imgSkala)||($size[2]==1||$size[2]==6)){
					
				$size_new=$size;													

			//skalowanie roznymi metodami	
			}	else {

				$dst_x=0;
				//x-coordinate of destination point 
				
				$dst_y=0;
	   		//y-coordinate of destination point 
								
				$src_x=0;
				//x-coordinate of source point 
				
				$src_y=0;
	   		//y-coordinate of source point 		
			
				//check crop parameters
				$this->sprCrop('x1',$size[0]);
				$this->sprCrop('x2',$size[0]);
				$this->sprCrop('y1',$size[1]);
				$this->sprCrop('y2',$size[1]);

				if(!empty($this->_imgCrop['x2'])){
					$size[0]=$this->_imgCrop['x2'];
					$zmieniono=true;
				}				
				
				if(!empty($this->_imgCrop['x1'])){
					$size[0]=$size[0]-$this->_imgCrop['x1'];
					$src_x=$this->_imgCrop['x1'];
					$zmieniono=true;
				}
				
				if(!empty($this->_imgCrop['y2'])){
					$size[1]=$this->_imgCrop['y2'];
					$zmieniono=true;
				}				
				
				if(!empty($this->_imgCrop['y1'])){
					$size[1]=$size[1]-$this->_imgCrop['y1'];
					$src_y=$this->_imgCrop['y1'];		
					$zmieniono=true;			
				}		
				
				if(!empty($this->_obrot)){
					$zmieniono=true;
				}
	
				switch($this->_imgSkala){
				
					//na wysokosc
					case 1:
						if(!empty($this->_imgSize['hmax'])&&$size[1]>$this->_imgSize['hmax']){
							$size_new[1]=$this->_imgSize['hmax'];
							$size_new[0]=floor($size[0]*($this->_imgSize['hmax']/$size[1]));
						}								
					break;
					
					//na szerokosc
					case 2:
						if(!empty($this->_imgSize['wmax'])&&$size[0]>$this->_imgSize['wmax']){
							$size_new[0]=$this->_imgSize['wmax'];
							$size_new[1]=floor($size[1]*($this->_imgSize['wmax']/$size[0]));
						}								
					break;
					
					//proporcjonalnie
					case 3:

						$skala[0]=0;
						$skala[1]=0;
						
						//skala na szerokosc
						if(!empty($this->_imgSize['wmax'])&&$size[0]>$this->_imgSize['wmax']){
							$skala[0]=$this->_imgSize['wmax']/$size[0];
						}
						
						//skala na wysokosc
						if(!empty($this->_imgSize['hmax'])&&$size[1]>$this->_imgSize['hmax']){
							$skala[1]=$this->_imgSize['hmax']/$size[1];
						}
						
						//czy jest skalowanie
						if(!empty($skala[0])||!empty($skala[1])){
							//skalowanie na szerokosc
							if((empty($skala[0])||$skala[0]>$skala[1])&&!empty($skala['1'])){
								$size_new[1]=$this->_imgSize['hmax'];
								$size_new[0]=floor($size[0]*$skala[1]);	
							//skalowanie na wysokosc								
							} else {
								$size_new[0]=$this->_imgSize['wmax'];
								$size_new[1]=floor($size[1]*$skala[0]);						
							}
						}
												
					break;
					
					//staly wymiar w dol
					case 4:
						if(!empty($this->_imgSize['wmax'])&&$size[0]>$this->_imgSize['wmax']){
							$size_new[0]=$this->_imgSize['wmax'];
						}
						if(!empty($this->_imgSize['hmax'])&&$size[1]>$this->_imgSize['hmax']){
							$size_new[1]=$this->_imgSize['hmax'];
						}							
					break;
					
					//staly wymiar w dol i w gore
					case 5:
						if(!empty($this->_imgSize['wmax'])){
							$size_new[0]=$this->_imgSize['wmax'];
						}
						if(!empty($this->_imgSize['hmax'])){
							$size_new[1]=$this->_imgSize['hmax'];
						}								
					break;
					
					//staly wymiar w dol i w gore z przycieciem
					case 6:
					
						$skala[0]=0;
						$skala[1]=0;

						//skala na szerokosc
						if(!empty($this->_imgSize['wmax'])&&$size[0]>$this->_imgSize['wmax']){
							$skala[0]=$this->_imgSize['wmax']/$size[0];
						}
						
						//skala na wysokosc
						if(!empty($this->_imgSize['hmax'])&&$size[1]>$this->_imgSize['hmax']){
							$skala[1]=$this->_imgSize['hmax']/$size[1];
						}
						
						//czy jest skalowanie (za szeroki i za wysoko)
						if(!empty($skala[0])&&!empty($skala[1])){
												
							//skalowanie na szerokosc
							if($skala[0]<$skala[1]){	
							
								//x-coordinate of source point 	
								$src_x+=floor(($size[0]-($this->_imgSize['wmax']/$skala[1]))/2);
																													
							//skalowanie na wysokosc								
							} else {
							
					   		//y-coordinate of source point 								
								$src_y+=floor(($size[1]-($this->_imgSize['hmax']/$skala[0]))/2);		
							}	
										
						} else {
						
							//tylko za szeroki - przyciecie na szerokosc
							if(!empty($skala[0])){	
								
								//wyciecie fragmentu ze srodka szerokosci					
								$src_x=+floor(($size[0]-$this->_imgSize['wmax'])/2);			
												
							//tylko za wysoki - przyciecie na wysokosc
							} else if(!empty($skala[1])){		
									
								//wyciecie fragmentu ze srodka szerokosci					
								$src_y+=floor(($size[1]-$this->_imgSize['hmax'])/2);		
														
							}
							
						}
						
						$size_new[0]=$this->_imgSize['wmax'];
						$size_new[1]=$this->_imgSize['hmax'];		
											
					break;					

				}
				
				if(empty($size_new[0])){
					$size_new[0]=$size[0];
				}
				
				if(empty($size_new[1])){
					$size_new[1]=$size[1];
				}					
									
			}
					
			//sprawdzamy wymiary po skalowaniu
			//nie trzeba dla 6 bo przeskalowany dokladnie na wymiar
			if($this->_imgSkala!=6){
			
				//za szeroko
				if(!empty($this->_imgSize['wmax'])&&$size_new[0]>$this->_imgSize['wmax']&&$this->_imgSkala!=1){
					$this->_ok=false;
					$this->_komunikat[]="upload_imgwmax";			
				}
				
				//za waski
				if($this->_ok&&!empty($this->_imgSize['wmin'])&&$size_new[0]<$this->_imgSize['wmin']){
					$this->_ok=false;
					$this->_komunikat[]="upload_imgwmin";							
				}			
				
				//za wysoki
				if($this->_ok&&!empty($this->_imgSize['hmax'])&&$size_new[1]>$this->_imgSize['hmax']&&$this->_imgSkala!=2){
					$this->_ok=false;
					$this->_komunikat[]="upload_imghmax";							
				}			
				
				//za niski
				if($this->_ok&&!empty($this->_imgSize['hmin'])&&$size_new[1]<$this->_imgSize['hmin']){
					$this->_ok=false;
					$this->_komunikat[]="upload_imghmin";							
				}		
				
			} 
			
		}
		
		if($this->_ok){
		
			$this->_plik['w']=$size_new[0];
			$this->_plik['h']=$size_new[1];		
			$this->_plik['imgtyp']=$size[2];
		
			//skalowanie jpg/png		
			if($this->modyfikacja($size,$size_new)||$zmieniono||!$zapis){

				if($size[2]==2){
					$input=ImageCreateFromJPEG($this->_plik["tmp_name"]); 			
				} else { 
					$input=ImageCreateFromPNG($this->_plik["tmp_name"]); 
				}	
	
	      if (function_exists("ImageCreateTrueColor")){ 
					$output = ImageCreateTrueColor ($size_new[0], $size_new[1]);
				} else {
					$output = ImageCreate ($size_new[0], $size_new[1]);
				}

				if($this->_imgSkala==6){
					$size[0]=$size[0]-($src_x-$this->_imgCrop['x1'])*2;
					$size[1]=$size[1]-($src_y-$this->_imgCrop['y1'])*2;
				}

	      if (function_exists("imagecopyresampled")){
					$this->fastImageCopyResampled($output, $input, $dst_x, $dst_y, $src_x, $src_y, $size_new[0], $size_new[1], $size[0], $size[1],5);
					//imagecopyresampled($output, $input, $dst_x, $dst_y, $src_x, $src_y, $size_new[0], $size_new[1], $size[0], $size[1]);
				} else {
					imagecopyresized($output, $input, $dst_x, $dst_y, $src_x, $src_y, $size_new[0], $size_new[1], $size[0], $size[1]);
				}

	      ImageDestroy($input);
				
				if($this->_obrot&&function_exists("imagerotate")){
				
					$output=imagerotate($output,$this->_obrot,0);	
					
					if($this->_obrot==90||$this->_obrot==270){
						$tmp=$size_new[0];
						$size_new[0]=$size_new[1];
						$size_new[1]=$tmp;
						$this->_plik['w']=$size_new[0];
						$this->_plik['h']=$size_new[1];								
					}
				}
										
				if($this->_wyostrz){
				
					/*
					$matrix = array(array( -1, -1, -1 ),array( -1, 16, -1 ),array( -1, -1, -1 ));
					$divisor = 8;
					$offset = 0;			

					if(function_exists("imageconvolution")){
						imageconvolution($output, $matrix, $divisor, $offset);		
					} else {
						$this->imageConv($output, $matrix, $divisor, $offset);						
					}
					*/
					
					if($size_new[0]<300||$size_new[1]<300){
						$output=$this->unsharpMask($output,10,"0.3",3,$size_new[0],$size_new[1]);
					}
					
				}
								
				$this->_plik['rozs']=$this->_rozsTab[$size[2]];
				$this->nazwaFormatuj();
				
				//zapisz do pliku
				if($zapis){
					if($size[2]==2){
						$this->_ok=ImageJPEG($output,$this->_nazwa,$this->_jakosc);
					} else {
						$this->_ok=ImagePNG($output,$this->_nazwa,$this->_jakosc);
					}
				//generuj 
				} else {
					if($size[2]==2){
						$this->_ok=ImageJPEG($output,"",$this->_jakosc);
					} else {
						$this->_ok=ImagePNG($output,"",$this->_jakosc);
					}				
				}
				
				ImageDestroy($output);
				
				if($this->_ok&&!empty($zapis)){				
	    		@chmod($this->_nazwa,$this->_chmod);					
				}
														
			//nie skalowac, tylko kopiowanie
			} else {

				$this->zapisz();	
			
			}
		
		}
		
		return $this->zwrot();		

	}
	
	
  /**
   * zwrto danych
   *
   * @return  array 
   */		
	public function zwrot(){	
	
		if(empty($this->_plik['name'])){
			$this->_plik['name']="";
		}
		if(empty($this->_plik['type'])){
			$this->_plik['type']="";
		}
		if(empty($this->_plik['size'])){
			$this->_plik['size']=0;
		}
		if(empty($this->_plik['w'])){
			$this->_plik['w']=0;
		}
		if(empty($this->_plik['h'])){
			$this->_plik['h']=0;
		}
		if(empty($this->_plik['imgtyp'])){
			$this->_plik['imgtyp']=0;
		}
		if(empty($this->_plik['swf'])){
			$this->_plik['swf']=0;
		}
		if(empty($this->_plik['tmp_name'])){
			$this->_plik['tmp_name']="";
		}
		if(empty($this->_plik['nazwa_pliku'])){
			$this->_plik['nazwa_pliku']="";
		}		
		if(empty($this->_plik['rozs'])){
			$this->_plik['rozs']="";
		}
		if(empty($this->_plik['error'])){
			$this->_plik['error']="";
		}
	
		$this->_plik['komunikat']=$this->_komunikat;
		$this->_plik['ok']=$this->_ok;

		return $this->_plik;
		
	}
	

  /**
   * unsharp effect
	 *	Unsharp Mask for PHP - version 2.1.1  
	 *	Unsharp mask algorithm by Torstein Honsi 2003-07.  
	 *  thoensi_at_netcom_dot_no.  
	 *	Please leave this notice.  

   * @param  resource $img 
   * @param  int $amount 		
   * @param  int $radius			
   * @param  int $threshold
   * @param  int $w		
   * @param  int $h		
   */	
	public function unsharpMask($img, $amount, $radius, $threshold,$w,$h)    { 

	    // $img is an image that is already created within php using 
	    // imgcreatetruecolor. No url! $img must be a truecolor image. 

	    // Attempt to calibrate the parameters to Photoshop: 
	    if ($amount > 500)    $amount = 500; 
	    $amount = $amount * 0.016; 
	    if ($radius > 50)    $radius = 50; 
	    $radius = $radius * 2; 
	    if ($threshold > 255)    $threshold = 255; 
	     
	    $radius = abs(round($radius));     // Only integers make sense. 
	    if ($radius == 0) { 
	    	return $img; 
			} 

	    $imgCanvas = imagecreatetruecolor($w, $h); 
	    $imgBlur = imagecreatetruecolor($w, $h); 
	     

	    // Gaussian blur matrix: 
	    //                         
	    //    1    2    1         
	    //    2    4    2         
	    //    1    2    1         
	    //                         
	    ////////////////////////////////////////////////// 
	         

	    if (function_exists('imageconvolution')) { // PHP >= 5.1  
			
	            $matrix = array(  
	            array( 1, 2, 1 ),  
	            array( 2, 4, 2 ),  
	            array( 1, 2, 1 )  
	        );  
	        imagecopy ($imgBlur, $img, 0, 0, 0, 0, $w, $h); 
	        imageconvolution($imgBlur, $matrix, 16, 0);  
					
	    } else {  

	    // Move copies of the image around one pixel at the time and merge them with weight 
	    // according to the matrix. The same matrix is simply repeated for higher radii. 
	        for ($i = 0; $i < $radius; $i++)    { 
	            imagecopy ($imgBlur, $img, 0, 0, 1, 0, $w - 1, $h); // left 
	            imagecopymerge ($imgBlur, $img, 1, 0, 0, 0, $w, $h, 50); // right 
	            imagecopymerge ($imgBlur, $img, 0, 0, 0, 0, $w, $h, 50); // center 
	            imagecopy ($imgCanvas, $imgBlur, 0, 0, 0, 0, $w, $h); 

	            imagecopymerge ($imgBlur, $imgCanvas, 0, 0, 0, 1, $w, $h - 1, 33.33333 ); // up 
	            imagecopymerge ($imgBlur, $imgCanvas, 0, 1, 0, 0, $w, $h, 25); // down 
	        } 
	    } 

	    if($threshold>0){ 
	        // Calculate the difference between the blurred pixels and the original 
	        // and set the pixels 
	        for ($x = 0; $x < $w-1; $x++)    { // each row
	            for ($y = 0; $y < $h; $y++)    { // each pixel 
	                     
	                $rgbOrig = ImageColorAt($img, $x, $y); 
	                $rOrig = (($rgbOrig >> 16) & 0xFF); 
	                $gOrig = (($rgbOrig >> 8) & 0xFF); 
	                $bOrig = ($rgbOrig & 0xFF); 
	                 
	                $rgbBlur = ImageColorAt($imgBlur, $x, $y); 
	                 
	                $rBlur = (($rgbBlur >> 16) & 0xFF); 
	                $gBlur = (($rgbBlur >> 8) & 0xFF); 
	                $bBlur = ($rgbBlur & 0xFF); 
	                 
	                // When the masked pixels differ less from the original 
	                // than the threshold specifies, they are set to their original value. 
	                $rNew = (abs($rOrig - $rBlur) >= $threshold)  
	                    ? max(0, min(255, ($amount * ($rOrig - $rBlur)) + $rOrig))  
	                    : $rOrig; 
	                $gNew = (abs($gOrig - $gBlur) >= $threshold)  
	                    ? max(0, min(255, ($amount * ($gOrig - $gBlur)) + $gOrig))  
	                    : $gOrig; 
	                $bNew = (abs($bOrig - $bBlur) >= $threshold)  
	                    ? max(0, min(255, ($amount * ($bOrig - $bBlur)) + $bOrig))  
	                    : $bOrig; 
	                 
	                 
	                             
	                if (($rOrig != $rNew) || ($gOrig != $gNew) || ($bOrig != $bNew)) { 
	                        $pixCol = ImageColorAllocate($img, $rNew, $gNew, $bNew); 
	                        ImageSetPixel($img, $x, $y, $pixCol); 
	                    } 
	            } 
	        } 
					
	    } else { 
	        for ($x = 0; $x < $w; $x++)    { // each row 
	            for ($y = 0; $y < $h; $y++)    { // each pixel 
	                $rgbOrig = ImageColorAt($img, $x, $y); 
	                $rOrig = (($rgbOrig >> 16) & 0xFF); 
	                $gOrig = (($rgbOrig >> 8) & 0xFF); 
	                $bOrig = ($rgbOrig & 0xFF); 
	                 
	                $rgbBlur = ImageColorAt($imgBlur, $x, $y); 
	                 
	                $rBlur = (($rgbBlur >> 16) & 0xFF); 
	                $gBlur = (($rgbBlur >> 8) & 0xFF); 
	                $bBlur = ($rgbBlur & 0xFF); 
	                 
	                $rNew = ($amount * ($rOrig - $rBlur)) + $rOrig; 
	                    if($rNew>255){$rNew=255;} 
	                    elseif($rNew<0){$rNew=0;} 
	                $gNew = ($amount * ($gOrig - $gBlur)) + $gOrig; 
	                    if($gNew>255){$gNew=255;} 
	                    elseif($gNew<0){$gNew=0;} 
	                $bNew = ($amount * ($bOrig - $bBlur)) + $bOrig; 
	                    if($bNew>255){$bNew=255;} 
	                    elseif($bNew<0){$bNew=0;} 
	                $rgbNew = ($rNew << 16) + ($gNew <<8) + $bNew; 
	                    ImageSetPixel($img, $x, $y, $rgbNew); 
	            } 
	        } 
	    } 
			
	    imagedestroy($imgCanvas); 
	    imagedestroy($imgBlur); 
	     
	    return $img; 

	}	
		
		
	/**
   * class constructor php5	
   * @param    string $nazwa   nazwa pliku		
   */	
	public function __construct($nazwa) {	
	
		$nazwa=strip_tags(trim($nazwa));
		
		if(!empty($nazwa)){
			$this->_nazwa=$nazwa;
		} else {
			trigger_error("_construct: empty file name",E_USER_ERROR);		
		}
  }	

	
}

?>