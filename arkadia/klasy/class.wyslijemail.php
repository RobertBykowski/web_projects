<?php

/**
 * WyslijEmail class v1.0
 * dla CMS i innych klas - wysylanie emaila.
 * All rights reserved
 * @package WyslijEmail class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2007 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  require_once("class.wyslijemail.php");
	$wyslijemail=new wyslijemail($tytul,$tresc,$email);
	$wyslijemail->setNadawca($nadawcaEmail,$nadawca);	
	$wyslijemail->wykonaj();
	
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

	
class wyslijemail {

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */
		
	/**
	 * nazwa klasy
	 */				
  var $_nazwaKlasy="WyslijEamil class";

	/**
	 * tytul
	 */					
	var $_tytul="";		
	
	/**
	 * tresc
	 */					
	var $_tresc="";
			
	/**
	 * pole matka
	 */					
	var $_email="";			
	
	/**
	 * nadawca
	 */					
	var $_nadawca="";			
	
	/**
	 * pole id
	 */					
	var $_nadawcaEmail="";			
	
	/**
	 * pole id
	 */					
	var $_replyEmail="";				
	
	/**
	 * czy wykonano
	 */					
	var $_ok=false;		
	
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	function getNazwaKlasy(){
	
		return $this->_nazwaKlasy;
		
	}		
						
	
  /**
   * Set tytul
   * @param string $tytul
   */
  function setTytul($tytul) {

		if($tytul!=""){
	    $this->_tytul=$tytul;
		} else {
			trigger_error("setTytul: invalid tytul value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
	
  }		
	
  /**
   * Set tresc
   * @param string $tresc
   */
  function setTresc($tresc) {

		if($tresc!=""){
	    $this->_tresc=$tresc;
		} else {
			trigger_error("setTresc: invalid tresc value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
	
  }		
	
	
  /**
   * Set email
   * @param string $email
   */
  function setEmail($email) {
		if(!empty($email)){
	    $this->_email=$email;
		} else {
			trigger_error("setEmail: invalid email value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
	
  }			
	
	
  /**
   * Set nadawca
   * @param string $nadawca
   * @param string $nadawcaEmail		
   */
  function setNadawca($nadawcaEmail,$nadawca="") {

		if(!empty($nadawcaEmail)){
	    $this->_nadawcaEmail=$nadawcaEmail;
			if(!empty($nadawca)&&is_string($nadawca)){
		    $this->_nadawca=$nadawca;				
			} else {
		    $this->_nadawca=$nadawcaEmail;					
			}
		} else {
			trigger_error("setNadawca: invalid nadawcaEmail value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
	
  }		
	
	
  /**
   * Set reply email
   * @param string $nadawca
   * @param string $nadawcaEmail		
   */
  function setReply($email) {

		if(!empty($email)){
	    $this->_replyEmail=$email;
		} else {
			trigger_error("setReply: invalid email value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
	
  }				

	
  /**
   * wykonaj akcje
   */
  function wykonaj($html=false) {
	
		if($this->_tytul&&$this->_tresc&&$this->_email){
		
	    require_once(konf::get()->getKonfigTab("serwer")."klasy/phpmailer/class.phpmailer.php");

			$mail = new phpmailer();
			
			try {			
				
				$mail->SetFrom($this->_nadawcaEmail,$this->_nadawca);		
				
				if($this->_replyEmail){
					$mail->AddReplyTo($this->_replyEmail,$this->_replyEmail);	
				} else {
					$mail->AddReplyTo($this->_nadawcaEmail,$this->_nadawca);					
				}
								
				$mail->CharSet=konf::get()->getKonfigTab('charset');		
				
				if (function_exists("mb_encode_mimeheader")){
					$mail->Subject=mb_encode_mimeheader($this->_tytul,"UTF-8", "B", "\n");	
				}	else {				
					$mail->Subject=$this->_tytul;						
				}					
				
//				} else {				
//					if(tekstForm::utf8Strlen($this->_tytul)>40){
//						$mail->Subject=tekstForm::usunPl($this->_tytul);
//					} else {
//						$mail->Subject=$this->_tytul;				
//					}					
//				}					


				if(konf::get()->getKonfigTab('kontakt_html')){
					$html=true;
				}		
				
		    $mail->IsHTML($html);		
				
				if(konf::get()->getKonfigTab('kontakt_szablon')){
					$this->_tresc=str_replace("<TRESC>", $this->_tresc, konf::get()->getKonfigTab('kontakt_szablon'));
				}							
				
				$grafiki=konf::get()->getKonfigTab('kontakt_grafiki');
				if(konf::get()->getKonfigTab('kontakt_html')&&konf::get()->getKonfigTab('kontakt_grafiki')&&is_array($grafiki)){
					while(list($key,$val)=each($grafiki)){
						$mail->AddEmbeddedImage(konf::get()->getKonfigTab("serwer")."grafika/email/".$val['plik'],$val['cid'],$val['plik'],"base64",$val['typ']);
					}
				}		
				
				//smtp
				if(konf::get()->getKonfigTab('kontakt_smtp_host')&&konf::get()->getKonfigTab('kontakt_smtp_user')&&konf::get()->getKonfigTab('kontakt_smtp_haslo')){
					$mail->IsSMTP();			
		   		$mail->Host=konf::get()->getKonfigTab('kontakt_smtp_host');
		   		$mail->Username=konf::get()->getKonfigTab('kontakt_smtp_user');
		   		$mail->Password=konf::get()->getKonfigTab('kontakt_smtp_haslo');
					if(konf::get()->getKonfigTab('kontakt_smtp_secure')){
						$mail->SMTPSecure=konf::get()->getKonfigTab('kontakt_smtp_secure');
					}
					if(konf::get()->getKonfigTab('kontakt_smtp_port')){
						$mail->Port=konf::get()->getKonfigTab('kontakt_smtp_port');
					}							
					$mail->SMTPAuth=true;			
			  } else {
		  	  $mail->IsMail();		
				}	
			
				if($html){
					$this->_tresc=nl2br($this->_tresc);			
					$mail->MsgHTML($this->_tresc);
				} else {
					$this->_tresc=strip_tags(str_replace(array("<br />","</tr>","<td>","</td>","</table>"),array("<br />\n ","</tr>\n ","<td> ","</td> ","</table>\n"),$this->_tresc));			
					$mail->Body=$this->_tresc;
				}
				
				if(is_array($this->_email)){
					while(list($key,$val)=each($this->_email)){
				    $mail->ClearAddresses(); 				
					  $mail->AddAddress($val);	
						$mail->Send(); 
					}
				} else {
				
				  $mail->AddAddress($this->_email);

					if(!$mail->Send()) {
						trigger_error("Mailer Error: " . $mail->ErrorInfo. " ".$this->getNazwaKlasy(),E_USER_ERROR);				
					}
									
				}
				
			} catch (phpmailerException $e) {			
			  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {			
			  //echo $e->getMessage(); //Boring error messages from anything else!
			}			
			
			$this->_ok=true;
			
		} else {
			trigger_error("wykonaj: invalid or empty data ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
	}
					
						
	/**
   * class constructor php5	
   * @param string $tytul
   * @param string $tresc		
   * @param string,array $email
   */	
	function __construct($tytul,$tresc,$email) {	
	
		$this->setTytul($tytul);
		$this->setTresc($tresc);
		$this->setEmail($email);
		
  }	
	
}

?>
