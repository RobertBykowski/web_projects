<?php

/**
 * BotProof class v1.0 (2009-05-21)
 * dla CMS i innych klas - zabezpieczneie przed robotami.
 * na podstawie klasy BotProof class v1.1 (Dominik Raś)	
 * All rights reserved
 * @package BotProof class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2009 JW Web Development
 */
	
	

/**
 *
 * Example: simple form
 * file: test.php

	require_once('klasy/class.botproof.php');	

  if (!empty($_POST['GKodHash'])&&!empty($_POST['kod'])){

     $proof=new botProof("admin");
     $proof->setGKodHash($_POST['GKodHash']);

     if ($proof->sprKod($_POST['kod'])) {
        echo $_POST['kod']." - kod ok!<br />";
     } else {
        echo $_POST['kod']." - kod error!<br />";
     }

  }

	$proof2=new botProof("admin");
	$proof2->setIleZnakow(5);
	$proof2->setLitery(true);
	$proof2->setCyfry(true);	
	//$proof2->setDuze(true);		
	$proof2->generujKod();

  echo "<form action=\"test.php\" method=\"post\">";
  echo "<input type=\"hidden\" name=\"GKodHash\" value=\"".$proof2->getGKodHash()."\" />";
  echo "<img src=\"botproof.php?GKodEncrypt=".rawurlencode($proof2->getGKodEncrypt())."\" alt=\"\" style=\"margin:5px; border:1px solid #666666\" /><br />";
  echo "<input type=\"text\" name=\"kod\" value=\"\" maxlength=\"5\" /><br />";
  echo "<input type=\"submit\" value=\"Check kod\" />";
  echo "</form>";

 * Example: 
 * file: botproof.php	

	require_once('klasy/class.botproof.php');

	if(!empty($_GET['GKodEncrypt'])){
		$proof=new botProof("admin");
		$proof->setMargines(10);
		$proof->setLinie(20);	
		$proof->setImgTlo("grafika/botproof/szumy.jpg");
		$proof->setZnakKolor(array(array(23,134,230),array(23,324,30),array(230,14,20)));
		$proof->setTlo(array(255,233,233));
		//$proof->setCzcionka(5);	
		$proof->setPlikTTF("grafika/botproof/Verdana.ttf");
		$proof->setRozmiar(24);
		$proof->setGKod($_GET['GKodEncrypt'],true);	
		//echo $proof->getGKod();
		$proof->obrazek();
	}	
	
 *
 */
	

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		
	

/* this class require encryptmd5 class */
require_once("class.encryptmd5.php");

class BotProof {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="botproof class";
	
	/**
	 * kod
	 */
	private $_gKod="";

	/**
	 * hash md5
	 */
	private $_gKodHash="";

	/**
	 * zakodowany
	 */
	private $_gKodEncrypt="";

	/**
	 * prefix do md5
	 */
	private $_md5prefix="";
	

	/**
	 * ile znakow
	 */
	private $_ileZnakow=5;
	

	/**
	 * czy uzywac fyfr
	 */
	private $_cyfry=true;
	

	/**
	 * _litery
	 */
	private $_litery=true;
	

	/**
	 * zamina na _duze _litery
	 */
	private $_duze=true;
	

	/**
	 * _pomin znaki iIlLoO0Q
	 */
	private $_pomin="iIlLoO0Q";
	

	/**
	 * znak padding
	 */
	private $_znakPadding=7;
	

	/**
	 * _rozmiar czcionki
	 */
	private $_rozmiar=4;
	

	/**
	 * typ czcionki
	 */
	private $_czcionka=1;
	

	/**
	 * max kat obrotu znaku
	 */
	private $_znakObr=35;
	

	/**
	 * _margines wokol znakow
	 */
	private $_margines=10;
	
	
	/**
	 * kolor tla
	 */
	private $_tlo=array(255,255,255);
	

	/**
	 * obrazek tla (JPG)
	 */
	private $_imgTlo="";
			
		
	/**
	 * obrazek nalozony na wierzch (przezroczysty PNG)
	 */
	private $_imgTlo2="";
	

