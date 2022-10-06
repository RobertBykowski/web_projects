<?php

/**
 * Galeria class v1.0
 * dla CMS i innych klas - formatowanie akapitu.
 * All rights reserved
 * @package Galeria class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2007 Waldemar Jonik
 */

	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

	
class galeria {

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */
		
	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="Galeria class";
	
	/**
	 * gallery type
	 */					
	private $_typ=0;
	
	/**
	 * galery title
	 */					
	private $_tytul="";	

	/**
	 * img align
	 */					
	private $_katalog="";			
		
	/**
	 * images cols
	 */					
	private $_kolumna=0;		
	
	/**
	 * images in row
	 */					
	private $_wiersz=4;			
	
	/**
	 * images in row
	 */					
	private $_zalezne=true;				
	
	/**
	 * autolink
	 */					
	private $_imageKlasa="";			
	
	/**
	 * subpage
	 */					
	private $_podstrona=1;		
	
	/**
	 * projektor width
	 */					
	private $_projektorW=700;			
	
	/**
	 * projektor height
	 */					
	private $_projektorH=700;				
		
	/**
	 * subpage name
	 */					
	private $_podstronaNazwa="podstrona";		
	
	/**
	 * fotka name
	 */					
	private $_fotkaNazwa="id_fotka";			
	
	/**
	 * kotwica
	 */					
	private $_kotwica="";				
	
	/**
	 * current image
	 */					
	private $_bierzace=0;				
	
	/**
	 * galery picture title field
	 */					
	private $_tytulPole="";			
	
	/**
	 * galery picture description field
	 */					
	private $_opisPole="";				
			
