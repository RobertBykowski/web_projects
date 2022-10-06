<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

include_once(konf::get()->getKonfigTab('mod_kat')."art/konfig_inc.php");			

class artdziennik extends modul  {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="artdziennik class";

	/**
	 * id art
	 */				
  private $_artId="";		
	
	
  /**
   * akapit write
   * @param array $dane
   * @param array $dane2		
   * @param array $galeria	
   * @param array $przenies		
   */				
	public function akapit($dane,$dane2){
	
		$akapit=new akapitForm($dane2['tresc'],$dane['typ'],$dane2['tytul']);
		
		if($dane2['img1_nazwa']){
			$akapit->setImgNazwa(konf::get()->getKonfigTab("art_konf",'akapity_kat').$dane2['img1_nazwa']);						
			$akapit->setImgW($dane2['img1_w']);
			$akapit->setImgH($dane2['img1_h']);					
			$akapit->setImgLink($dane2['img_link']);						
			$akapit->setImgLinkOkno($dane2['img_link_okno']);	
			$akapit->setImgOpis($dane2['img_opis']);	
			$akapit->setImgAlign($dane2['img_align']);						
			$akapit->setImgClass("obrazek");
		}
		$akapit->setDane($dane2);							
		$akapit->setAkapitClass("nowa_l");					
		$akapit->setLiniaZnakow(konf::get()->getKonfigTab("art_konf",'linia_znakow'));
		$akapit->setAutolink(konf::get()->getKonfigTab("art_konf",'autolink'));		

		echo $akapit->zwrot();	
	
	}
	