	/**
	 * kolor znakow, - tablica losowo
	 */
	private $_znakKolor=array(array(0,0,0));
	

	/**
	 * jakosc obrazka
	 */
	private $_imgQuality=80;
	

	/**
	 * TTF _czcionka
	 */
	private $_plikTTF="";
	

	/**
	 * losowe _linie - ilosc
	 */
	private $_linie=0;
	
	
	/**
	 * kolory lini - tablica losowo
	 */
	private $_linieKolor=array(
	  array(255,140,0),
	  array(255,255,0),
	  array(40,149,237),
	  array(169,169,169)
	);
	
	/**
	 * szerokosc obrazka
	 */	
	private $_ImageWidth=0;
	
	
	/**
	 * wysokosc obrazka
	 */	
	private $_ImageHeight=0;

	
	/**
	 * generowany obrazek
	 */		
	private $_output="";	
	
	
	/**
	 * szerokosc czcionki
	 */			
	private $_fontWidth=0;
	
	
	/**
	 * wysokosc czcionki
	 */				
	private $_fontHeight=0;	
	
	
	/**
	 * lista znakow TTF
	 */					
	private $_znakiTTFwidth=array();
	
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
   * zwraca wygenerowany kod
   * @return string				
   */		
	public function getGKod(){
		return $this->_gKod;
	}	
	
	
  /**
   * zapisuje kod
   * @param string $gkod			
   * @param bool $encrypt
   */		
	public function setGKod($gkod,$encrypt=false){
		if(is_string($gkod)||is_int($gkod)){
			
			if($encrypt){
				//odkoduj tekst
				$decrypt =new encryptMd5();			
			  $gkod=$decrypt->decrypt($gkod, $this->_md5prefix);
			}
			
			$this->_gKod=$gkod;
		}
	}		
	
	
  /**
   * zwraca wygenerowany kod hash
   * @return string				
   */		
	public function getGKodHash(){
		return $this->_gKodHash;
	}	
	
	
  /**
   * zapisuje kod
   * @param string $gkodHash		
   */		
	public function setGKodHash($gkodHash){
		if(is_string($gkodHash)||is_int($gkodHash)){
		
			$this->_gKodHash=$gkodHash;
		}
	}			
	
	
  /**
   * zwraca wygenerowany kod zakodowany
   * @return string				
   */		
	public function getGKodEncrypt(){
		return $this->_gKodEncrypt;
	}	
		
		
  /**
   * md5prefix
   * @param string $md5prefix			
   */		
	public function setMd5prefix($md5prefix){
		if(!empty($md5prefix)&&(is_string($md5prefix)||is_int($md5prefix))){
			$this->_md5prefix=$md5prefix;
		} else if(!empty($md5prefix)) {
			trigger_error("setMd5prefix: invalid md5prefix ".$this->getNazwaKlasy(),E_USER_ERROR);			
		}
	}	
		
	
  /**
   * ileZnakow
   * @param int $ileZnakow		
   */		
	public function setIleZnakow($ileZnakow){
		if(!empty($ileZnakow)&&(is_int($ileZnakow))&&$ileZnakow>0&&$ileZnakow<50){
			$this->_ileZnakow=$ileZnakow;
		} else {
			trigger_error("setIleZnakow: invalid ileZnakow ".$this->getNazwaKlasy(),E_USER_ERROR);			
		}
	}	
			
	
  /**
   * cyfry
   * @param bool $cyfry			
   */		
	public function setCyfry($cyfry){
		if($cyfry){
			$this->_cyfry=true;
		} else {
			$this->_cyfry=false;	
		}
	}	
				
	
  /**
   * litery
   * @param bool $litery			
   */		
	public function setLitery($litery){
		if($litery){
			$this->_litery=true;
		} else {
			$this->_litery=false;	
		}
	}		

	
  /**
   * duze
   * @param bool $duze			
   */		
	public function setDuze($duze){
		if($duze){
			$this->_duze=true;
		} else {
			$this->_duze=false;	
		}
	}			

	
  /**
   * pomin
   * @param string $pomin			
   */		
	public function setPomin($pomin){
		if(!empty($pomin)&&(is_string($pomin)||is_int($pomin))){
			$this->_pomin=$pomin;
		} else if(!empty($pomin)) {
			trigger_error("setPomin: invalid pomin ".$this->getNazwaKlasy(),E_USER_ERROR);			
		}
	}	
			

