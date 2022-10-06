<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

include_once(konf::get()->getKonfigTab('mod_kat')."sklep/konfig_inc.php");			

class sklep extends modul  {

	/**
	 * protecteds variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="sklep class";

	/**
	 * id kat
	 */				
  protected $_katId="";		
	
	/**
	 * dane kat
	 */				
  protected $_daneKat=array();		
		
	/**
	 * sciezka kat
	 */				
  protected $_sciezkaKat=array();			
	
	/**
	 * podkategorie kat
	 */				
  protected $_podkategorieKat=array();				
	
	/**
	 * id kat
	 */				
  protected $_prodId="";		
	
	/**
	 * dane kat
	 */				
  protected $_daneProd=array();				
	
	
	/**
	 * get search values
	 */		
	protected $_szuk=array(
		"szuk_producent"=>"",			
		"szuk_nazwa"=>"",		
		"szuk_cenaod"=>"",			
		"szuk_cenado"=>"",				
	);	
	
	
  /**
   * sql addition
   * @return string		
   */			
	protected function sqlAdd($tab="k"){
	
		$sql="";
		//if(!$this->admin()){
			$sql.=" AND ".$tab.".status=1";
	    $sql.=" AND (".$tab.".data_start<=NOW() OR ".$tab.".data_start='0000-00-00 00:00:00')";
	    $sql.=" AND (".$tab.".data_stop>=NOW() OR ".$tab.".data_stop='0000-00-00 00:00:00')";		
		//}
		$sql.=" AND ".$tab.".lang='".konf::get()->getLang()."'";		
		
		return $sql;
		
	}
	
	
  /**
   * sql addition
   * @return string		
   */			
	protected function sqlAddP($tab="p"){
	
		$sql=$this->sqlAdd($tab="p");
		
		return $sql;
		
	}	
	
	
  /**
   * sql addition
   * @param $int podstrona		
   * @return string		
   */			
	protected function sqlTypP($typ="",$tab="p"){
	
		$sql="";
					
		if(konf::get()->getKonfigTab("sklep_konf",'prod_'.$typ)){		
			$sql.=" AND ".$tab.".".$typ."=1";
	    $sql.=" AND (".$tab.".".$typ."_start<=NOW() OR ".$tab.".".$typ."_start='0000-00-00 00:00:00')";
	    $sql.=" AND (".$tab.".".$typ."_stop>=NOW() OR ".$tab.".".$typ."_stop='0000-00-00 00:00:00')";		
		}
		
		return $sql;
		
	}		
				
