<?php

/**
 * wytnijWklej class v1.0
 * dla CMS i innych klas - wycinanie, wklejanie dla struktur drzewiastych
 * All rights reserved
 * @package wytnijWklej class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2007 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  require_once("class.wytnijWklej.php");
	$poz=new wytnijWklej("art","sklep_tabela_kat",$id_d,true);
	$poz->wykonaj();
	
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

	
class wytnijWklej {

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */
		
	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="wytnijWklej class";
		
	/**
	 * dzial
	 */					
	private $_id_d="";		
	
	/**
	 * dzialy tablica
	 */					
	private $_d_tab="";			
	
	/**
	 * pole session tab
	 */					
	private $_tab="";					
	
	/**
	 * czy sprawdzac lang
	 */					
	private $_lang=true;					
	
	/**
	 * id do ktorego wklejamy
	 */					
	private $_id=0;		
	
	/**
	 * query add
	 */					
	private $_queryAdd="";		
	
	/**
	 * tabela sql
	 */					
	private $_tabela="";
			
	/**
	 * pole matka
	 */					
	private $_poleMatka="id_matka";			
	
	/**
	 * pole pozycja
	 */					
	private $_polePoz="nr_poz";			
	
	/**
	 * pole poziom
	 */					
	private $_polePoziom="poziom";			
	
	/**
	 * pole id
	 */					
	private $_poleId="id";			
	
	/**
	 * czy istnieje pole najwyzszego elementy
	 */					
	private $_polePierwszy="id_pierwszy";				
	
	/**
	 * pole dzialu
	 */					
	private $_poleDzial="id_d";				
	
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
	
		return $this->_nazwaKlasy;
		
	}		
	
	
  /**
   * Set tab
   * @param string $nazwa
   * @param string $wartosc		
   */
  public function setPole($nazwa,$wartosc) {

		if(!empty($nazwa)){
			$nazwa="_".$nazwa;
			if(isset($this->$nazwa)){
				$this->$nazwa=$wartosc;
			} else {
				trigger_error("setTab: invalid nazwa value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}		

		} else {
			trigger_error("setTab: invalid nazwa value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
				
  }		
		
	
  /**
   * Set id_d
   * @param int $id_d
   */
  public function setIdD($id_d) {
	
		$id_d=$id_d+0;		

		if(is_int($id_d)&&$id_d>0){
			$id_d=tekstForm::doSql($id_d);
    	$this->_id_d=$id_d;
		} else {
			trigger_error("setIdD: invalid id value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
				
  }	
	
  /**
   * Set lang
   * @param bool $lang
   */
  public function setLang($lang) {

		if(!empty($lang)){
	    $this->_lang=true;
		} else {
	    $this->_lang=false;
		}		
				
  }						
	
  /**
   * Set id
   * @param int $id
   */
  public function setId($id) {
	
		$id=$id+0;	

		if(is_int($id)&&$id>=0){
			$id=tekstForm::doSql($id);
    	$this->_id=$id;
		} else {
    	$this->_id=0;		
		}
			
  }						
	
  /**
   * Set queryAdd
   * @param string $queryAdd
   */
  public function setQueryAdd($queryAdd) {

    $this->_queryAdd=$queryAdd;

  }		
	
  /**
   * Set tabela
   * @param string $tabela
   */
  public function setTabela($tabela) {

		if(!empty($tabela)){
	    $this->_tabela=$tabela;
		} else {
			trigger_error("setTabela: invalid tabela value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
						
  }		
	
  /**
   * Set tab session name
   * @param string $tab
   */
  public function setTab($tab) {

		if(!empty($tab)){
	    $this->_tab=$tab;
		} else {
			trigger_error("setTab: invalid tab value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
						
  }			
	
  /**
   * Set dzialy
   * @param string $d_tab
   */
  public function setDzialy($d_tab) {

		if(!empty($d_tab)&&is_array($d_tab)){
	    $this->_d_tab=$d_tab;
		} else {
			trigger_error("setDzialy: invalid d_tab value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
  }		
				
	
	/**
   * move subelements
   * @param string $query
   * @param int $poziom
   * @param int $id_pierwzy	
   */		
	private function przeniesPodelementy($query,$poziom=0,$id_pierwszy=0){

	  $poziom=$poziom+1;
		
		$warunek=" WHERE ".$this->_poleMatka." IN (".$query.") ";
		if($this->_lang){
			$warunek.=" AND lang='".konf::get()->getLang()."'";
		}

		$query2="UPDATE ".$this->_tabela." SET ".$this->_polePoziom."=".$poziom;
		if($this->_poleDzial&&$this->_id_d){
			$query2.=",".$this->_poleDzial."='".$this->_id_d."'";	
		}
		if($this->_polePierwszy){
			$query2.=", ".$this->_polePierwszy."=".$id_pierwszy;
		}
		
		$query2.=" ".$warunek;

	  konf::get()->_bazasql->zap($query2);
	  
	  $zap=konf::get()->_bazasql->zap("SELECT ".$this->_poleId." FROM ".$this->_tabela." ".$warunek);
	  
	  $query="";  
		
	  while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
	    if($query!=""){
	      $query.=",";    
	    }
	    $query.=$dane[$this->_poleId];
	  }  
	  konf::get()->_bazasql->freeResult($zap);
		
	  if(!empty($query)){
	    $this->przeniesPodelementy($query,$poziom,$id_pierwszy);
	  }

	}
	
	/**
   * sprawdza czy nowy dzial nie jest potomkiem przenoszonego
   * @param int $przenoszony
   * @param int $nowy		
   */		
	private function podrzedny($przenoszony,$nowy){

	  $ok=true;
	  
	  if($przenoszony!=$nowy&&!empty($nowy)){  
	  
	    //pobieramy matke sprawdzanego 
	    $dane=konf::get()->_bazasql->pobierzRekord("SELECT ".$this->_poleMatka." FROM ".$this->_tabela." WHERE ".$this->_poleId."='".$nowy."'");
	    
	    //jesli matka nie jest pusta to badamy w glab
	    if(!empty($dane)&&!empty($dane[$this->_poleMatka])){
	      $ok=$this->podrzedny($przenoszony,$dane[$this->_poleMatka]);
	    }  
			  
	  } else if (!empty($nowy)){
	    $ok=false;
	  }
		
	  return $ok;
		
	}

	
	/**
   * get dane
   * @param int $id
   */			
	public function pobierz($id){

		$dane="";
		
		if(!empty($id)){
	    $sql="SELECT * FROM ".$this->_tabela." WHERE ";
			$sql.=" ".$this->_poleId."='".$id."'";
	    if($this->_lang){
	      $sql.=" AND lang='".konf::get()->getLang()."'";
	    }
			$sql.=$this->_queryAdd;
			
			$dane=konf::get()->_bazasql->pobierzRekord($sql);
		}
		
		return $dane;
		
	}	
	
	
	/**
   * paste
   * @param id $id_kat	
   */		
	public function wklej($id_kat=""){
	
		//dane do przeniesienia
	  $tab=tekstForm::doSql(konf::get()->getZmienna('','',$this->_tab));

		//sprawdzamy czy sa dane
		if(!empty($tab)&&is_array($tab)){
		
			$this->setId($id_kat);
		
			//id najwyzszego elementu w strukturze
			$id_pierwszy=0;	
			
			//poziom w strukturze	
			$poziom=0;
			
		  //pobieramy nowe dane
		  if(!empty($this->_id)){
			
				$this->_id;
			
	  		$dane=$this->pobierz($this->_id);	
				
				if(!empty($dane)){		
										
	      	$poziom=$dane[$this->_polePoziom]+1;	
					
					if($this->_polePierwszy){
					
						//dla poziomu zerowego zerowy element najwyzszy w struktuze
						if($dane[$this->_polePoziom]==0){
							$id_pierwszy=$dane[$this->_poleId];			
						} else {
						//dla wyzszych poziomow element najwyzszy pobrany od rodzica
							$id_pierwszy=$dane[$this->_polePierwszy];						
						}
						
					}
					
				} else {
					$this->_id=0;
				}
				
	  	}
			
	  	if(empty($this->_d_tab[$this->_id_d])){
	      $this->_id_d="";
	  	}
			

	  	//gdy istnieje strona i jest w tej samej wersji jezykowej lub gdy istnieje dzial
			if(!empty($dane)||($this->_id==0&&$this->_id_d)){
			
			  //licznik
			  $i=0;
			  
			  //zmienna kontrolna
			  $ok=true;
			  
			  $query="";
			  
			  //iteracja po tablicy danych
	      while(list($key,$val)=each($tab)){
	        
	        //jesli wszystko bylo ok   i niepuste   
	        if($ok&&!empty($val)){    
	                   
            //na pierwszym elemencie sprawdzamy przodkow
            if($i==0){
              $ok=$this->podrzedny($val,$id_kat);
            }
           
            if($ok){
            	if(!empty($query)){
            		$query.=",";
	            }
              $query.="'".$val."'";
            } else {
              konf::get()->setKomunikat(konf::get()->langTexty("admin_wklej_nie"),"error");	
            }

	        }  //koniec ok
	        
	        $i++;
	        
	      } //koniec while
				
	      reset($tab);
	      
	      //jesli prawidlowe dane to wykonujemy zapytanie;
	      if(!empty($query)){		

					$warunek=$this->_queryAdd;					
					if($this->_lang){
						$warunek.=" AND lang='".konf::get()->getLang()."' ";
					}
	
		    	$sql="SELECT MAX(".$this->_polePoz.") AS nr_poz FROM ".$this->_tabela." WHERE ".$this->_poleMatka."='".$id_kat."'";
					if($this->_poleDzial){
						$sql.=" AND ".$this->_poleDzial."='".$this->_id_d."'";
					}
					$sql.=$warunek;
										
	        //ustalamy nr porzadkowy - na koncu	    
	        $dane=konf::get()->_bazasql->pobierzRekord($sql);

	        //zawsze o 1 wiekszy od najwiekszego
	        if(!empty($dane)){
	          $nr=$dane[$this->_polePoz]+1;
	        } else {
	          $nr=1;
	        }
	        
	        $j=0;

			    //iteracja po tablicy danych
	        while(list($key,$val)=each($tab)){
						$sql="UPDATE ".$this->_tabela." SET ".$this->_polePoz."=".$nr.", ".$this->_poleMatka."='".$id_kat."'";
						if($this->_poleDzial){						
							$sql.=", ".$this->_poleDzial."='".$this->_id_d."'";
						}
						
						$sql.=", ".$this->_polePoziom."=".$poziom;
						if($this->_polePierwszy){							
							$sql.=", ".$this->_polePierwszy."='".$id_pierwszy."'";
						}
						
						$sql.=" WHERE ".$this->_poleId."='".$val."'".$warunek;

	          konf::get()->_bazasql->zap($sql);
						
	          $nr++;
	          $j++;
	        }
	        
	        //jesli wykonano to podstrony zmieniaja poziom
	        if($j>0){

						if(!empty($poziom)){
		          $this->przeniesPodelementy($query,$poziom,$id_pierwszy);
						} else {
							
							reset($tab);
							while(list($key,$val)=each($tab)){
			          $this->przeniesPodelementy($val,$poziom,$val);								
							}
						
						}
	          konf::get()->setKomunikat(konf::get()->langTexty("awykonana"),"");	
	      
	        }	else { 
						konf::get()->setKomunikat(konf::get()->langTexty("aniewykonana"),"error");	
					}
	      }	else { 
					konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
				}
			}	else { 
				konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
			}
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 
		}
		
		konf::get()->zapiszSession($this->_tab,"");
	  
	}


	/**
   * cut
   * @param array $id_tab
   */		
	public function wytnij($id_tab){

	  //czyscimy pamiec  
		konf::get()->zapiszSession($this->_tab,"");	
		
		//jesli dane to zapisujemy
	  if(!empty($id_tab)&&is_array($id_tab)){
			konf::get()->zapiszSession($this->_tab,$id_tab);	
	    konf::get()->setKomunikat(konf::get()->langTexty("admin_wklej_wyt"),"");
	  } else { 
			konf::get()->setKomunikat(konf::get()->langTexty("admin_wklej_brak"),"error"); 
		} 
		
	}
						
	/**
   * class constructor php5	
   * @param string $sql_tab
   * @param string $tab
   * @param int $id_d
   * @param bool $lang
   */	
	public function __construct($sql_tab,$tab,$id_d="",$lang=true) {	

		$this->setTabela($sql_tab);
		$this->setTab($tab);
		$this->setIdD($id_d);
		$this->setLang($lang);		
		
  }	

}


?>