  /**
   * znakPadding
   * @param int $znakPadding			
   */		
	public function setZnakPadding($znakPadding){
		if(!empty($znakPadding)&&(is_int($znakPadding))&&$znakPadding>=0&&$znakPadding<20){
			$this->_znakPadding=$znakPadding;
		} else {
			trigger_error("setZnakPadding: invalid znakPadding ".$this->getNazwaKlasy(),E_USER_ERROR);			
		}
	}		

	
  /**
   * rozmiar
   * @param int $rozmiar			
   */		
	public function setRozmiar($rozmiar){
		if(!empty($rozmiar)&&(is_int($rozmiar))&&$rozmiar>=0&&$rozmiar<50){
			$this->_rozmiar=$rozmiar;
		} else {
			trigger_error("setRozmiar: invalid rozmiar ".$this->getNazwaKlasy(),E_USER_ERROR);			
		}
	}			


  /**
   * czcionka
   * @param int $czcionka			
   */		
	public function setCzcionka($czcionka){
		if(!empty($czcionka)&&(is_int($czcionka))&&$czcionka>=0&&$czcionka<=5){
			$this->_czcionka=$czcionka;
		} else {
			trigger_error("setCzcionka: invalid czcionka ".$this->getNazwaKlasy(),E_USER_ERROR);			
		}
	}			
	

  /**
   * znakObr
   * @param int $znakObr			
   */		
	public function setZnakObr($znakObr){
		if(!empty($znakObr)&&(is_int($znakObr))&&$znakObr>=0&&$znakObr<45){
			$this->_znakObr=$znakObr;
		} else {
			trigger_error("setZnakObr: invalid znakObr ".$this->getNazwaKlasy(),E_USER_ERROR);			
		}
	}			
		
	
	
  /**
   * margines
   * @param int $margines			
   */		
	public function setMargines($margines){
		if(!empty($margines)&&(is_int($margines))&&$margines>=0&&$margines<50){
			$this->_margines=$margines;
		} else {
			trigger_error("setMargines: invalid margines ".$this->getNazwaKlasy(),E_USER_ERROR);			
		}
	}				

	
  /**
   * tlo
   * @param array $tlo			
   */		
	public function setTlo($tlo){
		if(!empty($tlo)){
			if(is_array($tlo)){
				for($i=0;$i<3;$i++){
					if(isset($tlo[$i])&&is_int($tlo[$i])&&$tlo[$i]>=0&&$tlo[$i]<=255){
						$this->_tlo[$i]=$tlo[$i];
					}	
				}
			} else {
				trigger_error("setTlo: invalid tlo  ".$this->getNazwaKlasy(),E_USER_ERROR);			
			}
		}
	}					

	
  /**
   * imgTlo
   * @param int $imgTlo			
   */		
	
	public function setImgTlo($imgTlo){	
		if(!empty($imgTlo)&&is_string($imgTlo)){
			if(is_file($imgTlo)){
				$this->_imgTlo=$imgTlo;
			} else {
				trigger_error("setImgTlo: invalid imgTlo  ".$this->getNazwaKlasy(),E_USER_ERROR);			
			}
		}
	}				
	

	
  /**
   * imgTlo2
   * @param int $imgTlo2			
   */		
	public function setImgTlo2($imgTlo2){
		if(!empty($imgTlo2)&&is_string($imgTlo2)){
			if(is_file($imgTlo2)){
				$this->_imgTlo2=$imgTlo2;
			} else {
				trigger_error("setImgTlo2: invalid imgTlo2 ".$this->getNazwaKlasy(),E_USER_ERROR);			
			}
		}
	}					
	

