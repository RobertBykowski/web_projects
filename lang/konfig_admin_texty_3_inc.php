<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$texty_tab['konfig_form_edycja']="Bearbeitung der Konfiguration";
$texty_tab['konfig_form_tytul']="Titel des WWW Services";	
$texty_tab['konfig_form_htytul']="Standardtitel, gezeigt in der Kopfleiste eines WWW Browsers und je nach Projekttyp in ausgewaehlten WWW Teilen";
$texty_tab['konfig_form_tytulp']="Praefix zum Titel";	
$texty_tab['konfig_form_htytulp']="Praefix wird nach der Definierung automatisch zum Seitentitel beigefuegt ueberall dort, wo der Titel durch einen anderen Text ersetzt wird. Ein Praefix kann z.B. ein kurzer Name des Services sein und auf den Unterseiten wird ihm der Unterseitentitel beigefuegt";
$texty_tab['konfig_form_description']="Beschreibung fuer Suchmaschinen";
$texty_tab['konfig_form_hdescription']="Kurze (2-3 Saetze) Beschreibung der Seite fuer Suchmaschinen";
$texty_tab['konfig_form_keywords']="Schluesselwoerter fuer Suchmaschinen";
$texty_tab['konfig_form_hkeywords']="Gruppe ausgewaehlter Woerter - Stichwoerter, Ausdruecke (getrennt mit Kommas), die den WWW Service charakterisieren. Nicht mehr als 20-30 Ausdruecke";
$texty_tab['konfig_form_kontakte']="Kontaktemail";	
$texty_tab['konfig_form_hkonakte']="Kontaktemail wird je nach der Projektart benutzt, z.B. als Absender eines Kontaktformulars oder im WWW Inhalt angezeigt";
$texty_tab['konfig_form_kontakta']="Kontaktabsender (Unterschrift)";
$texty_tab['konfig_form_hkonakta']="Name des Absenders, Unterschrift der Kontaktemailadresse";
$texty_tab['konfig_form_lang']="Standardsprache";	
$texty_tab['konfig_form_hlang']="Sprachversion, die automatisch mit der Oeffnung des WWWs aktiv ist";	
$texty_tab['konfig_form_panel']="Administrationspanel";	
$texty_tab['konfig_zap_zmiana_log']="Konfiguration - Datenaenderung";
$texty_tab['konfig_form_kodstat']="Kod statystyk oglądalności";
$texty_tab['konfig_form_hkodstat']="Kod statystyk oglądalności np. Google Analytics. Umieszany tutaj kod jest automatycznie dodawany na końcu każdej podstrony w celu zbierania informacji o użytkownikach korzystających z WWW";

$texty_tab['konfig_form_smtp']="Uwierzytenianie  wysyłanej poczty (dane SMTP)";	
$texty_tab['konfig_form_hsmtp']="Wymagane w zależności od ustawień serwera nadawcy, w celu uwierzyteniania poczty email wychodzącej ze strony WWW";
$texty_tab['konfig_form_smtphost']="Host:";				
$texty_tab['konfig_form_smtplogin']="Login:";
$texty_tab['konfig_form_smtphaslo']="Hasło:";		

?>