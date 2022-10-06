<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

include_once(konf::get()->getKonfigTab('mod_kat')."koment/konfig_inc.php");

class koment extends modul {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="koment class";
	
	
	/**
	 * typ
	 */				
  private $_typ="";		
	
	
	/**
	 * id matka
	 */				
  private $_id="";			
	
	
	/**
	 * variables
	 */				
  private $_przenies=array();		
		
	
	/**
	 * typ
	 */				
  private $_mysql="";			
	
	
	/**
	 * sql add
	 */				
  private $_sqladd="";			
	
	/**
	 * moderator wlasnego dzialu
	 */				
  private $_moderator=false;			
	
  /**
   * Set typ
   * @param string $typ
   */
  public function setTyp($typ) {
	
		$typy_tab=konf::get()->getKonfigTab('koment_konf','typy_tab');
		
		if(empty($typ)){
			$typ=konf::get()->getZmienna('koment_typ','koment_typ');
		}
	
  	if(!empty($typ)&&!empty($typy_tab[$typ])){
		
			$konfiguracja=konf::get()->getKonfigTab('koment_konf');
			$konfiguracja=array_merge($konfiguracja,$typy_tab[$typ]);
			konf::get()->setKonfigTab(array("koment_konf"=>$konfiguracja));

			$this->_typ=$typ;
			
			if(!empty($typy_tab[$typ]['mysql'])){
				$this->_mysql=$typy_tab[$typ]['mysql'];
			} else {
				trigger_error("setTyp: invalid mysql value ".$this->getNazwaKlasy(),E_USER_ERROR);			
			}
			
			if(isset($typy_tab[$typ]['admin'])){
				$this->_admin=$typy_tab[$typ]['admin'];
			}			
			
		} else {
			trigger_error("setTyp: invalid typ value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }			
	
	
  /**
   * Set id
   * @param int $id
   */
  public function setId($id="") {
	
		if(empty($id)){
			$id=konf::get()->getZmienna('id','id');
		}		

		if(!empty($id)){
			$this->_id=$id;
			$this->_przenies['id']=$this->_id;					
		} else {
			trigger_error("setId: invalid id value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }			
	
	
  /**
   * Set przenies
   * @param array $przenies
   */
  public function setPrzenies($przenies) {
	
		if(!empty($przenies)&&is_array($przenies)){
			$this->_przenies=$przenies;
		}
		if($this->_id){
			$this->_przenies['id']=$this->_id;				
		}		
		$this->_przenies['akcja2']=konf::get()->getAkcja();
		$this->_przenies['koment_typ']=$this->_typ;		
		
  }		
	
	
  /**
   * Set moderator
   * @param bool $moderator
   */
  public function setModerator($moderator) {
	
		if(!empty($moderator)){
			$this->_moderator=true;
		} else {
			$this->_moderator=false;		
		}
		
  }			
	
	
  /**
   * Set moderator sql add
   * @param bool $moderator sql add
   */
  public function setSqlAdd($sqladd) {
	
		$this->_sqladd=$sqladd;
		
  }				
	
			
  /**
   * moderator
   * @return bool			
   */	
	public function moderator(){

		return $this->_moderator;
		
	}
			
		
  /**
   * check ok
   * @return bool	
   */
  public function ok() {
		
		$ok=false;
		
		if($this->_typ&&$this->_mysql&&$this->_id){
			$ok=true;
		}
		
		return $ok;
		
  }				
		
  /**
   * admin guestbook
   * @return bool			
   */	
	public function admin(){

		return $this->_admin;
		
	}

  /**
   * komentarze form
   */	
	public function formularz(){

	  $koment_login=konf::get()->getZmienna('','','koment_login');

		if($this->ok()&&konf::get()->getKonfigTab("koment_konf",'form_dostep')){
		
			echo tab_nagl(konf::get()->langTexty("koment_dodaj"),1);
			
			echo "<tr><td class=\"tlo3\">";

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"koment","koment");

			if(user::get()->zalogowany()){
				echo $form->spr(array(1=>"tresc"));		
			} else {
				echo $form->spr(array(1=>"autor",2=>"tresc"));		
			}
			
			echo $form->getFormp();
			echo $form->przenies($this->_przenies);
			echo $form->input("hidden","akcja","","koment_dodaj","","");		
				
			echo "<div>";
			if(user::get()->zalogowany()){
				echo konf::get()->langTexty("koment_autor")." <span class=\"grube\">".user::get()->login()."</span>";
			} else {
				echo $form->input("text","autor","autor",$koment_login,"f_dlugi",20);						
				echo interfejs::label("autor",konf::get()->langTexty("koment_autor"),"grube",true);
			}
			echo "</div>";
			
			echo interfejs::label("tresc",konf::get()->langTexty("koment_tresc"),"block grube",true);	
			echo "<br />";				
			echo $form->textarea("tresc","tresc","","f_bdlugi",7);	
			echo "<br />";
			
			if(konf::get()->getKonfigTab("koment_konf",'emotikony')){
		    require_once(konf::get()->getKonfigTab("klasy")."class.emotikony.php");			
				$emotikony=new emotikony();							
			  echo $emotikony->wyswietl("koment","tresc");
			}
			if(konf::get()->getKonfigTab("koment_konf",'limit_znakow')){
				echo $form->skrocTxt("tresc",konf::get()->getKonfigTab("koment_konf",'limit_znakow'));
			}
			
			if(!user::get()->zalogowany()&&konf::get()->getKonfigTab("koment_konf",'botproof')){
				echo $form->bootproof();
			}					
			
	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div>";
					
			echo $form->getFormk();
			
			echo "</td></tr>";
			
			echo tab_stop();		
			
		} else {
	     echo "<div class=\"srodek\" style=\"padding:10px\">".konf::get()->langTexty("koment_musisz")."</div>";
	  }
	}
	
	
  /**
   * komentarze wyswietl
   */		
	public function wyswietl(){

	  $podstrona_kom=konf::get()->getZmienna('podstrona_kom','podstrona_kom');	
	  $koment_login=konf::get()->getZmienna('','','koment_login');

		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),$this->_przenies);
		$link.="&amp;akcja=".konf::get()->getAkcja();
			
	  if($this->ok()){
		
			$usuwanie=$this->admin()||(konf::get()->getKonfigTab("koment_konf",'moderator')&&$this->sprModerator());
		
			$query=" FROM ".konf::get()->getKonfigTab("koment_konf",'mysql')." WHERE id_matka='".$this->_id."'";
			
			if(!$this->admin()){	
				$query.=" AND status=1 ";
			}
					
		  if(konf::get()->getKonfigTab("koment_konf",'na_str')){
				$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona_kom,konf::get()->getKonfigTab("koment_konf",'na_str'));
				$naw->naw($link,"podstrona_kom");
				$podstrona_kom=$naw->getPodstrona();	
	  	} 		
		
			if($usuwanie){		
						
				$form=new formularz("post",konf::get()->getKonfigTab("plik"),"koment_arch","koment_arch");					
				echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjakom(document.koment_arch.akcja,'koment_usun','".konf::get()->langTexty("czyusun")."'); ");					
				echo $form->getFormp();	
				echo $form->przenies($this->_przenies);
				echo $form->input("hidden","akcja","akcja","koment_usun","","");		
				echo $form->input("hidden","podstrona_kom","podstrona_kom",$podstrona_kom,"","");		
												
			}
			
		  $query="SELECT * ".$query." ORDER BY ".konf::get()->getKonfigTab("koment_konf",'order');
			
			if(konf::get()->getKonfigTab("koment_konf",'na_str')){	
				$query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
			}
		
		  $zap=konf::get()->_bazasql->zap($query);
			
			if(konf::get()->getKonfigTab("koment_konf",'na_str')){
				echo tab_nagl(konf::get()->langTexty("koment_tytul")." (".$naw->getWynikow().")",1);				
			} else {
				echo tab_nagl(konf::get()->langTexty("koment_tytul")." (".konf::get()->_bazasql->numRows($zap).")",1);	
			}			

	  	if(konf::get()->_bazasql->numRows($zap)>0){

		  	if(konf::get()->getKonfigTab("koment_konf",'na_str')){
					if($naw->getNaw()){
			  		echo "<tr><td class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
					}
	  		}
				
	  		if(konf::get()->getKonfigTab("koment_konf",'emotikony')){	
					require_once(konf::get()->getKonfigTab('klasy')."class.emotikony.php");			
					$emotikony=new emotikony();					
				}
								
		  	while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				
	  			echo "<tr><td class=\"tlo3\">";
					if($usuwanie){	
						echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");					
		  		}
	  			echo "<div><span class=\"grube\">".$dane['autor_name']."</span>, <span class=\"male\"> ".$dane['autor_kiedy'];
					if(konf::get()->getKonfigTab("koment_konf",'wys_ip')){
						echo " (".$dane['ip'].")";
					}
					echo "</span></div><br/>";
		  		if(konf::get()->getKonfigTab("koment_konf",'linia_znakow')){
	  				$dane['tresc']=tekstForm::zlamStringa($dane['tresc'],konf::get()->getKonfigTab("koment_konf",'linia_znakow'),true,konf::get()->getKonfigTab("koment_konf",'autolink'));
		  		}
					
	  			if(konf::get()->getKonfigTab("koment_konf",'emotikony')){				
	          $dane['tresc']=$emotikony->rysuj($dane['tresc']);					
	  			}
					
		  		echo $dane['tresc'];
	  			echo "<br /></td></tr>";
		  	}
				
		  	if(konf::get()->getKonfigTab("koment_konf",'na_str')){
					if($naw->getNaw()){
			  		echo "<tr><td class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
					}
	  		}
				
				if($usuwanie){	
		  		echo "<tr><td class=\"tlo3 lewa\">";
					echo $form->input("submit","","",konf::get()->langTexty("koment_usun"),"formularz2 f_sredni");						
		  		echo "</td></tr>";
		  	}
				
	  	} else {
				echo "<tr><td class=\"brak\">Brak komentarzy</td></tr>";
			}
		  konf::get()->_bazasql->freeResult($zap);
			
			echo tab_stop();	
			
			if($usuwanie){		
				echo $form->getFormk();		
			}	
	  }
		
	}

	
  /**
   * komentarze dodaj
   */	
	public function dodaj(){
	
		$this->setId();
	
	  if($this->ok()){
	
		  $tresc=konf::get()->getZmienna('tresc');	
		  $autor=konf::get()->getZmienna('autor');	
		  $akcja2=konf::get()->getZmienna('akcja2');	
				
			if(!empty($akcja2)){
				konf::get()->setAkcja($akcja2);
			} else {
				konf::get()->setAkcja("");
			}	

			if(user::get()->zalogowany()){
				$autor=user::get()->nazwa();
			}
			
		  $autor=tekstForm::doSql($autor);	
					
			if(konf::get()->getKonfigTab("koment_konf",'limit_znakow')){
				$tresc=substr($tresc,0,konf::get()->getKonfigTab("koment_konf",'limit_znakow'));
			}
			
			$tresc=tekstForm::doSql($tresc);	

			konf::get()->zapiszCookie('koment_login',$autor,3600*24*konf::get()->getKonfigTab("koment_konf",'cookie'),"/");
			
			if(user::get()->zalogowany()||!konf::get()->getKonfigTab("koment_konf",'botproof')||(konf::get()->getKonfigTab("koment_konf",'botproof')&&konf::get()->botProofCheck(true))){
			
				if(!empty($autor)&&!empty($tresc)&&konf::get()->getKonfigTab("koment_konf",'form_dostep')){

					if(!konf::get()->getKonfigTab("koment_konf",'spr_bylo')||konf::get()->_bazasql->policz("id"," FROM ".$this->_mysql." WHERE id_matka='".$this->_id."' AND autor_id='".user::get()->id()."' AND autor_name='".$autor."' AND tresc='".$tresc."'")==0){
						konf::get()->_bazasql->zap("INSERT INTO ".$this->_mysql." (id_matka,autor_id,autor_name,autor_kiedy,tresc,ip,host,status) VALUES('".$this->_id."', '".user::get()->id()."', '".$autor."', NOW(), '".$tresc."', '".konf::get()->getIp()."', '".konf::get()->getHost()."','".konf::get()->getKonfigTab("koment_konf",'status')."')");
						konf::get()->setKomunikat(konf::get()->langTexty("koment_zapisane"),"");
				  } else { 
						konf::get()->setKomunikat(konf::get()->langTexty("koment_istnieje"),"error"); 
					}
					
				}
				
			}
			
		}

	}


  /**
   * komentarze usun
   */	
	public function usun(){
	
		$this->setId();

		if($this->ok()&&($this->admin()||(konf::get()->getKonfigTab("koment_konf",'moderator'))&&$this->sprModerator())){

		  $id_tab=konf::get()->getZmienna('id_tab','id_tab');
		  $akcja2=konf::get()->getZmienna('akcja2','akcja2');

			if(!empty($id_tab)&&is_array($id_tab)){
			
				$query=tekstForm::tabQuery($id_tab);
			
				if(!empty($query)){
					$sql="DELETE FROM ".$this->_mysql." WHERE id IN (".$query.") AND id_matka='".$this->_id."'";
					if(!$this->admin()){
						$sql.=$this->_sqladd;
					}
					konf::get()->_bazasql->zap($sql);
					user::get()->zapiszLog(konf::get()->langTexty("koment_usuwanie_log"),user::get()->login());
					konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),"");
				} else {
					konf::get()->setKomunikat(konf::get()->langTexty("usuwaniebrak"),"error");	
				} 
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("usuwaniebrak"),"error"); 								
			}
			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 				
		}
						
		if(!empty($akcja2)){
			konf::get()->setAkcja($akcja2);
		} else {
			konf::get()->setAkcja("");
		}		
					
		
	}
	
	private function sprModerator(){
	
		$ok=false;
		
		switch($this->_typ){
		
			case 1:
				$ok=false;
			break;				
		
			case 2:
				$ok=(user::get()->id()==$this->_id);
			break;						
		
			case 3:
				$ok=konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria')." WHERE id='".$this->_id."' AND id_matka='".user::get()->id()."'");
			break;
			
			case 4:
				$ok=konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria')." WHERE id='".$this->_id."' AND id_matka='".user::get()->id()."'");
			break;			
		
		}
		
		return $ok;
	
	}

	
	/**
   * class constructor php5	
   * @param int $typ
   */	
	public function __construct($typ="") {	

		$this->setTyp($typ);		
		$this->_admin=konf::get()->getKonfigTab("koment_konf",'admin');		
		$this->_moderator=konf::get()->getKonfigTab("koment_konf",'moderator');		
		$this->setSqlAdd(konf::get()->getKonfigTab("koment_konf",'sqladd'));		
		
  }	

}

?>