  /**
   * znakKolor - tablica losowo
   * @param array $znakKolor			
   */		
	public function setZnakKolor($znakKolor){
		if(!empty($znakKolor)){
			if(is_array($znakKolor)){
			
				$this->_znakKolor=array();
			
				while(list($key,$val)=each($znakKolor)){
					if(is_array($val)){
						for($i=0;$i<3;$i++){
							if(isset($val[$i])&&is_int($val[$i])&&$val[$i]>=0&&$val[$i]<=255){
								$this->_znakKolor[$key][$i]=$val[$i];
							}	else {
								$this->_znakKolor[$key][$i]=0;							
							}
						}
					} else {
						trigger_error("setZnakKolor: invalid znakKolor ".$this->getNazwaKlasy(),E_USER_ERROR);							
					}
				}					
			} else {
				trigger_error("setZnakKolor: invalid znakKolor ".$this->getNazwaKlasy(),E_USER_ERROR);			
			}
		}
	}						


  /**
   * imgQuality
   * @param int $imgQuality			
   */		

	public function setImgQuality($imgQuality){
		if(!empty($imgQuality)&&is_int($imgQuality)&&$imgQuality>=0&&$imgQuality<=100){
			$this->_imgQuality=$imgQuality;
		} else {
			trigger_error("setImgQuality: invalid imgQuality ".$this->getNazwaKlasy(),E_USER_ERROR);			
		}
	}				

	
  /**
   * plikTTF
   * @param int $plikTTF			
   */		
	public function setPlikTTF($plikTTF){
		if(!empty($plikTTF)&&is_string($plikTTF)){
			if(is_file($plikTTF)){
				$this->_plikTTF=$plikTTF;
			} else {
				trigger_error("setplikTTF: invalid plikTTF ".$this->getNazwaKlasy(),E_USER_ERROR);			
			}
		}
	}			

	
  /**
   * linie
   * @param int $linie			
   */		
	public function setLinie($linie){
		if(!empty($linie)&&is_int($linie)&&$linie>=0&&$linie<100){
			$this->_linie=$linie;
		} else {
			trigger_error("setLinie: invalid linie ".$this->getNazwaKlasy(),E_USER_ERROR);			
		}
	}				
	
	
  /**
   * linieKolor
   * @param array $linieKolor			
   */		
	public function setLinieKolor($linieKolor){
		if(!empty($linieKolor)){
			if(is_array($linieKolor)){
			
				$this->_linieKolor=array();
			
				while(list($key,$val)=each($linieKolor)){
					if(is_array($val)){
						for($i=0;$i<3;$i++){
							if(isset($val[$i])&&is_int($val[$i])&&$val[$i]>=0&&$val[$i]<=255){
								$this->_linieKolor[$key][$i]=$val[$i];
							}	else {
								$this->_linieKolor[$key][$i]=255;							
							}
						}
					} else {
						trigger_error("setLinieKolor: invalid linieKolor ".$this->getNazwaKlasy(),E_USER_ERROR);							
					}
				}					
			} else {
				trigger_error("setLinieKolor: invalid linieKolor ".$this->getNazwaKlasy(),E_USER_ERROR);			
			}
		}
	}		
	
	/**
	 * sprawdz poprawnosc kodu
	 * @return boolean
	 */
	public function sprKod($kod) {
	
		$ok=false;

		if(!empty($kod)){
		
		  $kod=strtoupper($kod);
				
			if(md5($this->_md5prefix.$kod)==$this->_gKodHash){
				$ok=true;
			}
		}

		return $ok;
		
	}		

