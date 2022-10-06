<?php

/**
 * TekstForm class v1.0
 * dla CMS i innych klas - formatowanie tekstow.
 * All rights reserved
 * @package TekstForm class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2006 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  include ("class.tekstform.php");
	
	echo tekstForm::zlamStringa("gfhdfghgfhgf",45);	
	
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

	
class tekstForm {

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */

	/**
	 * Public methods
	 */

  /**
   * zwraca wyrazenie regularne
   * @return string				
   */		
	public static function getWwwForma(){
		return "^http[s]*:\/\/[a-zA-Z0-9][a-zA-Z0-9_\-]*[\.][a-zA-Z0-9_\+~\/\?,&%()=\#@%:\.\!'\-;]+[a-zA-Z0-9\(\)=\/#;]$";
	}	
		
		
  /**
   * zwraca wyrazenie regularne
   * @return string				
   */		
	public static function getEmailForma(){
		return "^(?:(?:\w\-*)+\.?)*\w+@(?:(?:\w\-*)+\.)+\w{1,4}$";
		//return "^(^([!#\$%&'\*\+\.0-9=?A-Z\^_`a-z{|}~-])+@([!#\$%&'\*\+0-9=?A-Z\^_`a-z{|}~-]+\.)+[a-zA-Z0-9]{1,4}$";
	}	
			
	
  /**
   * oczyszczamy tekst
   * @param string $tekst
   * @param bool $usun_tagi
   * @param string $zostaw_tagi		
   * @param bool $obetnij				
   * @return string	
   */		
	public static function oczysc($tekst,$usun_tagi=false,$zostaw_tagi="",$obetnij=true){
	
	  if(is_array($tekst)){ 
		
			reset($tekst);
	  	while (list($key,$val)=each($tekst)){
	    	$tekst[$key]=tekstForm::oczysc($val,$usun_tagi,$zostaw_tagi,$obetnij);
			}
			
	  } else { 	
		
			if($obetnij){
				$tekst=trim($tekst);
			}
			
			if($usun_tagi){ 
				$tekst=strip_tags($tekst,$zostaw_tagi); 
			}
			
		} 

		return $tekst;
		
	}	
	
	
  /**
   * sprawdza poprawnosc daty
   * @param string $data	
   * @return string	
   */		
	public static function sprDate($data){

		if(!checkdate(substr($data,5,2),substr($data,8,2),substr($data,0,4))){ 
			$data=""; 
		}
		
		return $data;
	}	
	
	
  /**
   * sprawdza czy spelnia warune dat
   * @param string $data_start		
   * @param string $data_stop		
   * @param string $data			
   * @param string $format		
   * @return bool	
   */		
	public static function czyAktywne($data_start,$data_stop,$data,$format="Y-m-d H:i:s"){

		if(empty($data)){
			$data=date($format);
		}
		
		$ok=true;
		
		if(tekstForm::niepuste($data_start)&&$data<$data_start){
			$ok=false;
		} else if(tekstForm::niepuste($data_stop)&&$data>$data_stop){
			$ok=false;
		}
						
		return $ok;
		
	}		
		

  /**
   * oczyszczamy tekst z polskich znakow
   * @param string $tekst		
   * @return string	
   */			
	public static function usunPl($tekst) {
		$tekst=str_replace(array("ą","ć","ę","ł","ń","ó","ś","ż","ź","Ą","Ć","Ę","Ł","Ń","Ó","Ź","Ż","Ź","ä","ë","ö","ü","ß","Ä","Ë","Ö","Ü"),array("a","c","e","l","n","o","s","z","z","A","C","E","L","N","O","S","Z","Z","a","e","o","u","B","A","E","O","U"),$tekst);
		return $tekst;
	}	
	
	
	/**
	 * UTF-8 Case lookup table		
	 *
	 * This lookuptable defines the upper case letters to their correspponding
	 * lower case letter in UTF-8
	 *
	 *@return array 	
	 *@author Andreas Gohr <andi@splitbrain.org>
	 */	
	public static function getUtf8LowerToUpper(){
		return array(
		  0x0061=>0x0041, 0x03C6=>0x03A6, 0x0163=>0x0162, 0x00E5=>0x00C5, 0x0062=>0x0042,
		  0x013A=>0x0139, 0x00E1=>0x00C1, 0x0142=>0x0141, 0x03CD=>0x038E, 0x0101=>0x0100,
		  0x0491=>0x0490, 0x03B4=>0x0394, 0x015B=>0x015A, 0x0064=>0x0044, 0x03B3=>0x0393,
		  0x00F4=>0x00D4, 0x044A=>0x042A, 0x0439=>0x0419, 0x0113=>0x0112, 0x043C=>0x041C,
		  0x015F=>0x015E, 0x0144=>0x0143, 0x00EE=>0x00CE, 0x045E=>0x040E, 0x044F=>0x042F,
		  0x03BA=>0x039A, 0x0155=>0x0154, 0x0069=>0x0049, 0x0073=>0x0053, 0x1E1F=>0x1E1E,
		  0x0135=>0x0134, 0x0447=>0x0427, 0x03C0=>0x03A0, 0x0438=>0x0418, 0x00F3=>0x00D3,
		  0x0440=>0x0420, 0x0454=>0x0404, 0x0435=>0x0415, 0x0449=>0x0429, 0x014B=>0x014A,
		  0x0431=>0x0411, 0x0459=>0x0409, 0x1E03=>0x1E02, 0x00F6=>0x00D6, 0x00F9=>0x00D9,
		  0x006E=>0x004E, 0x0451=>0x0401, 0x03C4=>0x03A4, 0x0443=>0x0423, 0x015D=>0x015C,
		  0x0453=>0x0403, 0x03C8=>0x03A8, 0x0159=>0x0158, 0x0067=>0x0047, 0x00E4=>0x00C4,
		  0x03AC=>0x0386, 0x03AE=>0x0389, 0x0167=>0x0166, 0x03BE=>0x039E, 0x0165=>0x0164,
		  0x0117=>0x0116, 0x0109=>0x0108, 0x0076=>0x0056, 0x00FE=>0x00DE, 0x0157=>0x0156,
		  0x00FA=>0x00DA, 0x1E61=>0x1E60, 0x1E83=>0x1E82, 0x00E2=>0x00C2, 0x0119=>0x0118,
		  0x0146=>0x0145, 0x0070=>0x0050, 0x0151=>0x0150, 0x044E=>0x042E, 0x0129=>0x0128,
		  0x03C7=>0x03A7, 0x013E=>0x013D, 0x0442=>0x0422, 0x007A=>0x005A, 0x0448=>0x0428,
		  0x03C1=>0x03A1, 0x1E81=>0x1E80, 0x016D=>0x016C, 0x00F5=>0x00D5, 0x0075=>0x0055,
		  0x0177=>0x0176, 0x00FC=>0x00DC, 0x1E57=>0x1E56, 0x03C3=>0x03A3, 0x043A=>0x041A,
		  0x006D=>0x004D, 0x016B=>0x016A, 0x0171=>0x0170, 0x0444=>0x0424, 0x00EC=>0x00CC,
		  0x0169=>0x0168, 0x03BF=>0x039F, 0x006B=>0x004B, 0x00F2=>0x00D2, 0x00E0=>0x00C0,
		  0x0434=>0x0414, 0x03C9=>0x03A9, 0x1E6B=>0x1E6A, 0x00E3=>0x00C3, 0x044D=>0x042D,
		  0x0436=>0x0416, 0x01A1=>0x01A0, 0x010D=>0x010C, 0x011D=>0x011C, 0x00F0=>0x00D0,
		  0x013C=>0x013B, 0x045F=>0x040F, 0x045A=>0x040A, 0x00E8=>0x00C8, 0x03C5=>0x03A5,
		  0x0066=>0x0046, 0x00FD=>0x00DD, 0x0063=>0x0043, 0x021B=>0x021A, 0x00EA=>0x00CA,
		  0x03B9=>0x0399, 0x017A=>0x0179, 0x00EF=>0x00CF, 0x01B0=>0x01AF, 0x0065=>0x0045,
		  0x03BB=>0x039B, 0x03B8=>0x0398, 0x03BC=>0x039C, 0x045C=>0x040C, 0x043F=>0x041F,
		  0x044C=>0x042C, 0x00FE=>0x00DE, 0x00F0=>0x00D0, 0x1EF3=>0x1EF2, 0x0068=>0x0048,
		  0x00EB=>0x00CB, 0x0111=>0x0110, 0x0433=>0x0413, 0x012F=>0x012E, 0x00E6=>0x00C6,
		  0x0078=>0x0058, 0x0161=>0x0160, 0x016F=>0x016E, 0x03B1=>0x0391, 0x0457=>0x0407,
		  0x0173=>0x0172, 0x00FF=>0x0178, 0x006F=>0x004F, 0x043B=>0x041B, 0x03B5=>0x0395,
		  0x0445=>0x0425, 0x0121=>0x0120, 0x017E=>0x017D, 0x017C=>0x017B, 0x03B6=>0x0396,
		  0x03B2=>0x0392, 0x03AD=>0x0388, 0x1E85=>0x1E84, 0x0175=>0x0174, 0x0071=>0x0051,
		  0x0437=>0x0417, 0x1E0B=>0x1E0A, 0x0148=>0x0147, 0x0105=>0x0104, 0x0458=>0x0408,
		  0x014D=>0x014C, 0x00ED=>0x00CD, 0x0079=>0x0059, 0x010B=>0x010A, 0x03CE=>0x038F,
		  0x0072=>0x0052, 0x0430=>0x0410, 0x0455=>0x0405, 0x0452=>0x0402, 0x0127=>0x0126,
		  0x0137=>0x0136, 0x012B=>0x012A, 0x03AF=>0x038A, 0x044B=>0x042B, 0x006C=>0x004C,
		  0x03B7=>0x0397, 0x0125=>0x0124, 0x0219=>0x0218, 0x00FB=>0x00DB, 0x011F=>0x011E,
		  0x043E=>0x041E, 0x1E41=>0x1E40, 0x03BD=>0x039D, 0x0107=>0x0106, 0x03CB=>0x03AB,
		  0x0446=>0x0426, 0x00FE=>0x00DE, 0x00E7=>0x00C7, 0x03CA=>0x03AA, 0x0441=>0x0421,
		  0x0432=>0x0412, 0x010F=>0x010E, 0x00F8=>0x00D8, 0x0077=>0x0057, 0x011B=>0x011A,
		  0x0074=>0x0054, 0x006A=>0x004A, 0x045B=>0x040B, 0x0456=>0x0406, 0x0103=>0x0102,
		  0x03BB=>0x039B, 0x00F1=>0x00D1, 0x043D=>0x041D, 0x03CC=>0x038C, 0x00E9=>0x00C9,
		  0x00F0=>0x00D0, 0x0457=>0x0407, 0x0123=>0x0122,
		);
	}
	
	
	/**
	 * Translates a character position into an 'absolute' byte position.
	 * Unit tested by Kasper.
	 * (http://phpxref.com/xref/moodle/lib/typo3/class.t3lib_cs.php.source.html.gz)
	 *
	 * @param    string        UTF-8 string
	 * @param    integer        Character position (negative values start from the end)
	 * @return    integer        Byte position
	 * @author    Martin Kutschker <martin.t.kutschker@blackbox.net>
	 */
  public static function utf8Char2bytePos($str,$pos)    {
    $n = 0;                // number of characters found
    $p = abs($pos);        // number of characters wanted
  
    if ($pos >= 0)    {
      $i = 0;
      $d = 1;
    } else {
      $i = strlen($str)-1;
      $d = -1;
    }
  
    for( ; isset($str{$i})&&strlen($str{$i}) && $n<$p; $i+=$d)    {
      $c = (int)ord($str{$i});
      if (!($c & 0x80))    // single-byte (0xxxxxx)
        $n++;
      elseif (($c & 0xC0) == 0xC0)    // multi-byte starting byte (11xxxxxx)
        $n++;
    }
    if (isset($str{$i})&&!strlen($str{$i}))    return false; // offset beyond string length
  
    if ($pos >= 0)    {
      // skip trailing multi-byte data bytes
			if(isset($str{$i})){
	      while ((ord($str{$i}) & 0x80) && !(ord($str{$i}) & 0x40)) { $i++; }
			}
    } else {
      // correct offset
      $i++;
    }
  
    return $i;
  }


	/**
	 * Returns a part of a UTF-8 string.
	 * Unit-tested by Kasper and works 100% like substr() / mb_substr() for full range of $start/$len
	 * (http://phpxref.com/xref/moodle/lib/typo3/class.t3lib_cs.php.source.html.gz)
	 *
	 * @param    string        UTF-8 string
	 * @param    integer        Start position (character position)
	 * @param    integer        Length (in characters)
	 * @return    string        The substring
	 * @see substr()
	 * @author    Martin Kutschker <martin.t.kutschker@blackbox.net>
	 */
  public static function utf8Substr($str,$start,$len=null) {
	
		if(function_exists("mb_substr")){
		
			return mb_substr($str,$start,$len);
			
		} else {
	
    if (!strcmp($len,'0'))    return '';
  
	    $byte_start = @tekstForm::utf8Char2bytePos($str,$start);
	    if ($byte_start === false)    {
	      if ($start > 0)    {
	        return false;    // $start outside string length
	      } else {
	        $start = 0;
	      }
	    }
	  
	    $str = substr($str,$byte_start);
	  
	    if ($len!=null)    {
	      $byte_end = @tekstForm::utf8Char2bytePos($str,$len);
	      if ($byte_end === false)    // $len outside actual string length
	        return $len<0 ? '' : $str;    // When length is less than zero and exceeds, then we return blank string.
	      else
	        return substr($str,0,$byte_end);
	    }
	    else    return $str;
		}
		
  }
	
	
	/**
	 * Counts the number of characters of a string in UTF-8.
	 * Unit-tested by Kasper and works 100% like strlen() / mb_strlen()
	 *
	 * @param    string        UTF-8 multibyte character string
	 * @return    integer        The number of characters
	 * @see strlen()
	 * @author    Martin Kutschker <martin.t.kutschker@blackbox.net>
	 */
  public static function utf8Strlen($str)    {
	
		if(function_exists("mb_strlen")){
		
			return mb_strlen($str);
			
		} else {
			
	    $n=0;
	    for($i=0; isset($str{$i}) && strlen($str{$i})>0; $i++)    {
	      $c = ord($str{$i});
	      if (!($c & 0x80))    // single-byte (0xxxxxx)
	        $n++;
	      elseif (($c & 0xC0) == 0xC0)    // multi-byte starting byte (11xxxxxx)
	        $n++;
	    }
	    return $n;
		}
		
  }


  /**
   * strtolower utf8
   * @param string $pstring
	 * @return string
   */	
	public static function male($string){

	  if(function_exists('mb_strtolower')){
		
	    return mb_strtolower($string);
			
		} else {
		
			$UTF8_LOWER_TO_UPPER=@array_flip(tekstForm::getUtf8LowerToUpper());
			
		  $uni = tekstForm::utf8ToUnicode($string); 
		  for ($i=0; $i < count($uni); $i++){
				if(isset($UTF8_LOWER_TO_UPPER[$uni[$i]])){			
			  	$uni[$i] = $UTF8_LOWER_TO_UPPER[$uni[$i]];
				}
		  }
		  return tekstForm::unicodeToUtf8($uni);
		}

	}
	
	
  /**
   * strtoupper utf8
   * @param string $pstring
	 * @return string
   */		
	public static function duze($string){
	
	  if(function_exists('mb_strtolower')){
		
	    return mb_strtoupper($string);
			
		} else {
		
			$UTF8_LOWER_TO_UPPER=tekstForm::getUtf8LowerToUpper();		

		  $uni = tekstForm::utf8ToUnicode($string);
		  for ($i=0; $i < count($uni); $i++){
				if(isset($UTF8_LOWER_TO_UPPER[$uni[$i]])){
		    	$uni[$i] =$UTF8_LOWER_TO_UPPER[$uni[$i]];
				}
		  }
		  return tekstForm::unicodeToUtf8($uni);
		}
	
	}	
	
	
  /**
   * strtoupper utf8
   * @param string $string
   * @param string $szuk
	 * @return int
   */		
	public static function utf8Strpos($string,$szuk){
	
	  if(function_exists('mb_strpos')){
		
	    return mb_strtoupper($string);
			
		} else {
		
		  return strpos($string,$szuk);
			
		}
	
	}	

	/**
	 * This public static function will any UTF-8 encoded text and return it as
	 * a list of Unicode values:
	 *
	 * @author Scott Michael Reynen <scott@randomchaos.com>
	 * @link   http://www.randomchaos.com/document.php?source=php_and_unicode
	 * @see    unicode_to_utf8()
	 */
	public static function utf8ToUnicode($str) {
	
	  $unicode = array();  
	  $values = array();
	  $lookingFor = 1;
	  
	  for ($i = 0; $i < strlen( $str ); $i++ ) {
	    $thisValue = ord( $str[ $i ] );
	    if ( $thisValue < 128 ) $unicode[] = $thisValue;
	    else {
	      if ( count( $values ) == 0 ) $lookingFor = ( $thisValue < 224 ) ? 2 : 3;
	      $values[] = $thisValue;
	      if ( count( $values ) == $lookingFor ) {
	  $number = ( $lookingFor == 3 ) ?
	    ( ( $values[0] % 16 ) * 4096 ) + ( ( $values[1] % 64 ) * 64 ) + ( $values[2] % 64 ):
	  	( ( $values[0] % 32 ) * 64 ) + ( $values[1] % 64 );
	  $unicode[] = $number;
	  $values = array();
	  $lookingFor = 1;
	      }
	    }
	  }
	  return $unicode;
	}

	
	/**
	 * This public static function will convert a Unicode array back to its UTF-8 representation
	 *
	 * @author Scott Michael Reynen <scott@randomchaos.com>
	 * @link   http://www.randomchaos.com/document.php?source=php_and_unicode
	 * @see    utf8_to_unicode()
	 */
	public static function unicodeToUtf8($str) {
	  $utf8 = '';
	  foreach( $str as $unicode ) {
	    if ( $unicode < 128 ) {
	      $utf8.= chr( $unicode );
	    } elseif ( $unicode < 2048 ) {
	      $utf8.= chr( 192 +  ( ( $unicode - ( $unicode % 64 ) ) / 64 ) );
	      $utf8.= chr( 128 + ( $unicode % 64 ) );
	    } else {
	      $utf8.= chr( 224 + ( ( $unicode - ( $unicode % 4096 ) ) / 4096 ) );
	      $utf8.= chr( 128 + ( ( ( $unicode % 4096 ) - ( $unicode % 64 ) ) / 64 ) );
	      $utf8.= chr( 128 + ( $unicode % 64 ) );
	    }
	  }
	  return $utf8;
	}	
	
	
  /**
   * przetwarzany tekst do SQL
   * @param string $tekst
   * @param bool $usun_tagi
   * @param string $zostaw_tagi		
   * @param bool $obetnij				
   * @return string	
   */		
	public static function doSql($tekst,$usun_tagi=true,$zostaw_tagi="",$obetnij=true){

	  if(is_array($tekst)){
		 
			reset($tekst);
	  	while (list($key,$val)=each($tekst)){
	    	$tekst[$key]=tekstForm::doSql($val,$usun_tagi,$zostaw_tagi,$obetnij);
			}
		  reset($tekst);
			
	  } else { 	
		
			$tekst=tekstForm::oczysc($tekst,$usun_tagi,$zostaw_tagi,$obetnij);
		
			if(function_exists("mysqli_real_escape_string")){
				$tekst=konf::get()->_bazasql->real_escape_string($tekst);
			} else {
				$tekst=konf::get()->_bazasql->escape_string($tekst);		
			}
			
		} 	

		return $tekst;
		
	}
	
	
	
  /**
   * przetwarzany tekst do SQL LIKE
   * @param string $tekst	
   * @return string	
   */		
	public static function doLike($tekst){
	
		$tekst=tekstForm::doSql($tekst,true,"",true);		
		$tekst=addslashes($tekst);

		return $tekst;
		
	}
		
		
  /**
   * przetwarzany tablice do SQL
   * @param array $tablica
   * @param array $dane		
   * @param string $znak			
   * @return string	
   */			
	public static function paramZlacz($tablica,$dane,$znak="|"){
	
	  $wynik="";
		
	  if(!empty($dane)&&is_array($dane)&&!empty($tablica)&&is_array($tablica)){
	    reset($dane);
	    while(list($key,$val)=each($dane)){
	      if($val!=''&&isset($tablica[$val])){ 
					$wynik.=$val."|"; 
				}
	    }
	  }
	  
	  if(!empty($wynik)){ 
	    $wynik="|".$wynik; 
	  } 
		
	  return $wynik; 
		
	}  	
	
	
  /**
   * przetwarzany tekst jako liczbe
   * @param string $tekst
   * @param int $po_przecinku		
   * @param bool $zaokraglaj				
   * @param bool $ujemne			
   * @return string	
   */		
	public static function doLiczba($tekst,$po_przecinku="",$zaokraglaj=false,$ujemne=false){
	
		$tekst=str_replace(",",".",$tekst);
		$tekst=$tekst+0;
	
		if(!$ujemne&&$tekst<0){
			$tekst=0;
		}
		
		if($zaokraglaj&&is_int($po_przecinku)){
			$tekst=round($tekst,$po_przecinku);
		} else if(!$po_przecinku) {
			$tekst=floor($tekst);
		}

		return $tekst;
		
	}			
	
		
  /**
   * przetwarzany tekst do wyswietlania
   * @param string $tekst
   * @param bool $usun_tagi
   * @param string $zostaw_tagi		
   * @param bool $obetnij				
   * @return string	
   */		
	public static function doWys($tekst,$usun_tagi=false,$zostaw_tagi="",$obetnij=false){
	
	  if(is_array($tekst)){
		 
			reset($tekst);
	  	while (list($key,$val)=each($tekst)){
	    	$tekst[$key]=tekstForm::doWys($val,$usun_tagi,$zostaw_tagi,$obetnij);
			}
		  reset($tekst);
			
	  } else { 	
		
			$tekst=tekstForm::oczysc($tekst,$usun_tagi,$zostaw_tagi,$obetnij);
			$tekst=tekstForm::oczysc($tekst,$usun_tagi,$zostaw_tagi,$obetnij);	
			$tekst=nl2br($tekst);
		
		} 		

		return $tekst;
		
	}	
	
	
  /**
   * przetwarzany tekst do tooltip
   * @param string $tekst	
   * @return string	
   */		
	public static function doTooltip($tekst){	
		return $tekst=addslashes(str_replace(array("\"","\n","\r"),array("'","",""),$tekst));	
	}	
	
	
  /**
   * przetwarzany tekst do formularza
   * @param string $tekst
   * @param bool $usun_tagi
   * @param string $zostaw_tagi		
   * @param bool $obetnij				
   * @return string	
   */		
	public static function doForm($tekst,$usun_tagi=false,$zostaw_tagi="",$obetnij=false){
	
		if(is_array($tekst)){
		 
			reset($tekst);
	  	while (list($key,$val)=each($tekst)){
	    	$tekst[$key]=tekstForm::doForm($val,$usun_tagi,$zostaw_tagi,$obetnij);
			}
		  reset($tekst);
			
	  } else { 	
		
			$tekst=tekstForm::oczysc($tekst,$usun_tagi,$zostaw_tagi,$obetnij);	
			$tekst=htmlspecialchars($tekst);
		
		} 		

		return $tekst;
		
	}		
	
	
  /**
   * przetwarzany tekst do linku
   * @param string $tekst		
   * @return string	
   */		
	public static function doLink($tekst){	
		return rawurlencode($tekst);	
	}
	
	
  /**
   * lamanie ciagow zbyt dlugich znakow linkowanie email, www
   * @param string $tekst
   * @param int $max		
   * @param bool $br
   * @param bool $linkowac		
   * @param bool $ie				
   * @return string	
   */			
	public static function zlamStringa($tekst,$max=0,$br=true,$linkowac=true,$ie=true) {

	  if ($linkowac&&(!(strpos($tekst,"http")===false)||!(strpos($tekst,"https")===false))){
			$url=true; 
		}
		
	  if ($linkowac&&!((strpos($tekst,"@")===false))){
			$email=true; 
		}				

		// zamiana enterow  $tekst=str_replace("\r","",$tekst);
	  $tekst=str_replace("\n"," <br> ",$tekst);
		
	  // dzielenie na wyrazy
	 	$tekst_w_tabeli=split(" ",$tekst);

	  $nowy_tekst="";

		$ile_wyr=count($tekst_w_tabeli);
		
	  for ($i=0;$i<$ile_wyr;$i++) {
		
	    $tmp=$tekst_w_tabeli[$i];
			if(!empty($max)){
				$tekst_w_tabeli[$i]=wordwrap($tekst_w_tabeli[$i],$max,"<wbr />",1);
			}
			$tmp2=$tekst_w_tabeli[$i];

	    if (!empty($url)){
				$tekst_w_tabeli[$i]=preg_replace("/".tekstForm::getWwwForma()."/", "<a href=\"".$tmp."\" target=\"_blank\">".$tekst_w_tabeli[$i]."</a>", trim($tmp));
			}
			
	   	if(!empty($email)&&($tmp2==$tekst_w_tabeli[$i]||$tmp==$tekst_w_tabeli[$i])){ 
				$tekst_w_tabeli[$i]=preg_replace("/".tekstForm::getEmailForma()."/","<a href=\"mailto:".strtolower($tmp)."\">".$tekst_w_tabeli[$i]."</a>", trim($tmp));
			}
			
	    $nowy_tekst.=$tekst_w_tabeli[$i]." ";
		}
	 
		//usuwanie problemow lamania specyficznych stringow IE	
		if($ie){
			$nowy_tekst=str_replace(array(" :"," ;"," ,"," ?"," !"," ."," /"),array("<i>&nbsp;</i> :","<i>&nbsp;</i> ;","<i>&nbsp</i> ,","<i>&nbsp;</i> ?","<i>&nbsp;</i> !","<i>&nbsp;</i> .","<i>&nbsp;</i> /"),$nowy_tekst);
		}

		$nowy_tekst=str_replace("<br>","<br />",$nowy_tekst);
		
	  if (!$br){ 
			$nowy_tekst=str_replace(" <br /> ","\r\n",$nowy_tekst);
		}
	   
		return $nowy_tekst;
		
	}	
	
	
	
	public static function wrapWbr($tekst,$max=0){
	
		if($max){
			$tekst=wordwrap($tekst,$max,"​",1);
		}

		return $tekst;
	
	}
	

  /**
   * sprawdza get_magic_quotes i poprawia tekst
   * @param string/array $el
   * @return string	
   */		
	public static function gpcSpr($el) {
	  if(is_array($el)){ 
			reset($el);
	  	while (list($key,$val)=each($el)){
	    	$el[$key]=tekstForm::gpcSpr($val);
			}
		  reset($el);
	  } else { 	
			if (get_magic_quotes_gpc()){
				$el=stripslashes($el);
			}
		} 
		return $el;
	}
	
  /**
   * sprawdza get_magic_quotes i poprawia tekst
   * @param string/array $el
   * @return string	
   */		
	public static function gpcSprR($el) {
	  if(is_array($el)){ 
			reset($el);
	  	while (list($key,$val)=each($el)){
	    	$el[$key]=tekstForm::gpcSpr($val);
			}
		  reset($el);
	  } else { 	
			if (get_magic_quotes_gpc()){
				$el=addslashes($el);
			}
		} 
		return $el;
	}	
	
	
  /**
   * BB code
   * @param string $tekst
   * @param bool $linki
   * @param bool $html				
   * @param int $max_url_length
   * @return string	
   */			
	public static function bbForm($tekst,$linki=true,$html=true,$max_url_length=45){

		// AutoShortenURLs
		$url_meat = "\w\#$%&~/.\-;:=,_?@\(\)\[\]+";
		if($max_url_length>10){
			$prefix_length = $max_url_length-10;
		} else {
			$prefix_length = 10;		
		}

		// Patterns and replacements for URL and email tags..
		$patterns = array();
		$replacements = array();

		if($html){
			$tekst=str_replace(array("[b]","[/b]","[u]","[/u]","[i]","[/i]"),array("<b>","</b>","<u>","</u>","<i>","</i>"),$tekst);
		}
		
		if($linki){
		
			$suffix_length = $max_url_length - $prefix_length - 3; // -3 for "..." in the middle
			
			// [img]image_url_here[/img] code..
			$patterns[] = "#\[img\]([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#is";
			$replacements[] = '<a href="\\1" target="_blank">\\1</a>';

			// matches a [url]xxxx://www.phpbb.com[/url] code..
			$patterns[] = "#\[url\]([\w]+?://([".$url_meat."]+|\[(?!url=))*?)\[/url\]#is";
			$replacements[] = '<a href="\\1" target="_blank">\\1</a>';

			// [url]www.phpbb.com[/url] code.. (no xxxx:// prefix).
			$patterns[] = "#\[url\]((www|ftp)\.([".$url_meat."]+|\[(?!url=))*?)\[/url\]#is";
			$replacements[] = '<a href="\\1" target="_blank">\\1</a>';

			// [url=xxxx://www.phpbb.com]phpBB[/url] code..
			$patterns[] = "#\[url=([\w]+?://[".$url_meat."]*?)\]([^?\n\r\t].*?)\[/url\]#is";
			$replacements[] = '<a href="\\1" target="_blank">\\2</a>';

			// [url=www.phpbb.com]phpBB[/url] code.. (no xxxx:// prefix).
			$patterns[] = "#\[url=((www|ftp)\.[".$url_meat."]*?)\]([^?\n\r\t].*?)\[/url\]#is";
			$replacements[] = '<a href="\\1" target="_blank">\\3</a>';

			// [email]user@domain.tld[/email] code..
			$patterns[] = "#\[email\]([a-z0-9&\-_.]+?@[\w\-]+\.([\w\-\.]+\.)?[\w]+)\[/email\]#is";
			$replacements[] = '<a href="mailto:\\1" target="_blank">\\1</a>';
			
			
			// AutoShortenURLs	
			$patterns[] = "#<a href=\"([^?\n\r\t].*?)\" target=\"_blank\">([\w]+?://[" . $url_meat . "]{" . $prefix_length . "})([" . $url_meat . "]+)([" . $url_meat . "]{" . $suffix_length . "})</a>#is";
			$replacements[] = "<a href=\"\\1\" target=\"_blank\">\\2...\\4</a>";	
			// AutoShortenURLs _ END
			
			// matches an "xxxx://yyyy" URL at the start of a line, or after a space.
			// xxxx can only be alpha characters.
			// yyyy is anything up to the first space, newline, comma, double quote or <
			// AutoShortenURLs
			$suffix_length = $max_url_length - $prefix_length - 3; // -3 for "..." in the middle
			$patterns[] = "#(^|[\n ])([\w]+?://[" . $url_meat . "]{1," . $max_url_length . "})($|[^" . $url_meat . "])#is";
			$replacements[] = "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>\\3";
			$patterns[] = "#(^|[\n ])([\w]+?://[" . $url_meat . "]{" . $prefix_length . "})([" . $url_meat . "]+)([" . $url_meat . "]{" . $suffix_length . "})($|[^" . $url_meat . "])#is";
			$replacements[] = "\\1<a href=\"\\2\\3\\4\" target=\"_blank\">\\2...\\4</a>\\5";
			// AutoShortenURLs _ END
			
			// matches a "www|ftp.xxxx.yyyy[/zzzz]" kinda lazy URL thing
			// Must contain at least 2 dots. xxxx contains either alphanum, or "-"
			// zzzz is optional.. will contain everything up to the first space, newline, 
			// comma, double quote or <.
			// AutoShortenURLs
			$patterns[] = "#(^|[\n ])((www|ftp)\.[" . $url_meat . "]{1," . $max_url_length . "})($|[^" . $url_meat . "])#is";
			$replacements[] = "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>\\4";
			$patterns[] = "#(^|[\n ])((www|ftp)\.[" . $url_meat . "]{" . $prefix_length . "})([" . $url_meat . "]+)([" . $url_meat . "]{" . $suffix_length . "})($|[^" . $url_meat . "])#is";
			$replacements[] = "\\1<a href=\"http://\\2\\4\\5\" target=\"_blank\">\\2...\\5</a>\\6";
			// AutoShortenURLs _ END	
			
			// user@domain.tld code..
			$patterns[] = "#(^|[\n ])([a-z0-9&\-_.]+?@[\w\-]+\.([\w\-\.]+\.)?[\w]+)#is";
			$replacements[] = '\\1<a href="mailto:\\2" target="_blank">\\2</a>';		
			
			$tekst  = preg_replace($patterns, $replacements, $tekst);			
				
		}
		return $tekst;
	
	}
	
	
  /**
   * status GG
   * @param string $gg
   * @return string	
   */		
	public static function gg($gg){
		return $html="<a href=\"gg:".$gg."\"><img src=\"http://status.gadu-gadu.pl/users/status.asp?styl=1&amp;id=".$gg."\" border=\"0\" width=\"16\" height=\"16\" alt=\"".$gg."\" title=\"".$gg."\" style=\"vertical-align:text-top\" /></a>";
	}
	

  /**
   * status Skype
   * @param string $skype
	 * @param bool $js	
   * @return string	
   */		
	public static function skype($skype,$js=true){
		$html="";
		if($js){
			$html.="<script type=\"text/javascript\" src=\"http://download.skype.com/share/skypebuttons/js/skypeCheck.js\"></script>";
		}
		$html.="<a href=\"skype:".$skype."\"><img src=\"http://mystatus.skype.com/smallicon/".$skype."\" width=\"16\" height=\"16\" alt=\"".$skype."\" title=\"".$skype."\" style=\"vertical-align:text-top\" /></a>";
		
		return $html;
		
	}		

  /**
   * sprawdza poprawnosc GG i ICQ
   *
   * @param    string $numer
   * @return   string tekst po konwersji
   */	
	public static function komunikatorForm($numer) {
		$ok=false;
		
		if (preg_match("(^[0-9]{3,}$)",$numer)){
			$ok=true;
		}
		
		return $ok;
	
	}


  /**
   * formatuje adres url
   *
   * @param    string $adres
   * @return   string tekst po konwersji
   */	
	public static function linkPopraw($adres){

		if(!preg_match("/^\w+:\/\//",$adres)){ 
			$adres="http://".$adres; 
		}
		
		$dl=strlen($adres);
		if(substr($adres,$dl-1,$dl)=="/"){ 
			$adres=substr($adres,0,$dl-1); 
		}
		
		//sprawdza poprawnosc znakow
		if(!preg_match("/".tekstForm::getWwwForma()."/",$adres)){ 
			$adres=""; 
		}

		return $adres;
		
	}

	
  /**
   * formatuje na lamiace sie w IE
   *
   * @param    string $tekst
   * @return   string tekst po konwersji
   */	
	public static function literki($tekst){
		
		$tekst=str_replace(array(" i "," w "," a "," u "," z "," o "),array(" i&nbsp;"," w&nbsp;"," a&nbsp;"," u&nbsp;"," z&nbsp;"," o&nbsp;"),$tekst);

		return $tekst;
	}
	

  /**
   * oczyszcza ze znakow specjalnych
   *
   * @param    string $tekst
   * @param    string $znak		
   * @param    bool $dodatkowy
   * @return   string tekst po konwersji
   */	
	public static function podstawowy($tekst,$znak="",$dodatkowy=false){	
	
		$tekst=tekstForm::male($tekst);		
	  $tekst=tekstForm::usunPl($tekst);	
		$tekst=tekstForm::bezlinia($tekst);
		if($dodatkowy){
			$tekst=preg_replace('/[^a-zA-Z0-9\-_]/', $znak, $tekst);			
		} else {
			$tekst=preg_replace('/[^a-zA-Z0-9]/', $znak, $tekst);	
		}
		
		return $tekst;
								
	}	
	
	
  /**
   * oczyszcza ze znakow nowego wiersza
   *
   * @param    string $tekst
   * @return   string tekst po konwersji
   */	
	public static function bezlinia($tekst){	
	
		$tekst=str_replace(array("\\n","\\r","\n","\r"),array("","","",""),$tekst);
		
		return $tekst;
								
	}		
	
	

  /**
   * formatuje nazwe na bezpieczna dla url itp
   *
   * @param    string $tekst
   * @return   string tekst po konwersji
   */
  public static function tekstBezpieczny($tekst){	
	  $tekst = tekstForm::usunPl($tekst);
	  // inne znaki zamien na "_"
	  return preg_replace('/[^a-zA-Z0-9,._=\+\()\-]/', '_', $tekst);
  }	
	
	
  /**
   * zamienia tablice na string do mysql
   *
   * @param    string $tekst
   * @param    bool $liczba
   * @param    string $index
   * @return   string 
   */	
	public static function tabQuery($tab,$liczba=true,$index=""){

		$query="";
		
		if(is_array($tab)){
			while(list($key,$val)=each($tab)){
				if($index&&is_array($val)&&isset($val[$index])){
					$val=$val[$index];
				}
				if($liczba){
					$val=$val+0;				
				}			
				if($val!=''){
					if(!empty($query)){
						$query.=",";
					}
					$query.="'".tekstForm::doSql($val)."'";
				}
			}
		}

		return $query;
	}	
	
	
  /**
   * oblicza date +/- dni
   * @param int $dni
   * @param string $typ		
   * @param string $znak
   * @param string $format		
	 * @return string
   */		
	public static function dniData($limit,$typ="d",$znak="-",$format="Y-m-d H:i:s",$data=""){
	
		$limit=tekstForm::doLiczba($limit);

		if(empty($data)){
			$kiedy['d']=date("d");
			$kiedy['m']=date("m");		
			$kiedy['Y']=date("Y");
			$kiedy['G']=date("G");
			$kiedy['i']=date("i");		
			$kiedy['s']=date("s");	
		} else {
			$kiedy['d']=substr($data,8,2)+0;
			$kiedy['m']=substr($data,5,2)+0;		
			$kiedy['Y']=substr($data,0,4)+0;
			$kiedy['G']=substr($data,11,2)+0;
			$kiedy['i']=substr($data,14,2)+0;		
			$kiedy['s']=substr($data,17,2)+0;			
		}	
		
		if(isset($kiedy[$typ])){
			if($znak=="+"){
				$kiedy[$typ]+=$limit;
			} else {
				$kiedy[$typ]-=$limit;			
			}
		}

		return date($format,mktime($kiedy['G'],$kiedy['i'],$kiedy['s'],$kiedy['m'],$kiedy['d'],$kiedy['Y']));
		
	}	
	
	
  /**
   * sprawdza czy puste i zwraca domyslny jesli puste
   * @param string $tekst	
   * @param string $domyslny
	 * @return string
   */		
	public static function niepuste($wartosc,$domyslny=""){
	
		if(empty($wartosc)||preg_match('/^0\.(0)+$/',$wartosc)||$wartosc=="0000-00-00"||$wartosc=="0000-00-00 00:00:00"||$wartosc=="0000-00-00 00:00"){
			
			$wartosc=$domyslny;
		
		}
		
		return $wartosc;
	
	}		
	
	
  /**
   * oblicza ilosc lat na podstaeie daty urodzenia
   * @param string $tekst	
	 * @return string
   */		
	public static function wiek($data){
	
		$wiek="";
		
		if(!empty($data)){
		
			$data_dane=explode("-",$data);
			if(!empty($data_dane[0])&&!empty($data_dane[1])&&!empty($data_dane[2])){
			
				$data_dane[0]+=0;
				$data_dane[1]+=0;
				$data_dane[2]+=0;
				
				$data_dane2[0]=date('Y');
				$data_dane2[1]=date('n');
				$data_dane2[2]=date('j');
				
				$wiek=$data_dane2[0]-$data_dane[0];
				if($data_dane[1]<$data_dane2[1]||($data_dane[1]==$data_dane2[2]&&$data_dane[1]<$data_dane2[2])){
					$wiek--;
				}
				
				if($wiek<0){
					$wiek="";
				}
				
			}			
		
		}
		
		return $wiek;
	
	}			
		
  /**
   * oblicza microtime
   * @return int		
   */			
	public static function microtimeOblicz(){
	
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);	
		
	}		
		
	/**
   * class constructor php5	
   */	
	public function __construct() {	
		
  }	

	
}

?>