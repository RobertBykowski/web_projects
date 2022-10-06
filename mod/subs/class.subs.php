<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


class subs extends modul {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="subs class";

		
  /**
   * add email
   */
	public function zapisz(){

		$subs_email=tekstForm::doSql(konf::get()->getZmienna('subs_email'));	
		$id_subs=tekstForm::doSql(konf::get()->getZmienna('id_subs'));			
		$typy_tab=konf::get()->getKonfigTab("subs_konf",'typy_tab');	
		
	  if(!empty($subs_email)&&!empty($id_subs)&&!empty($typy_tab[$id_subs])){
		
	    $subs_email=tekstForm::male($subs_email);
			
	    if(preg_match("/".tekstForm::getEmailForma()."/",$subs_email)){
	    
	      if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." WHERE email='".$subs_email."' AND idtf='".$id_subs."'")==0){

					$status=0;
					
	        if(konf::get()->getKonfigTab("subs_konf",'email_aktywny')){
						if(!konf::get()->getKonfigTab("subs_konf",'potwierdzony')){ 
	        		$status=1; 
	        	} else {
							$status=2;
						} 
	        }
	        
	        if($status==2){
	        	$gensid=$this->genSid(konf::get()->getKonfigTab("sql_tab",'subskrypcja'));
	        } else {
	        	$gensid="";
	        }
	        
	        konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." (idtf,id_u,email,data,ip,sprcheck,status) VALUES('".$id_subs."','".user::get()->id()."','".$subs_email."',NOW(),'".konf::get()->getIp()."','".$gensid."','".$status."')");
	        $id_nr=konf::get()->_bazasql->insert_id;

	        if(!empty($id_nr)){     
					   
		        konf::get()->setKomunikat(konf::get()->langTexty("subs_podany1")." ".$subs_email.konf::get()->langTexty("subs_podany2"),"");

		        if($status==2){
	       
		        	//autousuwanie przedawnionych emaili
							if(konf::get()->getKonfigTab("subs_konf",'autousuw')){
								konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." WHERE status=2 AND data<'".tekstForm::dniData(konf::get()->getKonfigTab("subs_konf",'autousuw'),"d","-")."'");
							}
							
			        $tresc=konf::get()->langTexty("subs_zapisz_e1")." ".konf::get()->getKonfigTab('nazwa_www')." ( ".konf::get()->getKonfigTab('adres_www')." )\n\n";
							$tresc.=konf::get()->langTexty("subs_zapisz_e2")." ".$subs_email." ".konf::get()->langTexty("subs_zapisz_e3")."\n";
							$tresc.="<a href=\"".konf::get()->getKonfigTab('adres_www').konf::get()->getKonfigTab("plik")."?akcja=subs_potwierdz&id_nr=".$id_nr."&subs_check=".$gensid."\">".konf::get()->getKonfigTab('adres_www').konf::get()->getKonfigTab("plik")."?akcja=subs_potwierdz&id_nr=".$id_nr."&subs_check=".$gensid."</a>\n\n";
							
							require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");
																
							$wyslij=new wyslijemail(konf::get()->langTexty("subs_zapisz_et"),$tresc,$subs_email);
							$wyslij->setNadawca(konf::get()->getKonfigTab('admin_email'),konf::get()->getKonfigTab('nazwa_www'));	
							$wyslij->wykonaj();			
							
							konf::get()->setKomunikat(konf::get()->langTexty("subs_zapisz_aby"),"");	
											
	      		}  
						
		      } else { 
						konf::get()->setKomunikat(konf::get()->langTexty("subs_zapisz_nie"),"error"); 
					} 	      
					
	      } else { 
					konf::get()->setKomunikat(konf::get()->langTexty("subs_zapisz_istnieje")." ".$subs_email." ".konf::get()->langTexty("subs_zapisz_istnieje2"),"error"); 
				} 
	       
	    } else { 
				konf::get()->setKomunikat(konf::get()->langTexty("subs_zapisz_niepr1")." ".$subs_email." ".konf::get()->langTexty("subs_zapisz_niepr2"),"error"); 
			}
			
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("subs_zapisz_niepr1")." ".$subs_email." ".konf::get()->langTexty("subs_zapisz_niepr2"),"error"); 
		}
		
	}


  /**
   * remove email
   */
	public function wypisz(){

		$subs_email=tekstForm::doSql(konf::get()->getZmienna('subs_email'));	
		$id_subs=tekstForm::doSql(konf::get()->getZmienna('id_subs'));			
		$typy_tab=konf::get()->getKonfigTab("subs_konf",'typy_tab');	

	  if(!empty($subs_email)&&!empty($id_subs)&&!empty($typy_tab[$id_subs])&&konf::get()->getKonfigTab("subs_konf",'zapisz_wypisz')){
		
		  $subs_email=tekstForm::male($subs_email);
	 	
	  	if(konf::get()->getKonfigTab("subs_konf",'potwierdzony')){
			
		    $dane=konf::get()->_bazasql->pobierzRekord("SELECT id FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." WHERE idtf='".$id_subs."' AND email='".$subs_email."'");
				
		    if(!empty($dane)){
				
		    	$gensid=$this->genSid(konf::get()->getKonfigTab("sql_tab",'subskrypcja'));
					
		    	if(!empty($gensid)){
					
				    konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." SET status=3, data=NOW(), sprcheck='".tekstForm::doSql($gensid)."' WHERE id='".$dane['id']."'");
					  $tresc=konf::get()->langTexty("subs_wypisz_e1")." ".konf::get()->getKonfigTab('nazwa_www')." ( ".konf::get()->getKonfigTab('adres_www')." )\n\n";
						$tresc.=konf::get()->langTexty("subs_wypisz_e2")." ".$subs_email." ".konf::get()->langTexty("subs_wypisz_e3")."\n";
						$tresc.="<a href=\"".konf::get()->getKonfigTab('adres_www').konf::get()->getKonfigTab("plik")."?akcja=subs_potwierdzu&id_nr=".$dane['id']."&subs_check=".$gensid."\">".konf::get()->getKonfigTab('adres_www').konf::get()->getKonfigTab("plik")."?akcja=subs_potwierdzu&id_nr=".$dane['id']."&subs_check=".$gensid."</a>\n\n";
						
						require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");
															
						$wyslij=new wyslijemail(konf::get()->langTexty("subs_wypisz_et"),$tresc,$subs_email);
						$wyslij->setNadawca(konf::get()->getKonfigTab('admin_email'),konf::get()->getKonfigTab('nazwa_www'));	
						$wyslij->wykonaj();			

						konf::get()->setKomunikat(konf::get()->langTexty("subs_wypisz_aby"),"");	    
					}
					
				}
		  } else {            
	  		konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." WHERE idtf='".$id_subs."' AND email='".$subs_email."'");
		  	konf::get()->setKomunikat(konf::get()->langTexty("subs_wypisz_usu1")." ".$subs_email." ".konf::get()->langTexty("subs_wypisz_usu2"),"");
		  }	  
		}
	}


  /**
   * confirm email
   */	
	public function potwierdz(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	
		$subs_check=tekstForm::doSql(konf::get()->getZmienna('subs_check','subs_check'));			

		if(!empty($id_nr)&&!empty($subs_check)){
		
			konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." SET data=NOW(), status=1 WHERE id='".$id_nr."' AND sprcheck='".$subs_check."' AND status=2");
			
			if(konf::get()->_bazasql->affected_rows){
				konf::get()->setKomunikat(konf::get()->langTexty("subs_potw"),"");
				user::get()->zapiszLog(konf::get()->langTexty("subs_potw_log")." ".$id_nr,"","","");
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("subs_potw_log"),"error");
			}
			
		}
		
		
	}

	
  /**
   * confirm delete email
   */
	public function potwierdzu(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		$subs_check=tekstForm::doSql(konf::get()->getZmienna('subs_check','subs_check'));

		if(!empty($id_subs)&&!empty($subs_check)){
			
			konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." WHERE id='".$id_nr."' AND sprcheck='".$subs_check."' AND status=3");
			
			if(konf::get()->_bazasql->affected_rows){
				konf::get()->setKomunikat(konf::get()->langTexty("subs_potwu"),"");
				user::get()->zapiszLog(konf::get()->langTexty("subs_potwu_log")." ".$id_nr,"","","");
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("subs_potwu_blad"),"error");
			}
			
		}
		
	}	
	
	
  /**
   * subscription form
   */	
	public function formularz(){

		echo "<div class=\"srodek\"><div class=\"srodek\" style=\"margin-top:25px; margin-bottom:20px; width:200px\">";
		
	  echo tab_nagl(konf::get()->langTexty("subs"),1);
	  echo "<tr><td class=\"tlo3 lewa\">";
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"subs1","subs1");	
		echo $form->spr(array(1=>"subs_email"));
		echo $form->getFormp();	
		echo $form->przenies(array("id_subs"=>1));
		
		echo interfejs::label("subs_email",konf::get()->langTexty("subs_podajemail"),"male blok");					
		echo $form->input("text","subs_email","subs_email","","f_dlugi",50);			
	  echo "<br />";
		echo $form->select("akcja","akcja",array(
			"subs_zapisz"=>konf::get()->langTexty("subs_zapisz"),
			"subs_wypisz"=>konf::get()->langTexty("subs_wypisz")
		),"","f_sredni");
	  echo "&nbsp;";
		
		echo $form->input("submit","","",konf::get()->langTexty("subs_wyslij"),"formularz2 f_krotki");				
		echo $form->getFormk();	
	  echo "</td></tr>";
	  echo tab_stop();		
				
		echo "</div></div>";

	}	
	
	
  /**
   * generate SID
   * @return string
   */	
	public function genSid(){

		$ok=false;
		
		$sid="";
		
		while(!$ok){
			
			//losuje 30 liczb
			for ($i=1; $i<=30; $i++){ 
				$sid.=round(rand(0,9));
			}
			
			//teraz aby wynik byl mniej czytelny dodatkowo md5
			$sid=md5($sid.date("Y-m-d"));
			$sid=tekstForm::doSql($sid);			
			
			if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." WHERE sprcheck='".$sid."'")==0){
				$ok=true; 
			} else {
				$sid="";
			}
			
		}
		
		return $sid;
		
	}		
	
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
	
		$this->_admin=konf::get()->getKonfigTab("subs_konf",'admin_subs');
		

  }	

	
}	

?>