  /**
   * tworzy link do kategorii
   * @param array $dane
   * @param array $zmienne
   * @param int $podstrona
   * @param bool $href
   * @return string		
   */		
	public function katLink($dane,$zmienne=array(),$podstrona="",$href=true){

		$link="";
		
		if(konf::get()->getKonfigTab('mod_rewrite')){
		
			$link.=konf::get()->getKonfigTab("sciezka");			
			if(!empty($dane['idtf_link'])){	
				$link.=$dane['idtf_link'].",";
			} else {
				$link.=tekstForm::male(tekstForm::podstawowy($dane['tytul'],"-",true)).",";			
			}
			$link.="k".$dane['id'].",";
			if(!empty($podstrona)&&$podstrona>1){
				$link.="s".$podstrona.",";			
			}
			$link.="l".konf::get()->getLang().".html";
			
			if(!empty($zmienne)){
				$link=konf::get()->zmienneLink($link,$zmienne,false);
			}

		} else {
			$zmienne['id_kat']=$dane['id'];
			$zmienne['akcja']="sklep_zobacz";			
			$link.=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),$zmienne);		
		}
		
		if($href){
			$link="href=\"".$link."\"";
		}

		return $link;
		
	}	
	
	
  /**
   * tworzy link do produktu
   * @param array $dane
   * @param array $zmienne
   * @param int $podstrona
   * @return string		
   */		
	public function prodLink($dane,$zmienne=array(),$podstrona=""){

		$link="";
		
		if(konf::get()->getKonfigTab('mod_rewrite')){
		
			$link.=konf::get()->getKonfigTab("sciezka");			
			if(!empty($dane['idtf_link'])){	
				$link.=$dane['idtf_link'].",";
			} else {
				$link.=tekstForm::male(tekstForm::podstawowy($dane['nazwa'],"-",true)).",";			
			}
			$link.="p".$dane['id'].",";
			if(!empty($podstrona)&&$podstrona>1){
				$link.="s".$podstrona.",";			
			}
			$link.="l".konf::get()->getLang().".html";
			
			if(!empty($zmienne)){
				$link=konf::get()->zmienneLink($link,$zmienne,false);
			}
			
		} else {
			$zmienne['id_produkt']=$dane['id'];
			$zmienne['akcja']="sklep_produkt";					
			$link.=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),$zmienne);		
		}
		
		$link="href=\"".$link."\"";

		return $link;
		
	}		

	
  /**
   * pobiera sklep kat
   * @param int $id_kat
   * @param bool $lista		
   * @param int $pmax
   * @param int $id_d	
   * @return array		
   */			
	public function pobierz($id_kat,$lista=false,$pmax=0,$id_d=""){

		$dane="";
		$id_kat=$id_kat+0;
		
		if(!empty($id_kat)){
	    $sql="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k WHERE ";
			if($id_kat){
				if($lista){
					$sql.=" k.id_matka=".$id_kat." ";				
				} else {
					$sql.=" k.id=".$id_kat." ";
				}
			}
			if($pmax){
	    	$sql.=" AND k.poziom<=".$pmax;						
			}
			if($id_d){
	    	$sql.=" AND k.id_d<=".$id_d;						
			}					
			$sql.=$this->sqlAdd();
			$sql.=" ORDER BY k.id_d, k.id_matka,k.nr_poz, k.id";			

			if($lista){
				$dane=konf::get()->_bazasql->pobierzRekordy($sql,"id");			
			} else {
				$dane=konf::get()->_bazasql->pobierzRekord($sql);
			}
			
		}
		
		return $dane;
		
	}
	
	
  /**
   * pobiera dane kat
   * @param int $id_kat
   * @param bool $dane
   */		
	protected function setKat($id_kat,$dane=true){
	
		if($id_kat&&$dane){
		
			$dane_kat=$this->pobierz($id_kat,false);			
			$this->_daneKat=$dane_kat;
			if(empty($dane_kat)){
				$id_kat=0;
			}
		
		}
		
		$id_kat=$id_kat+0;		
		$this->_katId=$id_kat;
	
	}
	
	
  /**
   * pobiera dane prod
   * @param int $id_produkt
   * @param bool $dane
   */		
	protected function setProd($id_produkt,$dane=true){
	
		if(!empty($id_produkt)&&$dane){
			$dane_prod=$this->pobierzProdukt("",$id_produkt,false);			
			$this->_daneProd=$dane_prod;
			if(empty($dane_prod)){
				$id_produkt=0;
			} else if(!empty($dane_prod['id_kat'])){
				$this->setKat($dane_prod['id_kat']);
			}
		
		}
		$id_produkt=$id_produkt+0;
		
		$this->_prodId=$id_produkt;
	
	}	
	
	
  /**
   * pobiera sklep produkt
   * @param int $id_kat
   * @param int, array $id_produkt
   * @param bool $lista		
   * @param int $max		
   * @param string $dodatek
   * @return array		
   */			
	public function pobierzProdukt($id_kat="",$id_produkt="",$lista=false,$max="",$dodatek=""){

	
		$dane="";
		$id_kat=$id_kat+0;
				
    $sql="SELECT p.*, pr.nazwa AS producent, k.tytul AS kategoria FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." p LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." pr ON p.id_producent=pr.id LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k ON p.id_kat=k.id WHERE 1 ";
		

		if($id_produkt){
			if(is_array($id_produkt)){
				$sql.="AND p.id IN(".tekstForm::tabQuery($id_produkt).")";
			} else {
				$id_produkt=$id_produkt+0;			
				$sql.=" AND p.id=".$id_produkt." ";
			}
		} else if($id_kat) {
			$sql.=" AND p.id_kat=".$id_kat." ";			
		}
		
		
		if(!empty($dodatek)&&$dodatek!="kupowali"){
			$sql.=$this->sqlTypP($dodatek);			
		}
		

		if($dodatek=="kupowali"&&$max&&$this->_prodId){		

			$sql.=" AND p.id IN (SELECT z.id_produkt FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia_produkty')." z WHERE z.id_zam IN (SELECT z.id_zam FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia_produkty')." z WHERE z.id_produkt='".$this->_prodId."') AND z.id_produkt!='".$this->_prodId."' GROUP BY (z.id_produkt) ORDER BY COUNT(z.id)) ";
			
		}		
	
		$sql.=$this->sqlAddP();
		if(!$id_produkt){
			$sql.=" ORDER BY p.priorytet DESC,.p.data_start DESC, p.id DESC";			
		}
		if($max){
			$sql.=" LIMIT 0,".$max;
		}

		if($lista){
			$dane=konf::get()->_bazasql->pobierzRekordy($sql,"id");			
		} else {
			$dane=konf::get()->_bazasql->pobierzRekord($sql);
		}


		return $dane;
		
	}	
	
	
	protected function listaskr($typ,$ile,$tytul){
	
		$dane_tab=$this->pobierzProdukt("","",true,$ile,$typ);
		
		if(!empty($dane_tab)){
		
			echo tab_nagl($tytul);
			echo "<tr><td class=\"tlo3 srodek\" style=\"padding:0px;\">";
			
			$i=0;
			$j=0;
			$max=count($dane_tab);
			
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"proll\">";
			while(list($key,$dane)=each($dane_tab))	{
			
				$i++;
			
				if($j==0){
					echo "<tr valign=\"top\">";					
				}			
				
				$this->produktSkrot($dane,$i,$max,"");
				$j++;
				
				if($j==3){
					echo "</tr>";
					$j=0;
				}
				
			}
			if($j>0){
				while($j<3){
					echo "<td style=\"width:33%\" class=\"produkt_skrot\">&nbsp;</td>";
					$j++;
				}
				echo "</tr>";
			}
			echo "</table>";

			
			echo "</td></tr>";
		
			echo tab_stop();
		
		}
		
	}
	
	public function produkt(){
	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');	
		$id_produkt=tekstForm::doSql(konf::get()->getZmienna('id_produkt','id_produkt'));		

		if(!empty($this->_daneProd)){		
		
			$dane=$this->_daneProd;
			
			//indywidualne meta tagi
			if(!empty($dane['description'])){
				konf::get()->setKonfigTab(array('description'=>$dane['description']));
			} else {
				konf::get()->setKonfigTab(array('description'=>$dane['nazwa'].".".konf::get()->getKonfigTab('description')));					
			}
			if(!empty($dane['keywords'])){
				konf::get()->setKonfigTab(array('keywords'=>$dane['keywords']));			
			} else {
				konf::get()->setKonfigTab(array('keywords'=>$dane['nazwa'].",".konf::get()->getKonfigTab('keywords')));					
			}
			
			//indywidualne title dla podstrony
			if(konf::get()->getKonfigTab("sklep_konf",'prod_tytuly_indywidualne')){
			
				if(!empty($dane['title'])){
					konf::get()->setTitle($dane['title'],true);					
				} else {
					konf::get()->setTitle($dane['nazwa']);
				}

			}			
		
			$this->sciezka();	

			echo tab_nagl("Dane produktu");
			echo "<tr><td class=\"tlo3 lewa\">";
			
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr valign=\"top\">";
			
			if(!empty($dane['img'])&&!empty($dane['img2_w'])&&!empty($dane['img2_h'])&&!empty($dane['img2_nazwa'])){
			
				$pliczek=konf::get()->getKonfigTab("sklep_konf",'produkty_kat').$dane['img2_nazwa'];			
				
			  if(file_exists(konf::get()->getKonfigTab("serwer").$pliczek)){		
				
					echo "<td style=\"padding-right:15px;\">";
					konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/jquery-min.js","js");
					konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/slimbox/slimbox2.js","js");					
					konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/slimbox/slimbox2.css","css");		
								
					echo "<a href=\"".konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("sklep_konf",'produkty_kat').$dane['img1_nazwa']."\" rel=\"lightbox-".$dane['id']."\" title=\"".htmlspecialchars($dane['nazwa'])."\"><img src=\"".konf::get()->getKonfigTab("sciezka").$pliczek."\" width=\"".$dane['img2_w']."\" height=\"".$dane['img2_h']."\" alt=\"".htmlspecialchars($dane['nazwa'])."\" title=\"".htmlspecialchars($dane['nazwa'])."\" class=\"prod_img\" /></a>";
					
					echo "</td>";
					
				}		
				
			}	
			
			echo "<td>";
			
			echo "<div class=\"prod_label\">Nazwa produktu:</div>";
			echo "<h2>".$dane['nazwa']."</h2>";
			
			if(!empty($dane['kategoria'])){
				echo "<div> <span class=\"prod_label\">Kategoria:</span> ";			
				echo "<span class=\"prod_producent\">".$dane['kategoria']."</span></div>";			
			}			
			
			if(!empty($dane['producent'])){
				echo "<div><span class=\"prod_label\">Wydawnictwo:</span> ";			
				echo "<span class=\"prod_producent\">".$dane['producent']."</span></div>";			
			}
			
			if(!empty($dane['symbol'])){
				echo "<div><span class=\"prod_label\">Numer ISBN:</span> ";			
				echo "<span class=\"prod_symbol grube\">".$dane['symbol']."</span></div>";			
			}		
			
			echo "<div class=\"prod_cena\">cena: ";
			if(tekstForm::niepuste($dane['cena_skreslona'])){
				echo "<span class=\"prod_cenas\">".$dane['cena_skreslona']." zł</span> ";				
			}
			echo "<span class=\"prod_cenaw\">".$dane['cena']." zł</span>";
			
			echo "</div>";		
			
			if(konf::get()->getKonfigTab("sklep_konf",'prod_waga')&&tekstForm::niepuste($dane['waga'])){					
			
				echo "<div class=\"prod_cena\">waga: ";
				echo "<span class=\"grube\">".$dane['waga']." kg</span>";
				
				echo "</div>";		
				
			}						
			
			echo "<div class=\"nowa_l srodek nobr\">";
		
			$dodatek=$this->_szuk;
			$dodatek['podstrona']=$podstrona;
			$dodatek['akcja2']=konf::get()->getAkcja();			
			$dodatek['sortuj']=$sortuj;			
			$dodatek["akcja"]="koszyk_dodaj";
			$dodatek["id_produkt"]=$dane['id'];		
					
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"sklep_zamow","sklep_zamow");		
			echo $form->getFormp();	
			echo $form->przenies($dodatek);			
			echo "<div class=\"sklep_ile\">";										
			echo $form->input("text","ile","ile",1,"f_krotki2 prawa",4);	
			echo "</div>";
			echo "<div class=\"sklep_dodaj\">";
			echo $form->input("image","","","","dokoszyka",4," src=\"img/sklep/dokoszyka.gif\"");				
			echo "</div>";
			echo $form->getFormk();						
			
			echo "</div>";		
			
			echo "</td>";	
			
			echo "<td>";
			
			
			echo "</td>";
			
			echo "</tr></table>";

			echo "</td></tr>";

			if(!empty($dane['opis'])){
			
				echo "<tr><td class=\"tlo4 grube\">Opis produktu:</td></tr>";
				
				echo "<tr><td class=\"tlo3\">";
				echo $dane['opis'];
				echo "</td>";
				echo "</tr>";
			
			}
			
			echo tab_stop();
			
			if(konf::get()->getKonfigTab("sklep_konf",'prod_kupowali')){						
				$this->listaskr("kupowali",3,"Klienci, którzy kupili ten produkt, kupili również:",true);					
			}
			
			
			if(konf::get()->getKonfigTab("sklep_konf",'kom')){
			
				echo "<a name=\"koment\"></a>";
			
				$konf=konf::get();
				require_once(konf::get()->getKonfigTab('mod_kat')."koment/class.koment.php");
				$koment=new koment(5);
				$koment->setPrzenies(array("id_produkt"=>$dane['id']));
				$koment->setId($dane['id']);						
				$koment->wyswietl();
				$koment->formularz();				
				
			}

			if(konf::get()->getKonfigTab("sklep_konf",'prod_zliczac_wys')&&!$this->admin()){
						
			  konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." SET licznik=licznik+1 WHERE id='".$dane['id']."'");			
				
			}							
			
		} else {
			
			echo "<div class=\"srodek grube\" style=\"padding:10px;\">Produkt niedostępny lub usunięty.</div>";
		
		}
	
	}	
	
	protected function produktSkrot($dane,$nr="",$max="",$dodatek=""){
	
		$link=$this->prodLink($dane,$dodatek);
	
		echo "<td class=\"produkt_skrot\">";
		
		echo "<div class=\"prod_tytul\"><a ".$link.">".$dane['nazwa']."</a></div>";		
		
		if(!empty($dane['img'])&&!empty($dane['img3_w'])&&!empty($dane['img3_h'])&&!empty($dane['img3_nazwa'])){
		
			$pliczek=konf::get()->getKonfigTab("sklep_konf",'produkty_kat').$dane['img3_nazwa'];			
			
		  if(file_exists(konf::get()->getKonfigTab("serwer").$pliczek)){		
			
				echo "<div class=\"srodek\"><a ".$link."><img src=\"".konf::get()->getKonfigTab("sciezka").$pliczek."\" width=\"".$dane['img3_w']."\" height=\"".$dane['img3_h']."\" alt=\"".htmlspecialchars($dane['nazwa'])."\" title=\"".htmlspecialchars($dane['nazwa'])."\" class=\"prod_img\" /></a></div>";								
				
			}		
			
		}	
		
		echo "<div class=\"prod_cena\">";
		if(tekstForm::niepuste($dane['cena_skreslona'])){
			echo "<span class=\"prod_cenas\">".$dane['cena_skreslona']." zł</span> ";		
			echo "<span class=\"prod_cenaw2\">".$dane['cena']." zł</span>";					
		} else {
		echo "<span class=\"prod_cenaw\">".$dane['cena']." zł</span>";		
		}		
		echo "</div>";				
				
		if(!empty($dane['producent'])){
			echo "<div class=\"prod_producent\">Wydawnictwo: ".$dane['producent']."</div>";			
		}
		
		if(!empty($dane['symbol'])){
			echo "<div class=\"prod_symbol\">ISBN: ".$dane['symbol']."</div>";			
		}		
		

		echo "<div class=\"nowa_l srodek nobr\" style=\"padding-top:10px;\">";
		$dodatek["akcja"]="koszyk_dodaj";
		$dodatek["akcja2"]=konf::get()->getAkcja();
		$dodatek["id_produkt"]=$dane['id'];										
		echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),$dodatek)."\"><img src=\"img/sklep/dokoszyka.gif\" alt=\"do koszyka\" /></a>";				
		echo "</div>";

		echo "</td>";
	
	}
	
	
	public function powitalna(){
	
		echo "<div id=\"nowosci\">";
		$this->listaskr("nowosc",6,"Nowości");		
		echo "</div>";		
	
	}
	
  /**
   * sciezka do sklep
   */			
	public function sciezka(){

		$link="";
		
		$zmienne=$this->_szuk;
		$zmienne['sortuj']=konf::get()->getZmienna('sortuj','sortuj');
		
		if(!empty($this->_daneKat)){
				
			$link=" &gt; <a ".$this->katLink($this->_daneKat,$zmienne).">".$this->_daneKat['tytul']."</a>".$link;
			$id=$this->_daneKat['id_matka'];		
			$this->_sciezkaKat[$this->_daneKat['id']]=$this->_daneKat;
		}

		if(!empty($id)){
			while($id!=0){
				$dane=$this->pobierz($id);
				if(!empty($dane)){	
					$this->_sciezkaKat[$dane['id']]=$dane;
					$link=" &gt; <a ".$this->katLink($dane,$zmienne).">".$dane['tytul']."</a>".$link;
					$id=$dane['id_matka'];
				} else {
					break;
				}
			}
		}
		
		if(!empty($link)){
			echo "<div class=\"nowa_l lewa\" style=\"padding-bottom:5px; padding-top:4px;\">";
			echo "<a href=\"".konf::get()->getKonfigTab("sciezka")."\"><img src=\"".konf::get()->getKonfigTab("sciezka")."img/house.gif\" width=\"15\" height=\"16\" alt=\"\" class=\"lewa\" style=\"margin-right:5px; margin-bottom:2px;\" /></a>";
			echo $link;
			echo "</div>";
		}		
		
	}
	
	public function katmenu(){
	
		$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');
		$id_d="";
		
		$wybrana=0;
		
		if(!empty($this->_daneKat)){
			if($this->_daneKat['poziom']==1){
				$wybrana=$this->_daneKat['id_matka'];
			} else if($this->_daneKat['poziom']==0) {
				$wybrana=$this->_daneKat['id'];
			} else if($this->_daneKat['poziom']>1){
				
				$dane=$this->_daneKat;
				while(!empty($dane)){
					$dane=$this->pobierz($dane['id_matka']);
					if(empty($dane)){	
						break;
			 		} else if($dane['poziom']==1){
						$wybrana=$dane['id_matka'];
						break;
					}
				}
				
			}
		}

		//pobieramy okreslone dane
 		$query="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k WHERE 1 ";
		$query.=" AND (k.poziom<=1)".$this->sqlAdd();
    $zap=konf::get()->_bazasql->zap($query." ORDER BY k.id_matka,k.nr_poz,k.id");       
    while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
      $dane_tab[$dane['id_d']][$dane['id_matka']][$dane['id']]=$dane;
    }
    konf::get()->_bazasql->freeResult($zap);		

		if(!empty($dane_tab)){
		
			echo "<div class=\"subm\">";
		
			while(list($key,$dzial)=each($d_tab)){
			
				if(!empty($dane_tab[$key][0])){
				
					//echo "<div class=\"sk_n\">".$dzial."</div>";
					
					while(list($key2,$kat)=each($dane_tab[$key][0])){		
					
						echo "<a ".$this->katLink($kat)." class=\"sk_d";
						if($wybrana==$key2){
							echo "2";
						}
						echo "\">".$kat['tytul']."</a>";					
					
						//echo "<div class=\"sk_d\">".$kat['tytul']."</div>";			
						
						if(!empty($dane_tab[$key][$key2])&&!empty($dane_tab[$key][$key2])){

							while(list($key3,$kat2)=each($dane_tab[$key][$key2])){								
								
								echo "<a ".$this->katLink($kat2)." class=\"sk_k";
								if($wybrana==$key3){
									echo "2";
								}
								echo "\">".$kat2['tytul']."</a>";

																					
							}
							
						}
																	
					}
				
				}
			
			}
			
			echo "</div>";
		
		}
	
	}
	
	
	public function wyszukiwarka(){
	
		$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');
		$id_d="";		
		$wybrana=0;
		
		$this->szukZmienne(1,true,false);			
		
		if(!empty($this->_daneKat)){
			if($this->_daneKat['poziom']==2){
				$wybrana=$this->_daneKat['id_matka'];
			} else {
				$wybrana=$this->_daneKat['id'];
			}
		}
		
		//pobieramy okreslone dane
 		$query="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k WHERE 1 ";
		$query.=" AND k.poziom<=1 ".$this->sqlAdd();
    $zap=konf::get()->_bazasql->zap($query." ORDER BY k.id_d, k.id_matka,k.nr_poz,k.id");  
		
		$id_d="";
		$dane_kat=array();
		$dane_podkat=array();
		   
    while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			if($dane['poziom']==1){
				$dane_podkat[$dane['id_matka']][$dane['id']]="--&raquo;".$dane['tytul'];
			} else {
				if($id_d!=$dane['id_d']&&!empty($d_tab[$dane['id_d']])){
					//$id_d=$dane['id_d'];
		      //$dane_kat["d".$dane['id_d']]=$d_tab[$dane['id_d']];					
				}
	      $dane_kat[$dane['id']]="-".$dane['tytul'];
			}
			
    }
		

				
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"sklep_wyszukiwarka","sklep_wyszukiwarka");		
		echo $form->getFormp();	
		echo $form->przenies(array("akcja"=>"sklep_zobacz"));				
		
		echo "<table border=\"0\" class=\"seta\" cellspacing=\"0\" cellpadding=\"0\"><tr valign=\"middle\">";
		
		echo "<td style=\"padding-top:3px; padding-left:7px;\">";			
		echo "<div class=\"bbc grube\">znajdź produkt:</div>";	
		echo "</td>";		
		
		echo "<td style=\"padding-top:3px;\">";			
		echo $form->input("text","szuk_nazwa","szuk_nazwa",$this->_szuk['szuk_nazwa'],"f_sredni",150);	
		echo "</td>";
				

		echo "<td style=\"padding-top:3px;\">";
		echo $form->select2("id_kat","id_kat",$dane_kat,$dane_podkat,$this->_katId,"f_sredni","--wybierz--","",true);	
		echo "</td>";
		
		echo "<td style=\"padding-top:3px; padding-left:7px; padding-right:7px;\">";			
		echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklep_szukaj"))."\">zawansowane</a>";	
		echo "</td>";		
				
		
		echo "<td class=\"srodek\" style=\"background-color:#212121;\">";
		echo $form->input("submit","","","szukaj","formularz2 f_krotki");						
		echo "</td>";		
		
		echo "</tr></table>";

		echo $form->getFormk();					

	
	}	
	
	
  /**
   * get producenci
	 * @return array
   */			
	protected function pobierzProducenci(){
	
		$dane_tab=array();
		
		$producenci_dane=konf::get()->_bazasql->pobierzRekordy("SELECT nazwa,id FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." WHERE status=1 ORDER BY nazwa,id","id");

		while(list($key,$dane)=each($producenci_dane)){
			$dane_tab[$key]=$dane['nazwa'];
		}
		
		return $dane_tab;
	
	}	

  /**
   * sklep
   */		
	public function zobacz(){

		$this->arch("");
		
	}
	
  /**
   * sklep
   */		
	public function nowosci(){

		$this->arch("nowosc");
		
	}
		
	
  /**
   * sklep
   */		
	public function promocje(){

		$this->arch("promocje");
		
	}
	
	
	/**
   * sklep
   */		
	public function wyprzedaz(){

		$this->arch("wyprzedaz");
		
	}
	
  /**
   * sklep
   */		
	public function poleca(){

		$this->arch("poleca");
		
	}
	
	
	protected function sqlAddKategoria(){
	
		$sql="";
	
		if($this->_katId){
		
			$podkat[]=$this->_katId;
			$podkat_all=array();			
			$poziom=0;
			
			while(!empty($podkat)){
			
				$dane_podkat=konf::get()->_bazasql->pobierzRekordy("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k WHERE k.id_matka IN (".tekstForm::tabQuery($podkat,true).") ".$this->sqlAdd()." ORDER BY k.id_matka,k.nr_poz, k.id","id");
				$podkat=array();				
				$poziom++;			
				
				if(!empty($dane_podkat)){
					while(list($key,$dane)=each($dane_podkat)){
						if($poziom==1){
							$this->_podkategorieKat[$dane['id']]=$dane;
						}
						$podkat[]=$dane['id'];
						$podkat_all[]=$dane['id'];						
					}
	
				}
				
			}
			
			if(empty($podkat_all)){
				$sql=" AND p.id_kat='".$this->_katId."'";					
			} else {
				$podkat_all[]=$this->_katId;
				$sql=" AND p.id_kat IN (".tekstForm::tabQuery($podkat_all,true).")";									
			}
			
	  }
		
		return $sql;
		
	}
	
	protected function podkatMenu(){	
		
		$colspan=4;
		$zmienne=$this->_szuk;
		$zmienne['sortuj']=konf::get()->getZmienna('sortuj','sortuj');		
	
		if(!empty($this->_podkategorieKat)){
		
			reset($this->_podkategorieKat);
			
			echo "<div id=\"podkategorie\">";
			echo tab_nagl("Wybierz podkategorię:",$colspan);
			
			$i=0;
			while(list($key,$dane)=each($this->_podkategorieKat)){
			
				if($i==0){
					echo "<tr>";
				}
				
				$i++;
				
				echo "<td class=\"tlo7\"><a ".$this->katLink($dane,$zmienne).">".$dane['tytul']."</a></td>";
				
				if($i==$colspan){
					echo "</tr>";
					$i=0;
				}
			
			}		
			
			if($i!=0)	{
			
				while($i<$colspan){
					echo "<td class=\"tlo3\">&nbsp;</td>";
					$i++;
				}
				
				echo "</tr>";
				
			}
			echo tab_stop();
			echo "</div>";
		
		}	
	
	}
			
	
	/**
   * sklep arch
   */		
	protected function arch($typ=""){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');
		
		$na_str=18;
		$colspan=1;

	  $tab_sort=array(		
			1=>"p.nazwa", 
			2=>"p.nazwa DESC", 
			3=>"p.cena, p.nazwa", 
			4=>"p.cena DESC, p.nazwa", 						
		);
		
	  $tab_sorto=array(		
			1=>"nazwa rosnąco", 
			2=>"nazwa malejąco", 
			3=>"cena rosnąco", 
			4=>"cena malejąco", 	
		);			
		
    if(empty($sortuj)||empty($tab_sort[$sortuj])){ 
			$sortuj=1; 
		}
		
		$link=$this->szukZmienne(1,true,false);	

    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." p LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." pr ON p.id_producent=pr.id LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k ON p.id_kat=k.id WHERE 1 ";		
		$query.=$this->sqlAddKategoria();

	  if(!empty($this->_szuk['szuk_producent'])){
	    $query.=" AND p.id_producent='".tekstForm::doSql($this->_szuk['szuk_producent'])."'";
	  }

		$tytul="Lista produktów";		

		if(!empty($typ)){
		
			switch($typ){
						
		  	case "promocje":
					$query.=$this->sqlTypP("promocja");
					$tytul="Promocje";				
				break;

		  	case "poleca":
					$query.=$this->sqlTypP("polecamy");
					$tytul="Polecamy";				
				break;
				
		  	case "wyprzedaz":
					$query.=$this->sqlTypP("wyprzedaz");
					$tytul="Wyprzedaż";				
				break;
				
		  	case "nowosc":
					$query.=$this->sqlTypP("nowosc");
					$tytul="Nowości";				
				break;
				
			}
			
	  }			
											
	  if(!empty($this->_szuk['szuk_cenaod'])){
	    $query.=" AND p.cena>='".tekstForm::doLiczba($this->_szuk['szuk_cenaod'])."'";
	  }		
	  if(!empty($this->_szuk['szuk_cenado'])){
	    $query.=" AND p.cena<='".tekstForm::doLiczba($this->_szuk['szuk_cenado'])."'";
	  }		
		
	  if(!empty($this->_szuk['szuk_nazwa'])){
	    $query.=" AND p.nazwa LIKE '%".tekstForm::doLike($this->_szuk['szuk_nazwa'])."%'";
	  }		
						
		$query.=$this->sqlAddP(); 

		if($this->_katId){	
			
    	$link=$this->katLink($this->_daneKat,"","",false).$link;
			$tytul=$this->_daneKat['tytul'];
			
			//indywidualne meta tagi
			if(!empty($this->_daneKat['description'])){
				konf::get()->setKonfigTab(array('description'=>$this->_daneKat['description']));
			}
			if(!empty($this->_daneKat['keywords'])){
				konf::get()->setKonfigTab(array('keywords'=>$this->_daneKat['keywords']));			
			}
			
			//indywidualne title dla podstrony
			if(konf::get()->getKonfigTab("sklep_konf",'tytuly_indywidualne')){
			
				if(!empty($this->_daneKat['title'])){
					konf::get()->setTitle($this->_daneKat['title'],true);					
				} else {
					konf::get()->setTitle($this->_daneKat['tytul']);
				}
				
			}		
			
			//licznik wyswietlen
			if(konf::get()->getKonfigTab("sklep_konf",'zliczac_wys')&&!$this->admin()){
						
			  konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." SET licznik=licznik+1 WHERE id='".$this->_katId."'");			
				
			}						

		} else {
			$przenies=$this->_szuk;
			$przenies['sortuj']=$sortuj;
			$link=konf::get()->zmienneLink(konf::get()->getAkcja().",a,l".konf::get()->getLang().".html",$przenies,false);
		}
		
		$naw = new nawig("SELECT COUNT(p.id) AS ilosc".$query,$podstrona,$na_str);		
		$naw->naw($link);
		$podstrona=$naw->getPodstrona();		
		
		$this->sciezka();	
		
		if($this->_katId){
		
			$this->podkatMenu();
		
		}

	  echo tab_nagl($tytul." (".$naw->getWynikow()."):",$colspan);	
		
		echo "<tr><td class=\"tlo3 prawa\" colspan=\"".$colspan."\">";	
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"sklep","sklep");		
		echo $form->getFormp();
		
		$przenies=$this->_szuk;
		$przenies['akcja']=konf::get()->getAkcja();
		$przenies['akcja']=konf::get()->getAkcja();	
		$przenies['id_kat']=$this->_katId;					
		
				
		echo $form->przenies($przenies);
							
		echo "sortuj według: ";
		
		echo $form->select("sortuj","sortuj",$tab_sorto,$sortuj,"",""," onchange='this.form.submit()'");
		
		echo $form->getFormk();		
		echo "</td></tr>";
	  			
		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}		

	  //pobieranie danych  
	  $query="SELECT p.*, k.tytul AS kategoria, pr.nazwa AS producent ".$query." ORDER BY ".$tab_sort[$sortuj]."";
	  $query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
			
	  $i=0;	    		
	  $dane_tab=konf::get()->_bazasql->pobierzRekordy($query,"id");
		$ile=count($dane_tab);
		
		if(!empty($ile)){
				
			echo "<tr><td class=\"tlo3 srodek\" style=\"padding:0px;\">";
			
			$i=0;
			$j=0;
			
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"proll\">";

			$dodatek=$this->_szuk;
			$dodatek['podstrona']=$podstrona;
			$dodatek['akcja2']=konf::get()->getAkcja();			
			$dodatek['sortuj']=$sortuj;
			
			while(list($key,$dane)=each($dane_tab))	{
			
				$i++;
			
				if($j==0){
					echo "<tr valign=\"top\">";					
				}			
				
				$this->produktSkrot($dane,$i,$ile,$dodatek);
				$j++;
				
				if($j==3){
					echo "</tr>";
					$j=0;
				}
				
			}
			
			if($j>0){
				while($j<3){
					echo "<td style=\"width:33%\" class=\"produkt_skrot\">&nbsp;</td>";
					$j++;
				}
				echo "</tr>";
			}
			echo "</table>";
			
			echo "</td></tr>";


		} else {
		
			echo "<tr><td class=\"tlo3 srodek grube\" style=\"padding\">";
			
			echo "Brak produktów - skorzystaj ponownie z wyszukiwarki <br />lub wybierz odpowiednią kategorię produktową";
			echo "<br /><br />";
			echo "Jeśli nie odnalazłeś interesującego Cię produktu <a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"kontakt"))."\">prześlij nam zapytanie czego poszukujesz</a>";
						
			echo "</td></tr>";	
			
	  }
		
					   
		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}				
		
		echo tab_stop();		

 
	}	
	
	
	
  /**
   * rysuje mape
   */			
	public function mapa(){

		$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');
		
	  echo tab_nagl("Mapa kategorii produktów",1);

	  if(!empty($d_tab)&&is_array($d_tab)){
		
	  	echo "<tr><td class=\"tlo3\" id=\"art_mapa\"><br />";						
	  
	    $query="";
	    
	    $query="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k WHERE 1 ".$this->sqlAdd("k");
	 
	    //puste tablice    
	    $poziom0=array();
	    $poziomy=array();
	    
	    //pobranie poziomu 0
	    $zap=konf::get()->_bazasql->zap($query." ORDER BY k.nr_poz,k.id");  
			     
	    while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
	      $poziom0[$dane['id_d']][$dane['id']]=$dane;
	    }  
	    konf::get()->_bazasql->freeResult($zap);
	    
	    
	    //jesli byl poziom 0
	    if(!empty($poziom0)){
	           
	      $query.=" AND k.id_matka!=0 AND k.poziom>0";
 
	      //pobranie wyzszych poziomow
	      $zap=konf::get()->_bazasql->zap($query." ORDER BY k.nr_poz,k.id");       
	      while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
	        $poziomy[$dane['id_matka']][$dane['id']]=$dane;
	      }

	      konf::get()->_bazasql->freeResult($zap);
	      
	      //wyswietlaj poziomy
	      
	      reset($poziom0);
	      //przelatujemy dzialy
	      while(list($key,$val)=each($poziom0)){
				
					if(!empty($d_tab[$key])){
						echo "<div class=\"grube\" style=\"padding-bottom:10px;\">".$d_tab[$key]."</div>";
					}
					echo "<ul>";
	        if(!empty($val)&&is_array($val)){
	          reset($val);
	          //przelatujemy poziom 1
	          while(list($key2,$val2)=each($val)){
	            echo "<li><a ".$this->katLink($val2).">".$val2['tytul']."</a>";
	            
	            //podstrony
	            $this->mapaPodstrony($poziomy,$val2['id'],1);    
							
							echo "</li>";      
	          }          
	        }
		      echo "</ul><br />";
	      } 	
	    }
			
	    echo "</td></tr>";
			
	  }
	  
	  echo tab_stop();

	}
	
	
	public function recenzje(){
	
		$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty_koment')." WHERE 1 ORDER BY RAND() LIMIT 0,1");	
		
		if(!empty($dane)){
		
			$dane_prod=$this->pobierzProdukt("",$dane['id_matka']);			
			if(!empty($dane_prod)){
			
				echo "<div class=\"sk_panel\">";
				
				echo "<div class=\"sk_t\">Recenzje</div>";

				$link=$this->prodLink($dane_prod);			
				
				echo "<div class=\"srodek grube\"><a ".$link.">".$dane_prod['nazwa']."</a></div>";	
				
				if(!empty($dane_prod['img'])&&!empty($dane_prod['img3_w'])&&!empty($dane_prod['img3_h'])&&!empty($dane_prod['img3_nazwa'])){
				
					$pliczek=konf::get()->getKonfigTab("sklep_konf",'produkty_kat').$dane_prod['img3_nazwa'];			
					
				  if(file_exists(konf::get()->getKonfigTab("serwer").$pliczek)){		
					
						echo "<div class=\"srodek\"><a ".$link."><img src=\"".konf::get()->getKonfigTab("sciezka").$pliczek."\" width=\"".$dane_prod['img3_w']."\" height=\"".$dane_prod['img3_h']."\" alt=\"".htmlspecialchars($dane_prod['nazwa'])."\" title=\"".htmlspecialchars($dane_prod['nazwa'])."\" class=\"prod_img\" /></a></div>";
						
					}		
					
				}	

				echo "<div class=\"prod_cena\"> ";
				if(tekstForm::niepuste($dane_prod['cena_skreslona'])){
					echo "<span class=\"prod_cenas\">".$dane_prod['cena_skreslona']." zł</span> ";				
				}
				echo "<span class=\"prod_cenaw\">".$dane_prod['cena']." zł</span>";
				
				echo "</div>";		
				
				$dodatek["akcja"]="koszyk_dodaj";
				$dodatek["akcja2"]=konf::get()->getAkcja();
				$dodatek["id_produkt"]=$dane_prod['id'];		
										
				echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),$dodatek)."\"><img src=\"img/dokoszyka.gif\" alt=\"do koszyka\" /></a>";		

				echo "<div class=\"srodek\" style=\"width:70px;\">";
				echo interfejs::ocena($dane['ocena']);				
				echo "</div>";
						
				echo "<div>".substr($dane['tresc'],0,150)."...</div>";
				
				echo "<div class=\"prawa\"><a ".$link.">więcej o produkcie &raquo;</a> &nbsp;</div>";		
				
				
				echo "</div>";					

				echo "<div class=\"od\"></div>";				
				
			}
		
		}
	
	}		
	
	
	public function bestsellery(){

    $sql="SELECT p.* FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." p WHERE p.status=1 AND p.licznik_sprzedane>0 AND p.niebestseller=0 ORDER BY p.licznik_sprzedane DESC, nazwa LIMIT 0,5";
		$dane_tab=konf::get()->_bazasql->pobierzRekordy($sql,"id");			
		
		echo "<div class=\"sk_panel\">";
		
		echo "<div class=\"sk_t\">Bestsellery</div>";
		$i=0;
		
		while(list($key,$dane)=each($dane_tab)){
			$i++;
			echo "<a class=\"sk_d\" ".$this->prodLink($dane)."><b>".$i.". </b>".$dane['nazwa']."</a>";							
		}		
		
		echo "</div>";		

	}			
	
	
	public function sitemap(){
	
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   	header('Content-Description: File Transfer');					
    header("Cache-Control: private",false);
  	header('Content-Type: text/xml');		

	  $xml = '';
	  $xml.='<?xml version="1.0" encoding="UTF-8" ?>';
	  $xml.='<urlset xmlns="http://www.google.com/schemas/sitemap/0.84"';
	  $xml.=' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
	  $xml.=' xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd"';
	  $xml.='>';

		$d_tab=konf::get()->getKonfigTab("art_konf",'d_tab');
		
	  if(!empty($d_tab)&&is_array($d_tab)){
	  
	    $query="";
			
			$d_wyklucz=array();
			
	    while(list($key,$val)=each($d_tab)){
				if(!in_array($key,$d_wyklucz)){
		    	if($query!=""){
	  	  		$query.=",";
	    		}
	    		$query.="'".$key."'";
				}
	    }
			
			$art=new art();
	    
	    $query="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_d IN (".$query.") AND (dostep!=3 OR link!='') AND mapa_nie=0 ".$art->sqlAdd();
	 			  
	    $zap=konf::get()->_bazasql->zap($query." ORDER BY nr_poz,id");  
			     
	    while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
	      $xml.='<url>';
	      $xml.='<loc>'.$art->artLink($dane,"","",false).'</loc>';				
				if(tekstForm::niepuste($dane['edytor_kiedy'])){
		      $xml.='<lastmod>'.$dane["edytor_kiedy"].'</lastmod>';
				} else {
		      $xml.='<lastmod>'.$dane["autor_kiedy"].'</lastmod>';				
				}
	      $xml.='<changefreq>daily</changefreq>';
	      $xml.='<priority>1</priority>';
	      $xml.='</url>';			
			
	    }  
	    konf::get()->_bazasql->freeResult($zap);
	    
		}		
		

    $query="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'news')." n WHERE 1 ".$art->sqlAdd()." ORDER BY id DESC ";
 			  
  	$dane_tab=konf::get()->_bazasql->pobierzRekordy($query);
  	
		//czy newsy

		if(!empty($dane_tab)){									
			
			while(list($key,$dane)=each($dane_tab)){

	      $xml.='<url>';
	      //$xml.='<loc>'.konf::get()->getKonfigTab("sciezka").konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_zobacz","id_art"=>$dane['id_matka'],"id_news"=>$dane['id'])).'</loc>';				
				if(tekstForm::niepuste($dane['edytor_kiedy'])){
		      $xml.='<lastmod>'.$dane["edytor_kiedy"].'</lastmod>';
				} else {
		      $xml.='<lastmod>'.$dane["autor_kiedy"].'</lastmod>';				
				}
	      $xml.='<changefreq>daily</changefreq>';
	      $xml.='<priority>1</priority>';
	      $xml.='</url>';			
				
			}
		
    } 

		//pobieramy okreslone dane
 		$query="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k WHERE 1 ".$this->sqlAdd("",false);
    $zap=konf::get()->_bazasql->zap($query." ORDER BY k.id_matka,k.nr_poz,k.id");       
    while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
		
      $xml.='<url>';
      $xml.='<loc>'.$this->katLink($dane,"","",false).'</loc>';				
			if(tekstForm::niepuste($dane['edytor_kiedy'])){
	      $xml.='<lastmod>'.$dane["edytor_kiedy"].'</lastmod>';
			} else {
	      $xml.='<lastmod>'.$dane["autor_kiedy"].'</lastmod>';				
			}
      $xml.='<changefreq>daily</changefreq>';
      $xml.='<priority>1</priority>';
      $xml.='</url>';					
			
    }
    konf::get()->_bazasql->freeResult($zap);			
		
		//pobieramy okreslone dane
 		$query="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." p WHERE 1 ".$this->sqlAddP("",false);
    $zap=konf::get()->_bazasql->zap($query." ORDER BY p.id");       
    while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
		
      $xml.='<url>';
      $xml.='<loc>'.$this->prodLink($dane,"","",false).'</loc>';				
			if(tekstForm::niepuste($dane['edytor_kiedy'])){
	      $xml.='<lastmod>'.$dane["edytor_kiedy"].'</lastmod>';
			} else {
	      $xml.='<lastmod>'.$dane["autor_kiedy"].'</lastmod>';				
			}
      $xml.='<changefreq>daily</changefreq>';
      $xml.='<priority>1</priority>';
      $xml.='</url>';					
			
    }
    konf::get()->_bazasql->freeResult($zap);					


	  $xml.='</urlset>';
		
		echo $xml;
	
	}	
	
	
	public function starcode(){
	
		$kat_tab=$this->pobierzKategorie();		
    $zap=konf::get()->_bazasql->zap("SELECT p.*, pr.nazwa AS producent FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." p LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." pr ON p.id_producent=pr.id LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k ON p.id_kat=k.id WHERE 1 ".$this->sqlAddP()); 		
		$ile=konf::get()->_bazasql->numRows($zap);	
	
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "<!DOCTYPE starcode SYSTEM \"http://www.starcode.pl/xml/dtd/starcode_xml.dtd\">";
		echo "<offers>";
	  echo "<stat>";

    echo "<num>".$ile."</num>";
    echo "<ver>2.0</ver>";
		
  	echo "</stat>";

		while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
		
	  	echo "<product>";
			echo "<id>".$dane['id']."</id>";
			
	    echo "<name><![CDATA[".strip_tags($dane['nazwa'])."]]></name>";
	    echo "<producer><![CDATA[".strip_tags($dane['producent'])."]]></producer>";		
	    echo "<code><![CDATA[".strip_tags($dane['symbol'])."]]></code>";		
	    echo "<model><![CDATA[".strip_tags($dane['symbol'])."]]></model>";		
			echo "<description><![CDATA[".strip_tags($dane['opis'],"")."]]></description>";							
			echo "<url><![CDATA[".strip_tags($this->prodLink($dane,"","",false))."]]></url>";
			echo "<price><![CDATA[".strip_tags($dane['cena'])."]]></price>";
			
			$kat="";
			
			if(!empty($kat_tab[$dane['id_kat']])){
				$kat_br=$kat_tab[$dane['id_kat']];
				while(!empty($kat_br)){
					if(!empty($kat)){
						$kat=" / ".$kat;
					}
					$kat=$kat_br['tytul'].$kat;
					
					if(!empty($kat_br['id_matka'])&&!empty($kat_tab[$kat_br['id_matka']])){
						$kat_br=$kat_tab[$kat_br['id_matka']];
					} else {
						break;
					}
				
				}
				
			}
			
	    echo "<category><![CDATA[".strip_tags($kat)."]]></category>";
						
	    echo "<image><![CDATA[";
			if(!empty($dane['img'])&&!empty($dane['img1_w'])&&!empty($dane['img1_h'])&&!empty($dane['img1_nazwa'])){			
				echo konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("sklep_konf",'produkty_kat').$dane['img1_nazwa'];			
			}					
			echo "]]></image>";
				
			echo "</product>";

		}
		
		konf::get()->_bazasql->fetchAssoc($zap);

		echo "</offers>";
	
	}	
	
	
	
	public function radar(){
	
		$kat_tab=$this->pobierzKategorie();		
    $zap=konf::get()->_bazasql->zap("SELECT p.*, pr.nazwa AS producent FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." p LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." pr ON p.id_producent=pr.id LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k ON p.id_kat=k.id WHERE 1 ".$this->sqlAddP()); 		
		$ile=konf::get()->_bazasql->numRows($zap);	
		
		
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "<radar wersja=\"1.0\">";
		echo "<oferta>";

		while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
		
			echo "<produkt><grupa1>";
			
			echo "<nazwa><![CDATA[".strip_tags($dane['nazwa'])."]]></nazwa>";			
			echo "<producent><![CDATA[".strip_tags($dane['producent'])."]]></producent>";
			echo "<opis><![CDATA[".strip_tags($dane['opis'],"")."]]></opis>";						
			echo "<id>".$dane['id']."</id>";
			echo "<url><![CDATA[".strip_tags($this->prodLink($dane,"","",false))."]]></url>";			
	    echo "<foto><![CDATA[";
			if(!empty($dane['img'])&&!empty($dane['img1_w'])&&!empty($dane['img1_h'])&&!empty($dane['img1_nazwa'])){			
				echo konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("sklep_konf",'produkty_kat').$dane['img1_nazwa'];			
			}					
			echo "]]></foto>";

			$kat="";
			
			if(!empty($kat_tab[$dane['id_kat']])){
				$kat_br=$kat_tab[$dane['id_kat']];
				while(!empty($kat_br)){
					if(!empty($kat)){
						$kat=" / ".$kat;
					}
					$kat=$kat_br['tytul'].$kat;
					
					if(!empty($kat_br['id_matka'])&&!empty($kat_tab[$kat_br['id_matka']])){
						$kat_br=$kat_tab[$kat_br['id_matka']];
					} else {
						break;
					}
				
				}
				
			}
			
	    echo "<kategoria><![CDATA[".strip_tags($kat)."]]></kategoria>";			
			echo "<cena><![CDATA[".strip_tags($dane['cena'])."]]></cena>";			

			echo "</grupa1></produkt>";

		}
		
		konf::get()->_bazasql->fetchAssoc($zap);

		echo "</oferta></radar>";
	
	}		
	
	
	public function skapiec(){
	
		$kat_tab=$this->pobierzKategorie();		
    $zap=konf::get()->_bazasql->zap("SELECT p.*, pr.nazwa AS producent FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." p LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." pr ON p.id_producent=pr.id LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k ON p.id_kat=k.id WHERE 1 ".$this->sqlAddP()); 		
		$ile=konf::get()->_bazasql->numRows($zap);	

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		
		echo "<xmldata>";
		echo "<version>12.0</version>";
		echo "<header>";
		echo "<name>".htmlspecialchars(konf::get()->getKonfigTab('nazwa_www'))."</name>";		
		echo "<www>".htmlspecialchars(konf::get()->getKonfigTab('sciezka'))."</www>";
		echo "<time>".date("Y-m-d")."</time>";
		echo "</header>";

		echo "<category>";
		while(list($key,$dane)=each($kat_tab)){
			echo "<catitem>";
			echo "<catid>".$dane['id']."</catid>";			
			echo "<catname>".htmlspecialchars($dane['tytul'])."</catname>";
			echo "</catitem>";
		}
		echo "</category>";					
		echo "<data>";

		while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				
			echo "<item>";
			echo "<compid>".$dane['id']."</compid>";
			echo "<vendor>".$dane['id_producent']."</vendor>";
			echo "<name>".htmlspecialchars(strip_tags($dane['nazwa']))."</name>";						
			echo "<price>".htmlspecialchars(strip_tags($dane['cena']))."</price>";					
			echo "<catid>".$dane['id_kat']."</catid>";
	    echo "<foto>";
			if(!empty($dane['img'])&&!empty($dane['img1_w'])&&!empty($dane['img1_h'])&&!empty($dane['img1_nazwa'])){			
				echo htmlspecialchars(konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("sklep_konf",'produkty_kat').$dane['img1_nazwa']);			
			}					
			echo "</foto>";						
			echo "<desclong><![CDATA[".strip_tags($dane['opis'],"")."]]></desclong>";			
			echo "<url>".htmlspecialchars(strip_tags($this->prodLink($dane,"","",false)))."</url>";					
			echo "</item>";

		}
		
		konf::get()->_bazasql->fetchAssoc($zap);

		echo "</data></xmldata>";
	
	}			
	

	public function ceneo(){

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "<!DOCTYPE pasaz:Envelope SYSTEM \"loadOffers.dtd\">";
		echo "<pasaz:Envelope xmlns:pasaz=\"http://schemas.xmlsoap.org/soap/envelope/\">";
  	echo "<pasaz:Body>";
    echo "<loadOffers xmlns=\"urn:ExportB2B\">";

    echo "<offers>";
		
  	$kat_tab=$this->pobierzKategorie();		
    $zap=konf::get()->_bazasql->zap("SELECT p.*, pr.nazwa AS producent FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." p LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." pr ON p.id_producent=pr.id LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k ON p.id_kat=k.id WHERE 1 ".$this->sqlAddP()); 		

  	while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
    	echo "<offer>";
			
			echo "<id>".$dane['id']."</id>";
			echo "<name>".htmlspecialchars($dane['nazwa'])."</name>";
			echo "<price>".$dane['cena']."</price>";
			echo "<url>".$this->prodLink($dane,"","",false)."</url>";
			
			echo "<categoryId>";
			
			$kat="";
			
			if(!empty($kat_tab[$dane['id_kat']])){
				$kat_br=$kat_tab[$dane['id_kat']];
				while(!empty($kat_br)){
					if(!empty($kat)){
						$kat=" / ".$kat;
					}
					$kat=$kat_br['tytul'].$kat;
					
					if(!empty($kat_br['id_matka'])&&!empty($kat_tab[$kat_br['id_matka']])){
						$kat_br=$kat_tab[$kat_br['id_matka']];
					} else {
						break;
					}
				
				}
				
			}
			
			echo $kat;
			echo "</categoryId>";
			
			
			echo "<description><![CDATA[".htmlspecialchars(strip_tags($dane['opis'],""))."]]></description>";

			
			echo "<image>";
			if(!empty($dane['img'])&&!empty($dane['img1_w'])&&!empty($dane['img1_h'])&&!empty($dane['img1_nazwa'])){			
				echo konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("sklep_konf",'produkty_kat').$dane['img1_nazwa'];			
			}		
			echo "</image>";
			
			echo "<attributes>";
			
			echo "<attribute>";
			echo "<name>Producent</name>";
			echo "<value>".$dane['producent']."</value>";			
			echo "</attribute>";
			
			echo "<attribute>";
			echo "<name>Model</name>";
			echo "<value>".$dane['symbol']."</value>";			
			echo "</attribute>";			
					
			echo "</attributes>";
				
			echo "</offer>";

		}	
		
		konf::get()->_bazasql->fetchAssoc($zap);

		echo "</offers>";

		echo "</loadOffers>";
		echo "</pasaz:Body>";
		echo "</pasaz:Envelope>";	
	
	}
	
	
	public function wp(){

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "<!DOCTYPE pasaz:Envelope SYSTEM \"loadOffers.dtd\">";
		echo "<pasaz:Envelope xmlns:pasaz=\"http://schemas.xmlsoap.org/soap/envelope/\">";
  	echo "<pasaz:Body>";
    echo "<loadOffers xmlns=\"urn:ExportB2B\">";

    echo "<offers>";
		
  	$kat_tab=$this->pobierzKategorie();		
    $zap=konf::get()->_bazasql->zap("SELECT p.*, pr.nazwa AS producent FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." p LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." pr ON p.id_producent=pr.id LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k ON p.id_kat=k.id WHERE 1 AND p.opis!='' ".$this->sqlAddP()); 		

  	while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
    	echo "<offer>";
			
			echo "<id>".$dane['id']."</id>";
			echo "<name>".htmlspecialchars($dane['nazwa'])."</name>";
			echo "<price>".$dane['cena']."</price>";
			echo "<url>".$this->prodLink($dane,"","",false)."</url>";
			
			echo "<categoryId>";
			
			$kat="";
			
			if(!empty($kat_tab[$dane['id_kat']])){
				$kat_br=$kat_tab[$dane['id_kat']];
				while(!empty($kat_br)){
					if(!empty($kat)){
						$kat=" / ".$kat;
					}
					$kat=$kat_br['tytul'].$kat;
					
					if(!empty($kat_br['id_matka'])&&!empty($kat_tab[$kat_br['id_matka']])){
						$kat_br=$kat_tab[$kat_br['id_matka']];
					} else {
						break;
					}
				
				}
				
			}
			
			echo $kat;
			echo "</categoryId>";
						
			echo "<description><![CDATA[".htmlspecialchars(strip_tags($dane['opis'],""))."]]></description>";
			
			echo "<image>";
			if(!empty($dane['img'])&&!empty($dane['img1_w'])&&!empty($dane['img1_h'])&&!empty($dane['img1_nazwa'])){			
				echo konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("sklep_konf",'produkty_kat').$dane['img1_nazwa'];			
			}		
			echo "</image>";
			
			echo "<attributes>";
			
			echo "<attribute>";
			echo "<name>Producent</name>";
			echo "<value>".$dane['producent']."</value>";			
			echo "</attribute>";
			
			echo "<attribute>";
			echo "<name>Model</name>";
			echo "<value>".$dane['symbol']."</value>";			
			echo "</attribute>";			
					
			echo "</attributes>";
				
			echo "</offer>";

		}	
		
		konf::get()->_bazasql->fetchAssoc($zap);

		echo "</offers>";

		echo "</loadOffers>";
		echo "</pasaz:Body>";
		echo "</pasaz:Envelope>";	
	
	}	
		
		
	/**
   * class constructor php5	
   */	
	public function __construct() {	

		$this->_admin=konf::get()->getKonfigTab("sklep_konf",'admin_sklep');
		
		$id_kat=konf::get()->getZmienna("id_kat",'id_kat');				
		$id_produkt=konf::get()->getZmienna("id_produkt",'id_produkt');		
		
		if(empty($id_produkt)){
			$this->setKat($id_kat,true);
		} else {
			$this->setProd($id_produkt,true);		
		}
		
				
  }	
		
	
}

?>