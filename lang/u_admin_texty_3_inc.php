<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$texty_tab['u_admin_stat']="Statistik";
$texty_tab['u_admin_stat_ogol']="Allgemein:";	
$texty_tab['u_admin_stat_nazwa']="Name:";
$texty_tab['u_admin_stat_ilosc']="Anzahl:";		
$texty_tab['u_admin_stat_iloscu']="Anzahl der Benutzer";		
$texty_tab['u_admin_stat_iloscuupr']="Anzahl der Benutzer mit Berechtigungen";		
$texty_tab['u_admin_stat_m']="Maennlich";		
$texty_tab['u_admin_stat_k']="Weiblich";		
$texty_tab['u_admin_stat_wlogowan']="Anzahl aller Einloggungen";		
$texty_tab['u_admin_stat_sp']="Summe erlangter Punkte";		
$texty_tab['u_admin_stat_ilelog']="Anzahl der Einloggungen";		
$texty_tab['u_admin_stat_statusy']="Status:";		
$texty_tab['u_admin_stat_zalozone']="Erstellte Konten:";		
$texty_tab['u_admin_stat_dzis']="Heute";		
$texty_tab['u_admin_stat_wczoraj']="Gestern";		
$texty_tab['u_admin_stat_w7']="In den letzten 7 Tage";		
$texty_tab['u_admin_stat_w30']="In den letzten 30 Tage";		
$texty_tab['u_admin_stat_logowania']="Einloggungen:";	
$texty_tab['u_admin_stat_bledne']="Unerfoglreiche Einloggungen:";	
$texty_tab['u_admin_stat_nzalog']="Am haeufigsten eingeloggt:";	
$texty_tab['u_admin_stat_najp']="Die meisten Punkte:";			
$texty_tab['u_admin_stat_fip']="IP Filter:";		
$texty_tab['u_admin_arch_lista']="Liste der Konten";
$texty_tab['u_admin_arch_id']="ID";
$texty_tab['u_admin_arch_u']="Benutzer";
$texty_tab['u_admin_arch_datazal']="Erstellungsdatum";
$texty_tab['u_admin_arch_ostlog']="Letzte Einloggung";
$texty_tab['u_admin_arch_status']="Status";
$texty_tab['u_admin_arch_upr']="Berechtigungen";
$texty_tab['u_admin_arch_log']="log.";
$texty_tab['u_admin_arch_email']="email";
$texty_tab['u_admin_arch_admin']="admin";
$texty_tab['u_admin_arch_pt']="Punkte";
$texty_tab['u_admin_arch_tak']="JA"; 
$texty_tab['u_admin_arch_nie']="nein"; 
$texty_tab['u_admin_arch_awyslij']="Nachricht schicken";
$texty_tab['u_admin_arch_azmineopis']="Beschreibung aendern";
$texty_tab['u_admin_arch_astatus']="change status";
$texty_tab['u_admin_arch_astat']="Statistik";	
$texty_tab['u_admin_arch_awyzeruj']="Punkte auf null stellen"; 
$texty_tab['u_admin_arch_azobaczl']="Logs sehen";
$texty_tab['u_admin_arch_afiltr']="IP Filter Regeln";
$texty_tab['u_admin_arch_awykonaj']="ausfuehren";
$texty_tab['u_admin_arch_szuk_dowolne']="--beliebige--";
$texty_tab['u_admin_usun_e1']="Benutzer: Konto wurde entfernt"; 
$texty_tab['u_admin_param_e2']="Dein Konto mit dem Login";
$texty_tab['u_admin_usun_e3']="wurde von dem Administrator des Benutzersystems enfernt";
$texty_tab['u_admin_usun_log']="Benutzer - Konto entfernen (ID:";
$texty_tab['u_admin_zmien_log']="Benutzer: Aktion:";
$texty_tab['u_admin_param_e1']="Dein Konto mit dem Login";
$texty_tab['u_admin_param_e2']="wurde von dem Administrator des Benutzersystems enfernt";
$texty_tab['u_admin_param_e3']="Aktueller Status des Kontos:";
$texty_tab['u_admin_param_es1']="Konto aktiv";
$texty_tab['u_admin_param_es2']="Konto nicht aktiviert";
$texty_tab['u_admin_param_es0']="Konto gesperrt";
$texty_tab['u_admin_param_en']="Konto laeuft nicht ab"; 
$texty_tab['u_admin_param_ew']="Konto laeuft ab nach Verlauf von";
$texty_tab['u_admin_param_ed']="Tagen."; 
$texty_tab['u_admin_param_e']=" Benutzer: Aenderung des Statuses des Kontos";
$texty_tab['u_admin_txt']="Aenderung der Beschreibung des Kontos";
$texty_tab['u_admin_txtw']="Nachricht schicken";
$texty_tab['u_admin_txtk']="Aenderung der Beschreibung";
$texty_tab['u_admin_txtwk']="Nachrichten verschicken";
$texty_tab['u_admin_txt_tytul']="Titel:";
$texty_tab['u_admin_txt_tresc']="Inhalt:";
$texty_tab['u_admin_txt_wyslij']="Abschicken";
$texty_tab['u_admin_powrot']="Zurueck";
$texty_tab['u_admin_txt_log']="Benutzer: Nachrichten verschicken: Titel=";
$texty_tab['u_admin_txt_rozs']="Nachricht wurde geschickt";
$texty_tab['u_admin_upr']="Berechtigungen verleihen an den Benutzer:";
$texty_tab['u_admin_upr_listu']="Liste der Benutzer";
$texty_tab['u_admin_upr_e1']="Aenderungen der Berechtigungen des Kontos:";
$texty_tab['u_admin_upr_e2']="Aktuell besitzte Berechtigungen:";
$texty_tab['u_admin_upr_e']="Aenderungen der Berechtigungen des Benutzers";
$texty_tab['u_admin_upr_log']="Benutzer: Aenderung der Berechtigungen:";
$texty_tab['u_admin_upr_zapisane']="Berechtigungen wurden gespeichert"; 