	/**
	 * dane przenies
	 */					
	private $_przenies=array();		

  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	function getNazwaKlasy(){
	
		return $this->_nazwaKlasy;
		
	}		
	
				
  /**
   * Set typ
   * @param int $typ
   */
  public function setTyp($typ) {

		$typ=$typ+0;

		if(is_int($typ)&&$typ>=0){
    	$this->_typ=$typ;
		} else {
			trigger_error("setTyp: invalid typ value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }				
	
	
  /**
   * Set dane
   * @param array $dane
   */
  public function setDane($dane) {

		if(!empty($dane)){
			if(is_array($dane)){
				$this->_dane=$dane;
			} else {
				trigger_error("setDane: invalid dane value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}		
		}
			
  }		
	
	
  /**
   * Set przenies
   * @param array $przenies
   */
  public function setPrzenies($przenies) {

		if(!empty($przenies)){
			if(is_array($przenies)){
				$this->_przenies=$przenies;
			} else {
				trigger_error("setDane: invalid przenies value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}		
		}
			
  }			
	
  /**
   * Set kolumna
   * @param array $kolumna
   */
  public function setKolumna($kolumna) {

		$kolumna=$kolumna+0;

		if(is_int($kolumna)&&$kolumna>=0){
    	$this->_kolumna=$kolumna;
		} else {
			trigger_error("setKolumna: invalid kolumna value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }				
	
	
  /**
   * Set wiersz
   * @param array $wiersz
   */
  public function setWiersz($wiersz) {

		$wiersz=$wiersz+0;

		if(is_int($wiersz)&&$wiersz>=0){
    	$this->_wiersz=$wiersz;
		} else {
			trigger_error("setwiersz: invalid wiersz value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }			

  /**
   * Set imageklasa
   * @param string $imageklasa
   */
  public function setImageKlasa($imageklasa) {

    $this->_imageKlasa=$imageklasa;

  }			
	
  /**
   * Set podstrona nazwa
   * @param string $podstronanazwa
   */
  public function setPodstronaNazwa($podstronanazwa) {

		if($podstronanazwa!=''){
			$this->_podstronaNazwa=$podstronanazwa;
		} else {
			trigger_error("setPodstronaNazwa: invalid podstronanazwa value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		

  }		
	
  /**
   * Set fotka nazwa
   * @param string $fotkanazwa
   */
  public function setfotkaNazwa($fotkanazwa) {

		if($fotkanazwa!=''){
			$this->_fotkaNazwa=$fotkanazwa;
		} else {
			trigger_error("setFotkaNazwa: invalid fotkanazwa value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		

  }				
					
  /**
   * Set tytul
   * @param string $tytul
   */
  public function setTytul($tytul) {

    $this->_tytul=$tytul;

  }			
	
  /**
   * Set katalog
   * @param string $katalog
   */
  public function setKatalog($katalog) {

		if($katalog!=''){
			$this->_katalog=$katalog;
		} else {
			trigger_error("setKatalog: invalid katalog value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		

  }	
	
  /**
   * Set tytuly zdjec
   * @param string $pole
   */
  public function setTytulyZdjec($pole) {

		if(empty($pole)){
			$this->_tytulPole="";
		} else {
			$this->_tytulPole=$pole;
		}		

  }		
	
	
  /**
   * Set opisy zdjec
   * @param string $pole
   */
  public function setOpisyZdjec($pole) {

		if(empty($pole)){
			$this->_opisPole="";
		} else {
			$this->_opisPole=$pole;
		}		

  }			
	
	
  /**
   * set kotwica
   * @param string $kotwica
   */		
	public function setKotwica($kotwica){
	
		if(!empty($kotwica)&&is_string($kotwica)){
			$this->_kotwica=$kotwica;
		} else {
			$this->_kotwica="";		
		}
		
	}		
	
	
  /**
   * set zalezne
   * @param bool $zalezne
   */		
	public function setZalezne($zalezne){
	
		if(empty($zalezne)){
			$this->_zalezne=false;
		} else {
			$this->_zalezne=true;		
		}
		
	}		
		
	
  /**
   * Set projektor size
   * @param int $w
   * @param int $h	
   */
  public function setProjektor($w,$h) {

		$w=$w+0;
		$h=$h+0;
		
		if(is_int($w)&&$w>=0){
    	$this->_projektorW=$w;
		}
		
		if(is_int($h)&&$h>=0){
    	$this->_projektorh=$h;
		}		
			
  }							
	
	
  /**
   * count subpage number and image number
   * @param int $na_str
   * @param int $wynikow		
   */	
	private function galeriaBierzace($na_str,$wynikow){
	
		$this->_bierzace=konf::get()->getZmienna($this->_fotkaNazwa,$this->_fotkaNazwa);
		$this->_podstrona=konf::get()->getZmienna($this->_podstronaNazwa,$this->_podstronaNazwa);		
		
		//oblicza numer podstrona na podstawie bierzacego zdjecia
		if($this->_bierzace&&!empty($na_str)){
		
			$numer=0;
		
			reset($this->_dane);
			
			while(list($key,$val)=each($this->_dane)){
				$numer++;
				if($this->_bierzace==$key){
					break;
				}
			}
			
			$this->_podstrona=ceil($numer/$na_str);
			
		}
		
		if(empty($this->_dane)){
			$this->_podstrona=1;
		}
		
	}		
	
	
	public function imgMale($dane){
	
		$html="";
		
		if(isset($dane['img2_nazwa'])&&$dane['img2_nazwa']!=""){
			$html.="<img src=\"".konf::get()->getKonfigTab("sciezka").$this->_katalog.$dane['img2_nazwa']."\" width=\"".$dane['img2_w']."\" height=\"".$dane['img2_h']."\" alt=\"";
			if(isset($dane[$this->_tytulPole])&&$dane[$this->_tytulPole]!=""){
				$html.=htmlspecialchars($dane[$this->_tytulPole]);
			}
			$html.="\"";
			if(isset($dane[$this->_tytulPole])&&$dane[$this->_tytulPole]!=""){
				$html.=" title=\"".htmlspecialchars($dane[$this->_tytulPole])."\"";
			}			
			$html.=" />";
		}
	
		return $html;
	
	}
	
	
  /**
   * wyswietla galerie
   */
  public function wyswietl() {

		//when data
		if(!empty($this->_dane)){
		
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),$this->_przenies);		
			
			//count subpages navigation
			$wynikow=count($this->_dane);		
			$na_str=$this->_kolumna*$this->_wiersz;
			if(empty($na_str)){
				$na_str=$wynikow;
			}
			$this->galeriaBierzAce($na_str,$wynikow);
			
			$naw = new nawig("",$this->_podstrona,$na_str);	
			$naw->setParametry($wynikow);	
			$naw->setKotwica($this->_kotwica);				
			$naw->setNazwa($this->_podstronaNazwa);						
			$naw->naw($link);
			
			//move data to current element
			reset($this->_dane);
			$start=$naw->getStart();
			for($i=0;$i<$start;$i++){
	  		next($this->_dane);
			}
			
			$ile=$naw->getile();							
			$j=0;					
			
			//draw subpages navigation
			$nawigacja="";
			$nawigacja.="<div class=\"nowa_l\" style=\"padding:3px\">";
      $nawigacja.=$naw->getNaw();
			$nawigacja.="</div>";			
			
			//highslide script + config + nav 
			if($this->_typ==4){			
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/highslide/highslide.js","js");
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/highslide/highslide.css","css");	
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/highslide/highslide_config.js","js");				
				?>
				<script type="text/javascript">    
				hs.registerOverlay(
				    {
						  slideshowGroup:'slideshow<?php echo $this->_podstronaNazwa; ?>',
			    		overlayId: 'controlbar<?php echo $this->_podstronaNazwa; ?>',
			    		position: 'top right',
							opacity:1,
			    		hideOnMouseOut: true
					}
				);																										
				</script>
				<div id="controlbar<?php echo $this->_podstronaNazwa; ?>" class="highslide-overlay controlbar">
					<a href="#" class="previous" onclick="return hs.previous(this)" title="Previous (left arrow key)"></a>
					<a href="#" class="next" onclick="return hs.next(this)" title="Next (right arrow key)"></a>
					<a href="#" class="highslide-move" onclick="return false" title="Click and drag to move"></a>
					<a href="#" class="close" onclick="return hs.close(this)" title="Close"></a>
				</div>
				<?php			
			
			//lightbox script	
			} else if($this->_typ==5){
			
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/jquery-min.js","js");
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/slimbox/slimbox2.js","js");					
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/slimbox/slimbox2.css","css");					
			
				//konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/prototype.js","js");
				//konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/scriptaculous/scriptaculous.js?load=effects","js");	
				//konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/lightbox/lightbox.js","js");					
				//konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/lightbox/lightbox.css","css");		
							
			}
			
			echo "<div class=\"".$this->_imageKlasa." srodek\">";
			
			if(!empty($this->_kotwica)){
				echo "<a name=\"".$this->_kotwica."\"></a>";
			}
			
			if($this->_typ==3&&$this->_bierzace&&!empty($this->_dane[$this->_bierzace])){
				echo "<div>";
			  echo "<img src=\"".konf::get()->getKonfigTab("sciezka").$this->_katalog.$this->_dane[$this->_bierzace]['img1_nazwa']."\" width=\"".$this->_dane[$this->_bierzace]['img1_w']."\" height=\"".$this->_dane[$this->_bierzace]['img1_h']."\" alt=\"".htmlspecialchars($this->_dane[$this->_bierzace][$this->_tytulPole])."\" />";				
				
				if(!empty($this->_tytulPole)&&isset($this->_dane[$this->_bierzace][$this->_tytulPole])){
					echo "<div>".$this->_dane[$this->_bierzace][$this->_tytulPole]."</div>";
				}		
								
				echo "</div>";
			}
		
			echo $nawigacja;
			
			//linki do popup
			if($this->_typ==2){					
				$this->_przenies['akcja']=$this->_przenies['akcja2'];
				$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),$this->_przenies)."&amp;".$this->_podstronaNazwa."=".$this->_podstrona;
			} else if($this->_typ==3){
				$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),$this->_przenies)."&amp;".$this->_podstronaNazwa."=".$this->_podstrona;
			}		
			
			//$i = count pictures in page
			//$j = count pictures in row		
			
	  	for($i=0;$i<$ile;$i++){
			
				if($j==0){
					
					//only one table
					if(!$this->_zalezne||$i==0){
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"".$this->_imageKlasa." srodek\">";					
					}		
										
					echo "<tr valign=\"top\">";
				}				
				
			  list($key,$val)=each($this->_dane);		
								
				if(!empty($val['img2_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").$this->_katalog.$val['img2_nazwa'])){

		      echo "<td>";
					
					if(!isset($val[$this->_tytulPole])){
						$val[$this->_tytulPole]="";
					}
											
					switch($this->_typ){
					
						case '1':
						
							echo "<a href=\"javascript:popup_image('projektor','".konf::get()->getKonfigTab("sciezka").$this->_katalog.$val['img1_nazwa']."','".str_replace("'","\'",htmlspecialchars($val['tytul']))."',".$val['img1_w'].",".$val['img1_h'].",0);\">";
							echo $this->imgMale($val);
							echo "</a>";							
							
						break;
						
						case '2':
						
							echo "<a href=\"javascript:popup_open('projektor','".$link."&amp;".$this->_fotkaNazwa."=".$key."',".$this->_projektorW.",".$this->_projektorH.",0);\">";
							echo $this->imgMale($val);								
							echo "</a>";									
							
						break;			
						
						case '3':
						
							echo "<a href=\"".$link."&amp;".$this->_fotkaNazwa."=".$key;
							if($this->_kotwica){
								echo "#".$this->_kotwica;
							}
							echo "\">";
							echo $this->imgMale($val);								
							echo "</a>";									
							
						break;		
						
						case '4':
							echo "<a href=\"".konf::get()->getKonfigTab("sciezka").$this->_katalog.$val['img1_nazwa']."\" onclick=\"return hs.expand(this, {captionId: 'caption".$key."', slideshowGroup: 'slideshow".$this->_podstronaNazwa."'})\">";
							echo $this->imgMale($val);
							echo "</a>";			
							echo "<div class=\"highslide-caption\" id=\"caption".$key."\">";
    					echo "<div class=\"grube\">".$val[$this->_tytulPole]."</div>";
    					echo "<div class=\"male\">".tekstform::doWys($val[$this->_opisPole])."</div>";							
							echo "</div>";
							
						break;			
						
						case '5':
						
							//echo "<a href=\"".konf::get()->getKonfigTab("sciezka").$this->_katalog.$val['img1_nazwa']."\" rel=\"lightbox[".$this->_podstronaNazwa."]\" title=\"".htmlspecialchars($val[$this->_tytulPole])."\">";
							echo "<a href=\"".konf::get()->getKonfigTab("sciezka").$this->_katalog.$val['img1_nazwa']."\" rel=\"lightbox-".$this->_podstronaNazwa."\" title=\"".htmlspecialchars($val[$this->_tytulPole])."\">";																					
							echo $this->imgMale($val);
							echo "</a>";			
							
						break;																				

					} //k switch 1
								
					
					if(!empty($this->_tytulPole)&&isset($val[$this->_tytulPole])&&$val[$this->_tytulPole]!=''){
						echo "<div>".$val[$this->_tytulPole]."</div>";
					}
					
					echo "</td>";						
					$j++;
					
				}
				
				if($j==$this->_kolumna){
				
					//one table
					if($this->_zalezne){
						echo "</tr>";
					//each row = table
					} else {						
						echo "</tr></table>";
					}
					$j=0;
				}
			}
			
			//add empty cells
			
			if ($this->_zalezne||$j>0){
			
				if($j>0){
					
					if($this->_zalezne)			{
						while($j<=$this->_kolumna){
							$j++;
							echo "<td>&nbsp;</td>";
						}				
					}
					echo "</tr>";					
					
				} 
				
				echo "</table>";
				
			}

			echo $nawigacja;					

			
			echo "</div>";
					
		} //k dane
	
	}
						
	/**
   * class constructor php5	
   * @param string $tresc					
   * @param int $typ	
   * @param array $dane					
   */	
	public function __construct($katalog,$typ,$dane) {	
	
		$this->setKatalog($katalog);
		$this->setTyp($typ);
		$this->setDane($dane);

		
  }	

}

?>