	/**
	 * Generate kod
	 * @return string
	 */
	public function generujKod() {
	
	  $kod="";

	  $digits="0123456789";
	  $chars="abcdefghijklmnopqrstuvwxyz";

	  $charsArray="";
		
	  if ($this->_cyfry) {
	  	$charsArray.=$digits;
	  }
		
	  if ($this->_litery) {
	    $charsArray.=$chars;
	  }
		
	  if ($this->_duze) {
	    $charsArray=strtoupper($charsArray);
	  } else {
	    $charsArray.=strtoupper($charsArray);		
		}

	  if (!empty($this->_pomin)) {
	    for ($i=0;$i<strlen($this->_pomin);$i++) {
	    	$charsArray=str_replace($this->_pomin[$i], "", $charsArray);
	    }
	  }

		if (!empty($charsArray)) {
		 for ($i=1;$i<=$this->_ileZnakow;$i++) {
		   $kod.=$charsArray[rand(0,strlen($charsArray)-1)];
		 }
		}

		$this->_gKod=$kod;

		$encrypt = new encryptMd5();
		$this->_gKodEncrypt=$encrypt->encrypt($this->_gKod, $this->_md5prefix);

		$this->_gKodHash=md5($this->_md5prefix.strtoupper($this->_gKod));
		
	}
	
	
	/**
	 * oblicza rozmiary obrazka
	 */	
	public function obrazekRozmiary(){
	
		//dla ttf pomiar rozmiarow
    if ($this->_plikTTF) {

	    if (function_exists("ImageCreateTrueColor")) {
	       $temp=ImageCreateTrueColor(1, 1);
	    } else if (function_exists("ImageCreate")) {
	       $temp=ImageCreate(1, 1);
	    }
			
	    $color=ImageColorAllocate($temp, 0,0,0);
	    $box=ImageTTFText($temp, $this->_rozmiar, 0, 0, 0, $color, $this->_plikTTF, "W");

	    $this->_fontHeight=abs($box[5]-$box[3]); // delta Y

	    // sum of chars width
	    $this->_znakiTTFwidth=array();
	    for ($i=1;$i<=$this->_ileZnakow;$i++) {
	      $angle=0;
	      if ($this->_znakObr>0) {
	         $angle=rand(0, ($this->_znakObr*2))-$this->_znakObr;
	      }
	      $box=ImageTTFText($temp, $this->_rozmiar, $angle, 0, 0, $color, $this->_plikTTF, $this->_gKod[$i-1]);
	      $TTFwidth=($box[2]-$box[0]);
	      $this->_znakiTTFwidth[$i]=array("angle" => $angle, "width" => $TTFwidth);
	      $this->_ImageWidth+=($TTFwidth);
	    }
	    ImageDestroy($temp);

	    $this->_ImageWidth+=($this->_ileZnakow*($this->_znakPadding*2))+($this->_margines*2);

		//pomiar rozmiarow bez ttf
    } else {

			$this->_fontWidth=ImageFontWidth($this->_rozmiar);
			$this->_fontHeight=ImageFontHeight($this->_rozmiar);

			$this->_ImageWidth=(($this->_fontWidth+(2*$this->_znakPadding))*$this->_ileZnakow)+($this->_margines*2);

		}

    $this->_ImageHeight=($this->_fontHeight)+($this->_margines*2);	
				
	}
	
	
	/**
	 * dodaje obrazek tla - losowo przesuniety
   * @param string $img				
	 */		
	public function obrazekImg($img){
	
		if(!empty($img)){
	
			$size=GetImageSize($img);
			
			if(($size[2]==2||$size[2]==3)&&!empty($size[0])&&!empty($size[1])){

				if($size[2]==2){
					$input=ImageCreateFromJPEG($img); 			
				} else { 
					$input=ImageCreateFromPNG($img); 
				}	
				
				$sourceX=rand(0,abs($size[0]-$this->_ImageWidth)-1);
				$sourceY=rand(0,abs($size[1]-$this->_ImageHeight)-1);
				
				ImageCopy($this->_output, $input, 0,0, $sourceX,$sourceY, $this->_ImageWidth,$this->_ImageHeight);					
				
				imagedestroy($input);
				
			}	
		}
	}
	
	
	/**
	 * dodaje losowe linie
	 */			
	public function obrazekLinie(){
    if ($this->_linie) {
    	for ($i=1;$i<=$this->_linie;$i++) {
	
	    	$random=rand(0,count($this->_linieKolor)-1);
	      $color=ImageColorAllocate($this->_output, $this->_linieKolor[$random][0],$this->_linieKolor[$random][1],$this->_linieKolor[$random][2]);	
	      ImageLine($this->_output, rand(0,$this->_ImageWidth-1), rand(0,$this->_ImageHeight-1), rand(0,$this->_ImageWidth-1), rand(0,$this->_ImageHeight-1), $color);

      }
    }	
	}
	
	
	/**
	 * rysuje tekst
	 */			
	public function imageTekst(){	
		//ttf
    if ($this->_plikTTF) {

      $x=$this->_margines+$this->_znakPadding;
      $y=$this->_margines+$this->_fontHeight;
      for ($i=1;$i<=$this->_ileZnakow;$i++) {

        $random=rand(0,count($this->_znakKolor)-1);
        $color=ImageColorAllocate($this->_output, $this->_znakKolor[$random][0],$this->_znakKolor[$random][1],$this->_znakKolor[$random][2]);

        $box=ImageTTFText($this->_output, $this->_rozmiar, $this->_znakiTTFwidth[$i]["angle"], $x, $y, $color, $this->_plikTTF, $this->_gKod[$i-1]);
        $x+=$this->_znakiTTFwidth[$i]["width"]+($this->_znakPadding*2);
      }
			
		//czcionka systemowa
    } else {
		
      for ($i=1;$i<=$this->_ileZnakow;$i++) {

       $random=rand(0,count($this->_znakKolor)-1);
       $color=ImageColorAllocate($this->_output, $this->_znakKolor[$random][0],$this->_znakKolor[$random][1],$this->_znakKolor[$random][2]);

       $x=$this->_margines+(($this->_fontWidth+(2*$this->_znakPadding))*($i-1))+$this->_znakPadding;
       $y=$this->_margines;
       ImageString($this->_output, $this->_czcionka, $x, $y, $this->_gKod[$i-1], $color);
				
      }
			
    }
	}	
	