$texty_tab['u_admin_arch_sstatus']="Status: ";
$texty_tab['u_admin_arch_statusw']="--Status waehlen--";
$texty_tab['u_admin_arch_sdatazlaod']="Einstellungsdatum ab:";
$texty_tab['u_admin_arch_sdo']="bis:";
$texty_tab['u_admin_arch_sdatalogd']="Einloggendatum ab:";
$texty_tab['u_admin_arch_sdo']="bis:";
$texty_tab['u_admin_arch_sflogin']="Ausdruck im Login:";
$texty_tab['u_admin_arch_sflogin']="Ausdruck in der Email:";
$texty_tab['u_admin_arch_sadmin']="nur Administratoren";
$texty_tab['u_admin_arch_sid']="ID:";
$texty_tab['u_admin_zmstatus']="Kontostatus Aendern";		

$texty_tab['u_admin_arch_upr']="Nutzerrechte";
$texty_tab['u_admin_arch_logi']="Logs";

$texty_tab['ubany_arch']="Typen der IP Filter:";
$texty_tab['ubany_arch_nazwa']="Name der Kategorie";
$texty_tab['ubany_arch_ilosc']="Anzahl";
$texty_tab['ubany_arch_listau']="Liste der Benutzer";	
$texty_tab['ubany_arch_reg']="Regeln fur Sperren/Zulassen eines IP (";
$texty_tab['ubany_arch_typf']="Typen der IP Filter:";
$texty_tab['ubany_arch_regula']="Regel";
$texty_tab['ubany_arch_ip']="IP";
$texty_tab['ubany_arch_typ']="Typ";
$texty_tab['ubany_arch_status']="Status";
$texty_tab['ubany_arch_banuj']="sperren"; 
$texty_tab['ubany_arch_dopusc']="zulassen"; 
$texty_tab['ubany_arch_oznacza']="* bezeichnet belibiges beliebige Zeichen<br />? bezeichnet belibiges einzelnes Zeichen<br />Zulassungsregeln haben eine hoehere Prioritaet als die Sperrregeln";
$texty_tab['ubany_arch_typyl']="Typen der IP Filter";	
$texty_tab['ubany_form_tworzenie']="Erstellung einer neuen IP Filter Regel:";
$texty_tab['ubany_form_edycja']="Bearbeitung der IP Filter Regel:";
$texty_tab['ubany_form_dataod']="Aktiv ab (Datum)";
$texty_tab['ubany_form_typfiltra']="Filtertyp*:";
$texty_tab['ubany_form_datado']="gueltig bis (Datum)";
$texty_tab['ubany_form_wybierz']="--auswaehlen--";
$texty_tab['ubany_form_blokowany']="IP gesperrt";
$texty_tab['ubany_form_dopuszczany']="IP zugelassen";
$texty_tab['ubany_form_rodzaj']="Filterart *";
$texty_tab['ubany_form_adres']="IP Adresse*";
$texty_tab['ubany_form_znak']="Zeichen";
$texty_tab['ubany_form_oznacza1']="bezeichnet beliebige Zeichenreihe";
$texty_tab['ubany_form_oznacza2']="bezeichnet beliebiges einzenles Zeichen";
$texty_tab['ubany_form_opis']="*Beschreibung:";
$texty_tab['ubany_form_aktywna']="Regel aktiv";
$texty_tab['ubany_form_listar']="Liste der IP Regeln";	
$texty_tab['ubany_zapis_log']="IP Filter -Hinzufuegen:";
$texty_tab['ubany_usun_log']="IP Filter - Regeln Entfernen";
$texty_tab['ubany_zmiana_log']="IP Filter - Aenderung des Statuses";
$texty_tab['ubany_autozapis']="Es wurde automatisch eine Regel erstellt, die deinen Komputer zulaesst";

$texty_tab['u_logi_czy']="Bist du sicher, dass du die Logs entfernen willst?";
$texty_tab['u_logi_lista']="Liste der Logs";
$texty_tab['u_logi_id']="ID";
$texty_tab['u_logi_idu']="id_u";
$texty_tab['u_logi_login']="Login";
$texty_tab['u_logi_opis']="Beschreibung";
$texty_tab['u_logi_ip']="IP";
$texty_tab['u_logi_kiedy']="wann";
$texty_tab['u_logi_azobaczw']="Alle logs sehen";
$texty_tab['u_logi_awyczysc']="Log-Tafeln saeubern";
$texty_tab['u_logi_awykonaj']="ausfuehren";
$texty_tab['u_logi_listau']="Liste der Benutzer";	
$texty_tab['u_logi_szuk_login']="im Login";
$texty_tab['u_logi_szuk_opis']="inder Beschreibung";
$texty_tab['u_logi_log']="Logs - Saeuberung der Tafel";

?>