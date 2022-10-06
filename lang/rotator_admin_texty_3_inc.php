<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$texty_tab['rot_stat']="Statistik";
$texty_tab['rot_stat_ogolne']="Allgemein:";	
$texty_tab['rot_stat_nazwa']="Name:";
$texty_tab['rot_stat_ilosc']="Anzahl:";		
$texty_tab['rot_stat_ilew']="Anzahl aller Elemente";		
$texty_tab['rot_stat_sumaw']="Summe der Abrufe";		
$texty_tab['rot_stat_sumak']="Summe der Klicks";		
$texty_tab['rot_stat_typy']="Dateitypen:";	
$texty_tab['rot_stat_link']="Aussenverknuepfuengen";		
$texty_tab['rot_stat_nw']="Am haeufigsten angezeigt:";
$texty_tab['rot_stat_nk']="Am haeufigsten angeklickt:";	
$texty_tab['rot_stat_kw']="Klicks zum Anzeigen:";	
$texty_tab['rot_typy']="Typen der Banners:";
$texty_tab['rot_typy_nazwa']="Name der Kategorie:";
$texty_tab['rot_typy_ilosc']="Anzahl";
$texty_tab['rot_typy_typyp']="Dateitypen:";
$texty_tab['rot_typy_sod']="Breite ab:";
$texty_tab['rot_typy_px']="px";
$texty_tab['rot_typy_do']="bis:";
$texty_tab['rot_typy_wod']="Hoehe:";
$texty_tab['rot_typy_do']="ab:";
$texty_tab['rot_typy_max']="max.:";
$texty_tab['rot_typy_kb']="Kb)";			
$texty_tab['rot_typy_wszystkie']="alle Banners";		
$texty_tab['rot_arch_lista']="Liste der Banners, Werbungen (";
$texty_tab['rot_arch_typ']="Typen der Banners:";
$texty_tab['rot_arch_id']="ID";
$texty_tab['rot_arch_baner']="Banner";
$texty_tab['rot_arch_aktywnosc']="Date";
$texty_tab['rot_arch_status']="Status";
$texty_tab['rot_arch_jezyk']="Sprache";
$texty_tab['rot_arch_prio']="Prior.";
$texty_tab['rot_arch_udzial']="Anteil";
$texty_tab['rot_arch_wys']="Abrufe";
$texty_tab['rot_arch_klik']="Klicks";
$texty_tab['rot_arch_od']="von:";
$texty_tab['rot_arch_do']="bis:";
$texty_tab['rot_arch_astat']="Statistik";	
$texty_tab['rot_arch_awykonaj']="Ausfuhren";
$texty_tab['rot_arch_listakat']="Liste der Kategorien der Wechsler/Informationen";		
$texty_tab['rot_arch_szuk_status1']="nur aktive";
$texty_tab['rot_arch_szuk_status2']="nur inaktive";
$texty_tab['rot_arch_szuk_status0']="--Status des Banners--";
$texty_tab['rot_arch_szuk_dostepne']="nur zugaengliche";
$texty_tab['rot_arch_szuk_niedostepne']="nur unzugeangliche";
$texty_tab['rot_arch_szuk_dostepnosc']="--Zugang zum Abruf--";
$texty_tab['rot_arch_lang']="--Sprachversion--";
$texty_tab['rot_form_edycja']="Bearbeitung des Banners:";
$texty_tab['rot_form_uzupelnij']="Daten ergaenzen";
$texty_tab['rot_form_dodawanie']="Banner hinzufuegen:";		
$texty_tab['rot_form_dataod']="Zeige ab (Datum)";
$texty_tab['rot_form_datado']="Zeige bis (Datum)";
$texty_tab['rot_form_typ']="Baner/Werung Typ*:";
$texty_tab['rot_form_typwyb']="--auswaehlen--";
$texty_tab['rot_form_tytul']="Titel/Name*:";
$texty_tab['rot_form_linkg']="Verknuepfung auf dem Banner:";
$texty_tab['rot_form_okno']="Fenster, in dem sich das Banner oeffnet";		
$texty_tab['rot_form_noweokno']="- neues Fenster";
$texty_tab['rot_form_tosamookno']="- das selbe Fenster";
$texty_tab['rot_form_dotychczasowa']="bisherige Grafik:";				
$texty_tab['rot_form_grafika']="Grafik:*";
$texty_tab['rot_form_wymiary']="Groesse:";
$texty_tab['rot_form_mozliwosc']="(manuelle Aenderung nur fuer SWF moeglich)";		
$texty_tab['rot_form_wys']="Hoehe (px)";
$texty_tab['rot_form_szer']="Breite (px)";
$texty_tab['rot_form_tlo']="Hintergrund";
$texty_tab['rot_form_tylko swf']="(nur fuer SWF)";			
$texty_tab['rot_form_przezroczysty']="transparent"; 				
$texty_tab['rot_form_link']="Schluessel zum Link/Grafik:";
$texty_tab['rot_form_opis']="Beschreibung, Informationen:";
$texty_tab['rot_form_czywys']="sollen Abrufe aufgezaehlt werden";
$texty_tab['rot_form_wysw']="Anzahl der Abrufe";
$texty_tab['rot_form_wyslimit']="Begrenzung der Abrufe (0 = keine Begrenzung)";
$texty_tab['rot_form_czyklik']="sollen Klicks aufgezaehlt werden";
$texty_tab['rot_form_klik']="Anzahl der Klicks";
$texty_tab['rot_form_kliklimit']="Begrenzung der Klicks (0 = keine Begrenzung)";
$texty_tab['rot_form_brak']="--keine--";
$texty_tab['rot_form_najwyzszy']=" - am niedrigsten";
$texty_tab['rot_form_najnizszy']=" - am hoechsten";
$texty_tab['rot_form_priorytet']="Prioritaet";
$texty_tab['rot_form_udzial']="Anteil";
$texty_tab['rot_form_dowolna']="--beliebig--";
$texty_tab['rot_form_lang']="Sprachversion";		
$texty_tab['rot_form_lista']="Liste der Banners/Werbungen";

