<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

require_once(konf::get()->getKonfigTab('klasy')."class.modul.php");

class moduladmin extends modul {

	/**
	 * Privates variables
	 */		
		
	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="moduladmin class";

	
  /**
   * remove img files
   * @param array $dane
   * @param string $katalog
   * @param int $ile
   * @param string $nazwa
   */			
	protected function usunImg($dane,$katalog,$ile,$nazwa="img"){
	
		if(!empty($katalog)&&!empty($ile)){
		
			for($i=1;$i<=$ile;$i++){
		
		    if(!empty($dane[$nazwa.$i.'_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").$katalog.$dane[$nazwa.$i.'_nazwa'])){
		 			unlink(konf::get()->getKonfigTab("serwer").$katalog.$dane[$nazwa.$i.'_nazwa']); 
		 		}
				
			}
			
		}		
	
	}
	
	
  /**
   * change parameter
   * @param string $param
   * @param string $wartosc
   * @param string $tabela
   * @param string $log		
   * @param string $sql		
   * @param bool $komunikat				
   * @return bool							
   */		
	protected function zmienparam($param,$wartosc,$tabela="",$log="",$sql="",$komunikat=true){

		$ok=false;
		$id_tab=konf::get()->getZmienna('id_tab','id_tab');
		$wartosc=tekstForm::doSql($wartosc);		
		
		if(!empty($param)&&!empty($tabela)){
		
			if(!empty($id_tab)){			
				$query=tekstForm::tabQuery($id_tab);				
			}
				
			if(!empty($query)){
			
				konf::get()->_bazasql->zap("UPDATE ".$tabela." SET ".$param."='".$wartosc."' WHERE id IN (".$query.") ".$sql);
				if($komunikat){
					konf::get()->setKomunikat(konf::get()->langTexty("awykonana"),""); 
				}
				$ok=true;
				
				if($log){
					user::get()->zapiszLog($log,user::get()->login());
				}				
				
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),""); 
			}
			
		} else {
			trigger_error("zmienparam: invalid input values",E_USER_ERROR);			
		}
		
		return $ok;
		
	}	
	

  /**
   * remove standard records		
   * @param string $tabela
   * @param string $katalog
   * @param int $ile
   * @param string $nazwa	
   * @param string $log		
   * @param string $id_matka		
   * @param string $tabela_dziecko		
   * @param string $sql			
   * @return bool				
   */		
	protected function usunRekordy($tabela,$katalog="",$ile="",$nazwa="img",$log="",$id_matka="",$tabela_dziecko="",$sql=""){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');
		$query="";
		$ok=false;
		
		if($id_matka&&empty($tabela_dziecko)){
			$tabela_dziecko=$tabela;
		}

		if(!empty($tabela)){
			
			if(!empty($id_tab)){
			
				$query=tekstForm::tabQuery($id_tab);		
				
			}	
					
			//jeśli jest co usunac		
			if(!empty($query)){
			
				$query=" WHERE t.id IN (".$query.")".$sql;

				//jesli jest katalog na fotki		
				if(!empty($katalog)&&!empty($ile)){
					
					$sql="SELECT t.* FROM ".$tabela." t ";					
					if($id_matka){	
						$sql.=" LEFT JOIN ".$tabela_dziecko." z ON t.id=z.".$id_matka;
						$sql.=$query." AND z.id IS NULL ";						
					}	else {
						$sql.=$query;						
					}
						
					//pobierz dane
					$dane2=konf::get()->_bazasql->pobierzRekordy($sql);
					
					//usun pliki
					while(list($key,$dane)=each($dane2)){
						
						$this->usunImg($dane,$katalog,$ile,$nazwa);		
																					
					}
					
				}			

				$sql="DELETE t FROM ".$tabela." t ";
				if($id_matka){	
					$sql.=" LEFT JOIN ".$tabela_dziecko." z ON t.id=z.".$id_matka;		
					$sql.=$query." AND z.id IS NULL ";					
				}	else {
					$sql.=$query;						
				}

				konf::get()->_bazasql->zap($sql);
				konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),"");
				$ok=true;
				
			}	else {
				konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 
			}
			
			if($log){
				user::get()->zapiszLog($log,user::get()->login());	
			}
	 
		} else {
			trigger_error("usunRekordy: invalid tabela value",E_USER_ERROR);			
		}
		
		return $ok;
			
	}	
	
	/**
   * save data
   */		
	protected function zapisz(){
	
	}
	
	/**
   * add data
   */		
	public function dodaj2(){	
		$this->zapisz();
	}
	
	
	/**
   * edit data
   */		
	public function edytuj2(){	
		$this->zapisz();
	}	
	
	/**
   * sform data
   */		
	protected function formularz(){
	
	}	

	/**
   * sklep add
   */		
	public function dodaj(){	
		$this->formularz();
	}
	
	
	/**
   * sklep edit
   */		
	public function edytuj(){	
		$this->formularz();
	}	
		

	/**
   * class constructor php5	
   */	
	public function __construct() {	

  }	
	
}	

?>