	/**
	 * generuje obrazek
	 * @return image
	 */
	public function obrazek() {
		
		$this->obrazekRozmiary();
									
		//stworz obrazek
    if (function_exists("ImageCreateTrueColor")) {
      $this->_output=ImageCreateTrueColor($this->_ImageWidth, $this->_ImageHeight);
    } else if (function_exists("ImageCreate")) {
    	$this->_output=ImageCreate($this->_ImageWidth, $this->_ImageHeight);
    }

    // kolor tla
    $color=ImageColorAllocate($this->_output, $this->_tlo[0], $this->_tlo[1], $this->_tlo[2]);
    ImageFill($this->_output, 0, 0, $color);

		// obrazek tla
		$this->obrazekImg($this->_imgTlo);

    // linie
		$this->obrazekLinie();
		
    // tekst
		$this->imageTekst();

    // tlo 2
		$this->obrazekImg($this->_imgTlo2);
		
		// wyswietl
		
		
		if (!headers_sent()) {
			$FileMD5=md5(time()*time()*time());
			@Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			@Header("Last-Modified: ".gmdate("D, d M Y H:i:s", time()-3600 )." GMT");
			@Header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
			@Header("Cache-Control: post-check=0, pre-check=0", false);
			@Header("Pragma: no-cache"); // HTTP/1.0
			@Header("Content-type: image/jpeg");
			@Header("Content-disposition: filename=\"".$FileMD5.".jpg\"");
			ImageJPEG($this->_output,"",$this->_imgQuality);
		}
		
		
		// usuwamy z pamieci
		ImageDestroy($this->_output);
		
	}


  /**
   * konstruktor php5
   * @param string $_md5prefix
   */			
	public function __construct($_md5prefix="") {	
		if(!empty($_md5prefix)){
			$this->setMd5prefix($_md5prefix);
		}
  }	

}

?>