$texty_tab['rot_form_htyp']="Zur Verfuegung stehende Typen der Banners haengen von der WWW-Konfiguration ab, die fuer den individuellen Bedarf des Projektes erstellt wird";		
$texty_tab['rot_form_hadres']="WWW Adresse, an die das jeweilige Baner weiterleitet - Umleitung auf die Verknuepfung beim Anklicken des Banners. Betrifft keine SWF Banners.";
$texty_tab['rot_form_hgrafika']="Grafikdatei, die die Erfordernisse an vorgegebenen Dateityp und Groesse erfuellen";
$texty_tab['rot_form_hwymiary']="System liest die Groesse der Banners automatisch, kalibriert sie nicht mit der Ausnahme von SWF. Im Falle der SWF Dateien kann die gelesene Groesse geandert werden (in von dem jeweiligen Bannertyp erlaubten Grenzen).";
$texty_tab['rot_form_htlo']="Auswahl der Transparenz bedeutet, dass die Hintergrundfarbe ignoriert wird";
$texty_tab['rot_form_hlink']="Link, der den Aussenbanner anzeigt. Seine Angabe bedeutet, dass das eingebene Banner, eingegebene Veknuepfung auf bem Banner und andere Parameter des Banners ignoriert werden. Fuer diesen Typ von Banners besteht keine Moeglichkeit, die Klicks aufzuzaehlen";
$texty_tab['rot_form_hopis']="Nur fuer administrative Anwengungen, z.B. Notieren von Informationen ueber die Quelle des Banners oder den Werbevertrag";
$texty_tab['rot_form_hwys']="Angabe der Begrenzung der Abrufe bedeutet, dass Banner nur dann angezeigt werden kann, solange die Begrenzung hoeher als oder gleich wie die Anzahl der bisherigen Abrufe ist";		
$texty_tab['rot_form_hklik']="Angabe der Begrenzung der Klicks bedeutet, dass Banner nur dann angezeigt werden kann, solange die Begrenzung hoeher als oder gleich wie die Anzahl der bisherigen Klicks ist. Aufzaehlen der Klicks gilt nicht fuer die durch eine Verknuepfung eingefuehrte Banners sowie SWF Banners, die mit dieser Funktion nicht kompatibel sind";
$texty_tab['rot_form_hpriorytet']="Benutzt bei Anzeigen mehrerer Banners auf einmal. Banners werden beginnend mit der hoechsten Prioritaet genommen. Banners mit der selben Prioritaet werden zufaellig ausgewaehlt";
$texty_tab['rot_form_hlangt']="Bestimmt, ob ein Banner nur fuer eine Sprachversion angezeigt werden soll, oder fuer alle erhaeltichen";
$texty_tab['rot_form_hudzial']="Benutzt bei Anzeigen mehrerer Banners auf einmal. Banners werden beginnend mit der hoechsten Prioritaet genommen. Banners mit der selben Prioritaet werden zufaellig ausgewaehlt";

$texty_tab['rot_zmiena_log']="Wechsler - Aenderung des Parameters:";
$texty_tab['rot_usuna_log']="Wechsler - entfernen";	
$texty_tab['rot_img_brak']="Inkorrekter Dateityp - abgelehnt.";				


?>