  /**
   * okresla dostep do artykulu
   * @param int $typ
   * @return bool
   */			
	public function dostep($typ=0){

		$dostep=true;
		
		if(!$this->admin()){
		
			switch($typ){
			
				case '1':
					if(!user::get()->zalogowany()){
						$dostep=false;
					}
				break;
				
				case '2':
					if(!$this->uprawniony()){
						$dostep=false;
					}
				break;				
				
			}
		
		}
			
		return $dostep;
				
	}
	
	
  /**
   * art
   */		
	public function zobacz(){

	  $podstrona=konf::get()->getZmienna('podstrona','podstrona');	
	  $id_nr=konf::get()->getZmienna('id_nr','id_nr');	
		$dziennik_tab=konf::get()->getKonfigTab('art_konf','dziennik_tab');						
	  $colspan=2;
		
	  echo tab_nagl("Dziennik zmian - archiwalna wersja artykułu",2);		
		
		if(!empty($id_nr)){			
		
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'artd')." WHERE id='".$id_nr."'"); 
			
		}

		if(!empty($dane)){

			$link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"));		 
			
	    echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4\">";
			
			echo "<div class=\"grube\">";
			echo $dane['tytul'];
			echo "</div>";		
			
			if(konf::get()->getKonfigTab("art_konf",'podtytul')&&!empty($dane['podtytul'])){
		    echo "<div class=\"podtytul\">".$dane['podtytul']."</div>";	
			}								
					
			echo "<div>data akcji: <span class=\"grube\">".$dane['akcja_data']."</span></div>";
			
			echo "<div>wykonał: <span class=\"grube\">";
			if(user::get()->adminU()){
				echo "<a href=\"".$link3."&amp;id_u=".$dane['akcja_autor_id']."\">";
			}
			echo $dane['akcja_autor'];
			if(user::get()->adminU()){
				echo "</a>";
			}
			echo "</span></div>";
			
			if(!empty($dziennik_tab[$dane['akcja']])){
				echo "<div>typ akcji: <span class=\"grube\">".$dziennik_tab[$dane['akcja']]."</span></div>";
			}			
			
			echo "</td></tr>";
			
	    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapityd')." WHERE id_artd='".$id_nr."'";

			$naw = new nawig("SELECT COUNT(id) AS ilosc".$query,$podstrona,$dane['na_str']);		
			$naw->naw(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja(),"id_nr"=>$id_nr)));				
			$podstrona=$naw->getPodstrona();	
								
			if($naw->getNaw()){
				echo "<tr><td style=\"padding:5px\" class=\"tlo3\" colspan=\"".$colspan."\">".$naw->getNaw()."</td></tr>";
			}	
	    
	    $query="SELECT * ".$query." ORDER BY nr_poz,id ";
			
			if(!empty($dane['na_str'])){
				$query.="LIMIT ".$naw->getStart().",".$naw->getIle();
			}
	  	
	    $zap2=konf::get()->_bazasql->zap($query);			
				      
			//licznik petli
			$i=0;
			
			$ile=konf::get()->_bazasql->numRows($zap2);
			
			require_once(konf::get()->getKonfigTab('klasy')."class.akapitform.php");	
			
			//przelatujemy akapity
			$dane_akapitow=array();

			//pobierz akapity
			while($dane2=konf::get()->_bazasql->fetchAssoc($zap2)){
				$dane_akapitow[$dane2['id']]=$dane2;			
			}
	 		konf::get()->_bazasql->freeResult($zap2);	

			echo "<tr><td class=\"tlo3\" colspan=\"".$colspan."\">";	
			
			reset($dane_akapitow);
			while(list($key,$dane2)=each($dane_akapitow)){					

				$i++;
					
				echo $this->akapit($dane,$dane2);				

			}
			
	    echo "<div class=\"nowa_l\" style=\"padding:10px\">";
	   
			if(empty($dane['stopka_nie'])){
		    if(konf::get()->getKonfigTab("art_konf",'arch_szczegoly')){
					echo interfejs::autor($dane);
		  	}  
		  	if(konf::get()->getKonfigTab("art_konf",'wytworzyl')&&$dane['wytworzyl']){	
	    	  echo konf::get()->langTexty("art_wytworzyl")."<span class=\"grube\"> ".$dane['wytworzyl_data']." ".$dane['wytworzyl']."</span><br />";												
				}
	  	  //licznik    
	    	if(konf::get()->getKonfigTab("art_konf",'wys_licznik')){
	    	  echo konf::get()->langTexty("art_ileo")." <span class=\"grube\">".$dane['licznik']."</span><br />";
	    	}
				
	    }
			
			echo "</div>";			
			
			echo "</td></tr>";

			if($naw->getNaw()){
				echo "<tr><td style=\"padding:5px\" class=\"tlo3\" colspan=\"".$colspan."\">".$naw->getNaw()."</td></tr>";
			}	

			echo "<tr class=\"srodek\">";
			echo "<td class=\"tlo4\" style=\"width:50%\"><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_zobacz","id_art"=>$dane['id_art']))."\">Aktualna wersja</a></td>";
			echo "<td class=\"tlo4\" style=\"width:50%\"><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artdziennik_arch","id_art"=>$dane['id_art']))."\">Repozytorium artykułu</a></td>";
			echo "</tr>";		
			
			//k dostep  	
	  } else { 
			echo "<tr><td colspan=\"".$colspan."\" class=\"grube srodek tlo3\">Brak danych</td></tr>"; 
		}
		
		echo tab_stop();
				
	}
	

	//wyswietla dziennik zmian
	public function arch(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$dziennik_tab=konf::get()->getKonfigTab('art_konf','dziennik_tab');		
		$na_str=15;
		
		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'artd')." WHERE 1 ";
		if(!empty($this->_artId)){ 
			$query.=" AND id_art='".$this->_artId."'"; 
		}
		
		echo tab_nagl("Repozytorium zmian: ",1);
		
		if(!empty($this->_artId)){
		
			$art=new art();			
			$dane2=$art->pobierz($this->_artId,true,true);
			if(!empty($dane2)){
				echo "<tr><td class=\"tlo4\">artykuł: <span class=\"grube\">".$dane2['tytul']."</span></td></tr>";
			}
			
		}
		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artdziennik_arch","id_art"=>$this->_artId));	
		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artdziennik_zobacz"));	
		$link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"));	
		
		$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,$na_str);		
		$naw->naw($link);
		$podstrona=$naw->getPodstrona();			

		if($naw->getWynikow()>0){
		
			if($naw->getNaw()){
				echo "<tr><td class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}	

			$zap=konf::get()->_bazasql->zap("SELECT * ".$query." ORDER BY id DESC LIMIT ".$naw->getStart().",".$naw->getIle());

			$i=0;
			
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			
				echo "<tr><td class=\"tlo3\">";

				echo "<div class=\"grube\">".$dane['akcja_data']." ";
				if(user::get()->adminU()){
					echo "<a href=\"".$link3."&amp;id_u=".$dane['akcja_autor_id']."\">";
				}
				echo $dane['akcja_autor'];
				if(user::get()->adminU()){
					echo "</a>";
				}
				echo "</div>";
				if(!empty($dziennik_tab[$dane['akcja']])){
					echo "<div>".$dziennik_tab[$dane['akcja']]."</div>";
				}			
				echo "<div><a href=\"".$link2."&amp;id_nr=".$dane['id']."\">";
				echo $dane['tytul'];
				echo "</a></div>";
				echo "</td></tr>";			
			}
			if($naw->getNaw()){
				echo "<tr><td class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}	
			
			konf::get()->_bazasql->freeResult($zap);

		} else { 
		
			echo "<tr><td class=\"tlo3 srodek grube\" style=\"padding:10px;\">Brak danych</td></tr>"; 
			
		}

		echo tab_stop();

	}	
	

	/**
   * class constructor
   */	
	public function __construct() {	
	
		$this->_artId=konf::get()->getZmienna("id_art",'id_art');		

  }	
		
	
}

?>