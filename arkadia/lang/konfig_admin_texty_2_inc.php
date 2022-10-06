<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$texty_tab['konfig_form_edycja']="Configuration edit";
$texty_tab['konfig_form_tytul']="Name of the www service";	
$texty_tab['konfig_form_htytul']="Default name, appears in the headline bar of www browsers and depending on the project, in the chosen parts of the www service";
$texty_tab['konfig_form_tytulp']="Prefix to the title";	
$texty_tab['konfig_form_htytulp']="After defining, the prefix is automatically added to the page title where the main title is replaced by other text. For example, a prefix can be a short name of the main service and the title of the sub-pages will be added to it on the sub-pages";
$texty_tab['konfig_form_description']="Description for the search engines";
$texty_tab['konfig_form_hdescription']="Short (2-3 sentences) description of the sub-page for search engines";
$texty_tab['konfig_form_keywords']="Keywords for search engines";
$texty_tab['konfig_form_hkeywords']="Group of chosen words - entries, phrases devided by commas characterising the www service. Not more than 20-30 entries";
$texty_tab['konfig_form_kontakte']="Contact email";	
$texty_tab['konfig_form_hkonakte']="Contact email is used depending on the project , e.g. as a sender of the contact form or displayed in the www text";
$texty_tab['konfig_form_kontakta']="Sender (signature)";
$texty_tab['konfig_form_hkonakta']="Name of the sender, signature of the contact email";
$texty_tab['konfig_form_lang']="Default language version";	
$texty_tab['konfig_form_hlang']="Language version, which is automatically active when opening www service";	
$texty_tab['konfig_form_panel']="Administrative panel";	
$texty_tab['konfig_zap_zmiana_log']="configuration - modification of data";
$texty_tab['konfig_form_kodstat']="Kod statystyk oglądalności";
$texty_tab['konfig_form_hkodstat']="Kod statystyk oglądalności np. Google Analytics. Umieszany tutaj kod jest automatycznie dodawany na końcu każdej podstrony w celu zbierania informacji o użytkownikach korzystających z WWW";

$texty_tab['konfig_form_smtp']="Uwierzytenianie  wysyłanej poczty (dane SMTP)";	
$texty_tab['konfig_form_hsmtp']="Wymagane w zależności od ustawień serwera nadawcy, w celu uwierzyteniania poczty email wychodzącej ze strony WWW";
$texty_tab['konfig_form_smtphost']="Host:";				
$texty_tab['konfig_form_smtplogin']="Login:";
$texty_tab['konfig_form_smtphaslo']="Hasło:";		

?>