<?php
//podstawowe funkcje do księgi gości

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


class guestbook extends modul {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="guestbook class";

	
	//formatuje tresc do zapisu w mysql
	public function tresc($tresc){

		if(konf::get()->getKonfigTab("guestbook_konf",'max_dlugosc')){
			$tresc=substr($tresc,0,konf::get()->getKonfigTab("guestbook_konf",'max_dlugosc'));
		}
	  if(konf::get()->getKonfigTab("guestbook_konf",'zostaw_tagi')){
	    $tresc=tekstForm::doSql($tresc,false);
	    $tresc=strip_tags($tresc,konf::get()->getKonfigTab("guestbook_konf",'zostaw_tagi'));
	  } else {
	    $tresc=tekstForm::doSql($tresc,true);
	  }
		return $tresc;
		
	}


  /**
   * form
   */	
	public function formularz(){

	  $id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	
	  $podstrona=konf::get()->getZmienna('podstrona','podstrona');

		//poczatkowe dane z cookies
		$dane['autor']=konf::get()->getZmienna('','','cookie_login');
		$dane['email']=konf::get()->getZmienna('','','cookie_email');
		$dane['www']=konf::get()->getZmienna('','','cookie_www');
		$dane['gg']=konf::get()->getZmienna('','','cookie_gg');
		$dane['tresc']="";
		
		$dane['status']=1;
		
		if(user::get()->zalogowany()){
			$dane['autor']=user::get()->login();
			$dane['email']=user::get()->email();
		}

		if(konf::get()->getAkcja()=="guestbook_edytuj"){
			$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'guestbook')." WHERE id='".$id_nr."'");
			if(konf::get()->_bazasql->numRows($zap)==1){
				$dane=konf::get()->_bazasql->fetchAssoc($zap);
			} else {
				$id_nr="";
			}
			konf::get()->_bazasql->freeResult($zap);
		} else {
			$id_nr="";
			konf::get()->setAkcja("guestbook_dodaj");
		}
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"guestbook","guestbook");	
		$dane=$form->odczyt($dane);				
		
		if(konf::get()->getAkcja()=="guestbook_dodaj"||!empty($id_nr)){
		
			if(user::get()->zalogowany()){
				echo $form->spr(array(1=>"tresc"));		
			} else if (!konf::get()->getKonfigTab("guestbook_konf",'wymagany_email')||!konf::get()->getKonfigTab("guestbook_konf",'email')){
				echo $form->spr(array(1=>"autor",2=>"tresc"));		
			} else if (konf::get()->getKonfigTab("guestbook_konf",'wymagany_email')&&konf::get()->getKonfigTab("guestbook_konf",'email')){
				echo $form->spr(array(1=>"autor",2=>"email",3=>"tresc"));		
			}
			
			echo $form->getFormp();
			echo $form->przenies(array("akcja"=>konf::get()->getAkcja()."2","id_nr"=>$id_nr,"podstrona"=>$podstrona));

			if(empty($id_nr)){
			
				if(user::get()->zalogowany()){
				
					echo konf::get()->langTexty("guestbook_form_autor");
					echo " <span class=\"grube\">".$dane['autor']."</span><br />";
					if(konf::get()->getKonfigTab("guestbook_konf",'wymagany_email')){
						echo konf::get()->langTexty("guestbook_form_email")." <a href=\"mailto:".$dane['email']."\">".$dane['email']."</a><br />";
					}
					
				} else {
				
					echo $form->input("text","autor","autor",$dane['autor'],"f_dlugi",20);
					echo interfejs::label("autor",konf::get()->langTexty("guestbook_form_autor2"),"grube");										
					echo "<br />";
					
					if(konf::get()->getKonfigTab("guestbook_konf",'email')){
						echo $form->input("text","email","email",$dane['email'],"f_dlugi",60);
						
						echo interfejs::label("email",konf::get()->langTexty("guestbook_form_email2"),"grube");					
						if(konf::get()->getKonfigTab("guestbook_konf",'wymagany_email')){ 
							echo "*"; 
						}
						echo "<br />";
					}
					
				}
			} else {
			
				echo konf::get()->langTexty("guestbook_form_autor")." <span class=\"grube\">".$dane['autor']."</span><br />";
				echo konf::get()->langTexty("guestbook_form_email")." <a href=\"mailto:".$dane['email']."\">".$dane['email']."</a><br />";
				
			}
			
			if(konf::get()->getKonfigTab("guestbook_konf",'gg')){
				echo $form->input("text","gg","gg",$dane['gg'],"f_krotki",15);	
				echo interfejs::label("gg",konf::get()->langTexty("guestbook_form_gg"),"nobr",true);
				echo "<br />";
			}
			
			if(konf::get()->getKonfigTab("guestbook_konf",'www')){			
				echo interfejs::label("www",konf::get()->langTexty("guestbook_form_www"));							
				echo "<br />";				
				echo $form->input("text","www","www",$dane['www'],"f_bdlugi",100);			
				echo "<br />";
			}
						
			echo interfejs::label("tresc",konf::get()->langTexty("guestbook_form_tresc"),"block grube");	
			echo $form->textarea("tresc","tresc",$dane['tresc'],"f_bdlugi",10);			
			echo "<br />";
			
			if(konf::get()->getKonfigTab("guestbook_konf",'emotikony')){
				require_once(konf::get()->getKonfigTab('klasy')."class.emotikony.php");			
				$emotikony=new emotikony();							
				echo $emotikony->wyswietl("guestbook","tresc");				
			}
			
			//pomoc przy uzywaniu niektorych znacznikow html
	  	if(konf::get()->getKonfigTab("guestbook_konf",'html_hlp')){
				echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:dodajtag('guestbook','tresc','b','".konf::get()->langTexty("guestbook_form_pogrubiony")."');\">".konf::get()->langTexty("guestbook_form_pogrubiony")."</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:dodajtag('guestbook','tresc','i','".konf::get()->langTexty("guestbook_form_pochyly")."');\">".konf::get()->langTexty("guestbook_form_pochyly")."</a><br /><br />";
	  	}
			
			if(konf::get()->getKonfigTab("guestbook_konf",'max_dlugosc')){
				echo $form->skrocTxt("tresc",konf::get()->getKonfigTab("guestbook_konf",'max_dlugosc'));
			}
			
	    if($this->admin()){
	      echo "<div>";
				echo $form->checkbox("status","status",1,$dane['status']);	
				echo interfejs::label("status",konf::get()->langTexty("guestbook_form_elwidoczny"),"nobr",true);											
	   	  echo "</div><br />";
	    }
			
			if(!user::get()->zalogowany()&&konf::get()->getKonfigTab("guestbook_konf",'botproof')){
				echo $form->bootproof();
			}			
	    
		  echo "<br />";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");		
			echo "<br /><br />";
			
			echo "<span class=\"male\">".konf::get()->langTexty("musza")."</span>";
			
			echo $form->getFormk();
		}

	}

	
  /**
   * form - add
   */	
	public function dodaj(){
		
	  $id_nr=konf::get()->getZmienna('id_nr','id_nr');	
	  $podstrona=konf::get()->getZmienna('podstrona','podstrona');

		echo tab_nagl(konf::get()->langTexty("guestbook"),1);
		echo "<tr><td class=\"tlo3\"><span class=\"grube\">";
		if(empty($id_nr)){
			echo konf::get()->langTexty("guestbook_dodaj");
		} else {
			echo konf::get()->langTexty("guestbook_edycja");
		}
		echo "</span><br />";
		if(konf::get()->getKonfigTab("guestbook_konf",'form_dostep')){
			$this->formularz($id_nr);
	 	} else { 
			echo "<div class=\"srodek\">".konf::get()->langTexty("guestbook_edycja_aby")."</div>"; 
		}
		echo "</td></tr>";
		echo "<tr><td class=\"tlo4 srodek\"><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"guestbook_zobacz","podstrona"=>$podstrona))."\">".konf::get()->langTexty("guestbook_edycja_powrot")."</a></td></tr>";
		echo tab_stop();
		
	}
	
	
  /**
   *  form - edit
   */		
 	public function edytuj(){
		$this->dodaj();
	}	

		
  /**
   * arch
   */			
	public function zobacz(){
		
	  $podstrona=konf::get()->getZmienna('podstrona','podstrona');
		
		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'guestbook');
		if(!$this->admin()){
			$query.=" WHERE status='1'";
		}
		
		if(konf::get()->getKonfigTab("guestbook_konf",'k_na_str')){
			$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,konf::get()->getKonfigTab("guestbook_konf",'k_na_str'));
			$naw->naw(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja())));
			$podstrona=$naw->getPodstrona();	
		}
		
		if(konf::get()->getKonfigTab("guestbook_konf",'form_pos')==1){
	    echo tab_nagl(konf::get()->langTexty("guestbook_dodaj"),1);
			if(konf::get()->getKonfigTab("guestbook_konf",'form_dostep')){
				$this->formularz("");
	 		} else { 
				echo "<div class=\"srodek\">".konf::get()->langTexty("guestbook_arch_aby")."</div>"; 
			}
			echo "</td></tr>";
	    echo tab_stop();
		}
	  
	  
	  if($this->admin()){
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"guestbook2","guestbook2");		
					
			?><script type="text/javascript">
		
				function spr_guestbooku(){
				
					ok=true;
				
					if(document.guestbook2.akcja.value=='guestbook_usun'){ 				
						if(!confirm("<?php echo konf::get()->langTexty("czyusun"); ?>")){ 
							ok=false; 
						}
					}
					
					return ok;
					
				}
				
			</script><?php
							
			echo $form->spr(array(1=>"akcja"),""," ok=spr_guestbooku();");	
			echo $form->getFormp();
			echo $form->przenies(array("akcja"=>"guestbook_usun","podstrona"=>$podstrona));
		}
	  
	  echo tab_nagl(konf::get()->langTexty("guestbook"),1);
	      
		if(konf::get()->getKonfigTab("guestbook_konf",'form_pos')==3){
			echo "<tr><td class=\"tlo3 srodek\"><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"guestbook_dodaj","podstrona"=>$podstrona))."\">".konf::get()->langTexty("guestbook_dodaj")."</a></td></tr>";
		}
		
		$query="SELECT * ".$query." ORDER BY ".konf::get()->getKonfigTab("guestbook_konf",'order');	
		if(konf::get()->getKonfigTab("guestbook_konf",'k_na_str')){	
			$query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
		}
		$zap=konf::get()->_bazasql->zap($query);	
		
		$ile=konf::get()->_bazasql->numRows($zap);
		if($ile>0){
		
			if(konf::get()->getKonfigTab("guestbook_konf",'wyswietl_numeracja')){
				if(konf::get()->getKonfigTab("guestbook_konf",'k_na_str')){
					$licznik=$naw->getWynikow()-konf::get()->getKonfigTab("guestbook_konf",'k_na_str')*($podstrona-1);
				} else {
					$licznik=$ile;
				}
			}
			
			if(konf::get()->getKonfigTab("guestbook_konf",'k_na_str')&&$naw->getNaw()){
				echo "<tr><td class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}
			
			if(konf::get()->getKonfigTab("guestbook_konf",'emotikony')){
				require_once(konf::get()->getKonfigTab('klasy')."class.emotikony.php");
				$emotikony=new emotikony();		
			}	
			
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			
				echo "<tr><td class=\"tlo4\"><span class=\"male\">";
				if($this->admin()){
					echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");				
				}
				
				if(konf::get()->getKonfigTab("guestbook_konf",'wyswietl_numeracja')){ 
					echo konf::get()->langTexty("guestbook_arch_wpis")." <span class=\"grube\">".$licznik."</span>, "; 
					$licznik--; 
				}
				
				if(konf::get()->getKonfigTab("guestbook_konf",'wyswietl_data')){
					echo $dane['autor_kiedy'].", ";
				}
				
				echo " ".konf::get()->langTexty("guestbook_arch_autor")." </span>";
				if(konf::get()->getKonfigTab("guestbook_konf",'wyswietl_email')&&!empty($dane['email'])){
					echo "<a href=\"mailto:".$dane['email']."\">";
				}
				
				echo "<span class=\"grube\">".$dane['autor_name']."</span>";
				if(konf::get()->getKonfigTab("guestbook_konf",'wyswietl_email')&&!empty($dane['email'])){
					echo "</a>";
				}
				
				if($this->admin()){
					echo "<span class=\"male\"> ";
					if($dane['status']!=1){
						echo konf::get()->langTexty("guestbook_arch_niezatw");
					} else {
						echo konf::get()->langTexty("guestbook_arch_zatw");
					}
					echo "</span>";
					echo "	<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"guestbook_edytuj","id_nr"=>$dane['id'],"podstrona"=>$podstrona))."\"><img src=\"grafika/pencil.gif\" alt=\"".konf::get()->langTexty("edytuj")."\" align=\"absmiddle\" width=\"16\" height=\"16\" style=\"margin-left:10px\" /></a>";
				}
				
				echo "</td></tr><tr><td class=\"tlo3\"><br />";
				
				if(konf::get()->getKonfigTab("guestbook_konf",'linia_znakow')){
					$dane['tresc']=tekstForm::zlamStringa($dane['tresc'],konf::get()->getKonfigTab("guestbook_konf",'linia_znakow'),true,konf::get()->getKonfigTab("guestbook_konf",'autolink'),false);
				}
				
				if(konf::get()->getKonfigTab("guestbook_konf",'emotikony')){
	  	    $dane['tresc']=$emotikony->rysuj($dane['tresc']);					
				}
				
				echo $dane['tresc']."<br /><br />";
				
				if(konf::get()->getKonfigTab("guestbook_konf",'gg')&&!empty($dane['gg'])){
					echo "<span class=\"male\">".konf::get()->langTexty("guestbook_arch_gg")."</span> ".tekstForm::gg($dane['gg'])." ".$dane['gg']."<br />";
				}
				
				if(konf::get()->getKonfigTab("guestbook_konf",'www')&&!empty($dane['www'])){
					echo "<a href=\"".$dane['www']."\" target=\"_blank\">".$dane['www']."</a><br />";
				}
				
				if(konf::get()->getKonfigTab("guestbook_konf",'wyswietl_ip')){
					echo "<div class=\"male prawa\">".konf::get()->langTexty("guestbook_arch_ip")." ".$dane['ip']." ".konf::get()->langTexty("guestbook_arch_host")." ".$dane['host']."</div>";
				}
				
				echo "</td></tr>";
			}
			
			if(konf::get()->getKonfigTab("guestbook_konf",'k_na_str')&&$naw->getNaw()){
				echo "<tr><td class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}
			
			if($this->admin()){
				echo "<tr><td class=\"tlo3 lewa\">";
				echo $form->input("submit","","",konf::get()->langTexty("guestbook_arch_usun"),"formularz2 f_sredni");
				echo "</td></tr>";
			}
			
		}
	  echo tab_stop();
		
	  if($this->admin()){
			echo $form->getFormk();
	  }
		konf::get()->_bazasql->freeResult($zap);
	  
		if(konf::get()->getKonfigTab("guestbook_konf",'form_pos')==2){
	    echo tab_nagl(konf::get()->langTexty("guestbook_dodaj"),1);
			echo "<tr><td class=\"tlo3 lewa\">";
			if(konf::get()->getKonfigTab("guestbook_konf",'form_dostep')){
				$this->formularz("");
	 		} else { 
				echo "<div class=\"srodek\">".konf::get()->langTexty("guestbook_arch_aby")."</div>"; 
			}
			echo "</td></tr>";
	    echo tab_stop();
		}
		
	}


  /**
   * add/edit data
   */	
	public function zapisz(){

	  $id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr'));	
	  $autor=konf::get()->getZmienna('autor');
	  $email=konf::get()->getZmienna('email');
	  $status=konf::get()->getZmienna('status');
	  $gg=konf::get()->getZmienna('gg');
	  $www=konf::get()->getZmienna('www');
	  $tresc=konf::get()->getZmienna('tresc');	

		if(user::get()->zalogowany()){
			$autor=user::get()->login();
			$email=user::get()->email();
		}
		
		$autor=tekstForm::doSql($autor,true);
		
		if(konf::get()->getKonfigTab("guestbook_konf",'email')){
			$email=tekstForm::doSql($email,true);
		} else { 
			$email=""; 
		}

		if(!konf::get()->getKonfigTab("guestbook_konf",'gg')||!tekstForm::komunikatorForm($gg)){
			$gg="";
		}
		
		if(konf::get()->getKonfigTab("guestbook_konf",'www')){
			$www=tekstForm::linkPopraw($www);
			$www=tekstForm::doSql($www);
		}
			
		if(!$this->admin()){
			$id_nr="";
			$status=konf::get()->getKonfigTab("guestbook_konf",'default_status');
		} else if ($status!="1"){
			$status="0";
		}	

		if(konf::get()->getKonfigTab("guestbook_konf",'cookie')&&empty($id_nr)){
		
			konf::get()->zapiszCookie('cookie_login',$autor,3600*24*konf::get()->getKonfigTab("guestbook_konf",'cookie'),"/");
			konf::get()->zapiszCookie('cookie_email',$email,3600*24*konf::get()->getKonfigTab("guestbook_konf",'cookie'),"/");
			konf::get()->zapiszCookie('cookie_www',$www,3600*24*konf::get()->getKonfigTab("guestbook_konf",'cookie'),"/");
			konf::get()->zapiszCookie('cookie_gg',$gg,3600*24*konf::get()->getKonfigTab("guestbook_konf",'cookie'),"/");
		 	
		}
		
		$tresc=$this->tresc($tresc);
		
		$ok=true;
		if(!user::get()->zalogowany()&&konf::get()->getKonfigTab("guestbook_konf",'botproof')){
			$ok=konf::get()->botProofCheck(true);			
		}		
		
		if($ok){

			if(konf::get()->getKonfigTab("guestbook_konf",'form_dostep')&&!empty($tresc)&&(!empty($autor)&&(!empty($email)||(!konf::get()->getKonfigTab("guestbook_konf",'wymagany_email')||!konf::get()->getKonfigTab("guestbook_konf",'email'))))||!empty($id_nr)){

				if(empty($id_nr)){
				
					if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'guestbook')." WHERE autor_name='".$autor."' AND tresc='".$tresc."'")==0){
					
						konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'guestbook')." (autor_name,autor_id,autor_kiedy,email,gg,www,tresc,ip,host,status) VALUES('".$autor."','".user::get()->id()."', NOW(), '".$email."', '".$gg."', '".$www."', '".$tresc."', '".konf::get()->getIp()."', '".konf::get()->getHost()."', '".$status."')");
						$id_nr=konf::get()->_bazasql->insert_id;
						if($id_nr){
							konf::get()->setKomunikat(konf::get()->langTexty("guestbook_zapisane"),"");
						}
						
				  } else { 
						konf::get()->setKomunikat(konf::get()->langTexty("guestbook_istnieje"),"error"); 
					}
					
				} else {
				
					konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'guestbook')." SET gg='".$gg."', www='".$www."', tresc='".$tresc."', status='".$status."', edytor_name='".user::get()->nazwa()."', edytor_id='".user::get()->id()."',edytor_kiedy=NOW() WHERE id='".$id_nr."'");
					konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
					user::get()->zapiszLog(konf::get()->langTexty("guestbook_edycja_log")." ".$id_nr,user::get()->login());	
					
				}
				
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("guestbook_niepelne"),"error"); 
			}
			
		}
		
		if(empty($id_nr)){
			konf::get()->setAkcja("guestbook_dodaj"); 		
		} else {
			konf::get()->setAkcja("guestbook_zobacz"); 			
		}
		
	}
	
  /**
   * add data
   */		
	public function dodaj2(){
		$this->zapisz();
	}
	
	
  /**
   * guestbook edit data
   */		
	public function edytuj2(){
		$this->zapisz();
	}


  /**
   * remove data
   */	
	public function usun(){

	  $id_tab=konf::get()->getZmienna('id_tab','id_tab');		

		if(!empty($id_tab)&&is_array($id_tab)){
		
			$query=tekstForm::tabQuery($id_tab);

			if(!empty($query)){
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'guestbook')." WHERE id IN (".$query.")");
				user::get()->zapiszLog(konf::get()->langTexty("guestbook_usuwanie_log"),user::get()->login());
				konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),""); 
			}
			
		}

	}
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
	
		$this->_admin=konf::get()->getKonfigTab("guestbook_konf",'admin_guestbook');

  }	
				

}



?>