<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$texty_tab['art_admin_stat']="Statistik";
$texty_tab['art_admin_stat_ogolne']="Allgemein:";	
$texty_tab['art_admin_stat_nazwa']="Name:";
$texty_tab['art_admin_stat_ilosc']="Anzahl:";		
$texty_tab['art_admin_stat_ile']="Anzahl aller Elemente";		
$texty_tab['art_admin_stat_ilea']="Anzahl der Absaetze in den Artikeln";		
$texty_tab['art_admin_stat_ilen']="Anzahl der Nachrichten, Informationen";		
$texty_tab['art_admin_stat_ilena']="Anzahl der Absaetze in Nachrichten/Informationen";		
$texty_tab['art_admin_stat_ilek']="Anzahl der Kommentare";		
$texty_tab['art_admin_stat_kat']="Kategorien der Artikel:";
$texty_tab['art_admin_stat_nazwa']="Name:";
$texty_tab['art_admin_stat_ilosc']="Anzahl:";		
$texty_tab['art_admin_stat_typy']="Arten der Elemente:";
$texty_tab['art_admin_stat_nazwa']="Name:";
$texty_tab['art_admin_stat_ilosc']="Anzahl:";		
$texty_tab['art_admin_stat_naj']="Am haeufigsten durchgesehen:";		
$texty_tab['art_admin_stat_tyt']="Titel:";
$texty_tab['art_admin_stat_wizyt']="Besuche:";		
$texty_tab['art_admin_wklej_nie']="Das Element kann hier nicht eingefuegt werden";
$texty_tab['art_admin_wklej_akcja']="Aktion konnte nicht ausgefuehrt werden";
$texty_tab['art_admin_wklej_wyt']="Daten bereit zum Umlegen";
$texty_tab['art_admin_d']="Kategorien der Elemente (";
$texty_tab['art_admin_d_nazwa']="Name der Sektion:";
$texty_tab['art_admin_d_ilosc']="Anzahl:";
$texty_tab['art_admin_d_brak']="Keine definierten Kategorien";
$texty_tab['art_admin_arch']="Liste der Elemente der Struktur (";
$texty_tab['art_admin_arch_listas']="Liste der Struktur";  
$texty_tab['art_admin_arch_edytujk']="Einstellungen bearbeiten";		   	   
$texty_tab['art_admin_arch_nr']="Nummer";
$texty_tab['art_admin_arch_tyt']="Titel";
$texty_tab['art_admin_arch_status']="Status";		
$texty_tab['art_admin_arch_licznik']="Zaehler";		
$texty_tab['art_admin_arch_pod']="Unterseite";				
$texty_tab['art_admin_arch_sglowna']="Hauptseite des Services";    
$texty_tab['art_admin_arch_t2']="Nachricht";
$texty_tab['art_admin_arch_t1']="Text";
$texty_tab['art_admin_arch_t0']="html";
$texty_tab['art_admin_arch_sglowna']="Hauptseite des Services";	
$texty_tab['art_admin_arch_data']="Datum";

$texty_tab['art_admin_arch_awyczysc']="Sperrungen der Absaetzbearbeitung entfernen";
$texty_tab['art_admin_arch_kategorie']="Kategorien der Struktur";
$texty_tab['art_admin_arch_nied']="Inkorrekte Sektion der Struktur";
$texty_tab['art_admin_arch_pidtf']="Der angegebene Identifikator fuer diese Sprachversion existiert schon, Identifikator wurde nicht gespeichert"; 
$texty_tab['art_admin_arch_elgrupn']="Das Element ist eine Nachrichtengruppe, Entfernen des Inhaltes bevor der Aenderung des Types erforderlich!"; 
$texty_tab['art_admin_arch_elgrupa']="Das Element ist eine Gruppe der Artikeln, Entfernen des Inhaltes bevor der Aenderung des Types erforderlich!";
$texty_tab['art_admin_arch_sdodaj_log']="Struktur - hinzufuegen:";
$texty_tab['art_admin_arch_sedycja_log']="Struktur - bearbeiten:";
$texty_tab['art_admin_arch_zapisane']="Daten wurden gespeichert";
$texty_tab['art_admin_arch_niezapisane']="Daten konnten nicht gespeichert werden!";
$texty_tab['art_admin_arch_nieprawidlowe']="Inkorrekte Daten";
$texty_tab['art_admin_aka_dodaj_log']="Artikel - Absatz hinzufuegen:";
$texty_tab['art_admin_aka_edytuj_log']="Artikel - Absatz bearbeiten:";
$texty_tab['art_admin_aka_usun_log']="Artikel: Absaetze entfernen";
$texty_tab['art_admin_edycjatresci']="Inhalt bearbeiten";

$texty_tab['art_admin_form_t']="Struktur erstellen:";  
$texty_tab['art_admin_form_e']="Struktur bearbeiten:"; 
$texty_tab['art_admin_form_sglowna']="Hauptseite des Services";				   
$texty_tab['art_admin_form_idtf']="Hilfsidentifikator des Elementes";
$texty_tab['art_admin_form_unikalny']="Eindeutiger Kennzeichner fuer die vorliegende Sprachversion, kann nur Buchstaben, Ziffern sowie Zeichen - und _ enthalten";
$texty_tab['art_admin_form_datastart']="Zeige ab (Datum)";
$texty_tab['art_admin_form_dataw']="Zeige bis (Datum)";
$texty_tab['art_admin_form_tytul']="Titel*:";
$texty_tab['art_admin_form_tytulz']="Ersatztitel fuer das Menue:";
$texty_tab['art_admin_form_linkz']="Verknuepfung, die das Element im Menue ersetzt:";
$texty_tab['art_admin_form_oknol']="Fenster, in dem sich die Verknuepfung oeffnet";
$texty_tab['art_admin_form_noweo']="- im neuen Fenster ,";
$texty_tab['art_admin_form_tosamoo']="- im selben Fenster";
$texty_tab['art_admin_form_zajawka']="Die ersten Worte/Saetze, die zusammen mit dem Titel angezeigt werden:";
$texty_tab['art_admin_form_dzial']="Sektion, Menuezurechnung:";
$texty_tab['art_admin_form_typz']="Inhaltsart*:";
$texty_tab['art_admin_form_ilosc']="Anzahl der Absaetze/Elemente auf der Unterseite (Seitennnummerierung):";
$texty_tab['art_admin_form_iloscbez']="0 - ohne Nummerierung";
$texty_tab['art_admin_form_licznik']="Stand des Zaehlers der Seitenbesuche";
$texty_tab['art_admin_form_koment']="Benutzer koennen Kommentare hinzufuegen";
$texty_tab['art_admin_form_rss']="RSS Kanal";
$texty_tab['art_admin_form_menunie']="In Menue nicht hinzufuegen";
$texty_tab['art_admin_form_menuwyr']="Im Menue herausheben";
$texty_tab['art_admin_form_dostep']="Art des Zugriffs zum Element";
$texty_tab['art_admin_form_dogory']="Verknuepfung zum Abrollen des Textes nach oben hinzufuegen";
$texty_tab['art_admin_form_listas']="Liste der Elemente der Struktur";
$texty_tab['art_admin_form_statnie']="Nie doklejaj kodu statystyk do postrony";

$texty_tab['art_admin_form_datawys']="Datum der Information";
$texty_tab['art_admin_form_podtytul']="Untertitel";

$texty_tab['art_admin_form_wytworzyl']="Information erstellt durch:";
$texty_tab['art_admin_form_wytworzylkiedy']="Erstellungsdatum (YYYY-MM-DD)";

$texty_tab['art_admin_form_zajawkai']="Bild, dass mit den ersten Worten/Saetzen und dem Titel angezeigt werden:";
$texty_tab['art_admin_form_usung']="bisherige Grafik entfernen / eine neue einfuegen"; 
$texty_tab['art_admin_form_grafika']="Grafik:";

$texty_tab['art_admin_form_submenu']="Untermenue";
$texty_tab['art_submenu0']="Untergeordnete Elemente";
$texty_tab['art_submenu1']="Gleichrangige Elemente";
$texty_tab['art_submenu2']="Untermenue nicht anzeigen";

$texty_tab['art_admin_form_hidtf']="Identifikator wird benutzt, um Inhalte von ausserhalb des Standardmenues zu entnehmen oder wenn dem Element eine Sonderaufgabe zugerechnet wurde. Andernfalls keine Funktion";
$texty_tab['art_admin_form_htytulz']="Ausfuellen, wenn ein Element einen anderen Namen im Menue haben soll, meistens kuerzeren als der Titel, der auf der Unterseite benutzt wird";		
$texty_tab['art_admin_form_hlink']="Element wird durch die vorliegende Verknuepfung im Menue ersetzt - Umleitung zu einem anderen WWW-Teil oder zu einer voellig unabhaenigen Aussenseite";
$texty_tab['art_admin_form_hzajawka']="Benutzt, um Artikelankuendigungen zu erstellen oder fuer das Menue mit der Inhaltsbeschrebung der Seite";			
$texty_tab['art_admin_form_htypz']="Standardseite ist vom HTML-Typ, Seiten ohne einen Editor nur fuer speziele Anwendungen.Auswahl des Typs Nachrichten/Informationen bedeutet, dass der Inhalt in Form eines Verzeichnisses von Informationen dargestellt wird, die nach dem Datum sortiert werden, ohne die Moeglichkeit, tiefer in die WWW Struktur reinzugehen";
$texty_tab['art_admin_form_hilosc']="Teilung laengerer Inhalte in nummerierte Teile - Seitennummerierung. Empfehlenswert vor allem fuer Elemente des Typs News, Informationen";
$texty_tab['art_admin_form_hlicznik']="Wievielmal der WWW Inhalt angezeigt wurde, Anzeigen durch das Konto des eingeloggten Administrator wird nicht dazugerechnet.";
$texty_tab['art_admin_form_hdostep']="Definiert, fuer wen der Inhalt des Elementes zugaenglich ist: <br /> <b>allgemein</b> - d.h. fuer alle WWW Besucher, <b>fuer Eingeloggte</b> - nur fuer Personen, die Kontos auf WWW haben und sich erfolgreich eingeloggt haben,<br /> <b>Berechtigung</b> - nur fuer eingeloggte Personen, die entsprechende Berechtigung haben,<br /> <b>speziell</b> - Element benutzt auf eine spezielle Weise ohne Zugriff durch eine direkte Verknuepfung";
$texty_tab['art_admin_form_hrss']="Elemente, die sich innerhalb des laufendes Elementes befinden (Unterseiten oder Nachrichten/Informationen) werden als Informationen in Form eines RSS Kanals benutzt";
$texty_tab['art_admin_form_hmenunie']="Element wird nicht direkt im Menue angezeigt. Nutzung dieser Funktion haengt vom Typ des Projektes ab.";
$texty_tab['art_admin_form_hmenuwyr']="Element wird im Menue hervorbezogen - z.B. durch eine andere Farbe im Hintergrund. Nutzung dieser Funktion haengt vom Typ des Projektes ab.";
$texty_tab['art_admin_form_hdogory']="Am Ende des Inhaltes wird eine Verknuepfung plaziert, der es erlaubt, WWW nach oben zum Anfang des Textes abzurollen. Option nuetzlich fuer laengere Texte.";
$texty_tab['art_admin_form_himg']="JPG Datei, die die Anforderungen an die Groesse erfuellt. Achtung, JPG Dateien in der CMYK Farbenpalette werden abgelehnt. WWW Seiten arbeiten nur mit der RGB Palette";																							
$texty_tab['art_admin_form_hstatnie']="Powoduje, że dana strona nie będzie uzgledniana w zewnętrznych systemach statystyk, jeśli są one zdefiniowane.";

$texty_tab['art_admin_form_description']="Beschreibung der Unterseite fuer die Suchmaschinen";
$texty_tab['art_admin_form_hdescription']="Kurze (2-3 Saetze) Beschreibung der Unterseite fuer die Suchmaschinen. Wenn leer, wird die Standardbeschreibung aus den Einstellungen verwendet.";
$texty_tab['art_admin_form_keywords']="Schluesselwoerter fuer die Suchmaschinen";
$texty_tab['art_admin_form_title']="Titel fuer die Suchmaschinen";
$texty_tab['art_admin_form_hkeywords']="Gruppe ausgewaehlter Woerter - Stichwoerter, Phrasen (getrennt mit Kommas), die den WWW Service charakterisieren. Nicht mehr, als 20-30 Stichwoerter. Wenn leer, wird das Standardverzeichnis der Woerter aus den Einstellungen verwendet.";


$texty_tab['art_admin_aform_t']="Neuen Absatz erstellen:";
$texty_tab['art_admin_aform_e']="Aufsatz bearbeiten:";
$texty_tab['art_admin_aform_tytul']="Untertitel des Absatzes:";
$texty_tab['art_admin_aform_tresc']="Inhalt:";
$texty_tab['art_admin_aform_wstawg']="Text wird in Fettdruck eingefuegt";
$texty_tab['art_admin_aform_wstawp']="Text wird in Kursivschrift eingefuegt";
$texty_tab['art_admin_aform_pogrubiony']="Text in Fettdruck einfuegen";
$texty_tab['art_admin_aform_pochyly']="Text in Kursivschrift einfuegen";
$texty_tab['art_admin_aform_wyrownanie']="Textausrichtung";
$texty_tab['art_admin_aform_pozostaw']="behalte urspruengliches HTML im Inhalt (keine Formatierung, nicht entfernen)";
$texty_tab['art_admin_aform_usungrafike']="bisherige Grafik entfernen / eine neue einfuegen"; 
$texty_tab['art_admin_aform_gjpg']="JPG Grafik:";
$texty_tab['art_admin_aform_opisg']="Bildbeschreibung, alternativer Text:";
$texty_tab['art_admin_aform_linkg']="Verknuepfung auf dem Bild:";
$texty_tab['art_admin_aform_oknog']="Fenster, in dem sich die Verknuepfung oeffnet";
$texty_tab['art_admin_aform_noweo']="- im neuen Fenster ,";
$texty_tab['art_admin_aform_tosamo']="- im selben Fenster";
$texty_tab['art_admin_aform_nieskaluj']="nicht kalibrieren";
$texty_tab['art_admin_aform_px']="px";
$texty_tab['art_admin_aform_przeskaluj']="neue Grafik auf eine gewuenschte Groesse kalibrieren";
$texty_tab['art_admin_aform_polozenieg']="Grafik gegenueber des Textes";
$texty_tab['art_admin_aform_katalog']="Katalog mit Bildergallerie:";
$texty_tab['art_admin_aform_podglad']="Textvorschau";
$texty_tab['art_admin_aform_listael']="Liste der Elemente der Struktur";
$texty_tab['art_admin_a_usuwanie_log']="Artikel - Entfernen";	
$texty_tab['art_admin_a_glowny_log']="Einstellung des Hauptelements";
$texty_tab['art_admin_a_nieel']="Inkorrektes Element!"; 
$texty_tab['art_admin_a_param_log']="Aenderung der Strukturparameter";
$texty_tab['art_admin_a_wykonana']="Handlung wurde ausgefuehrt"; 
$texty_tab['art_admin_a_brak']="Keine Daten"; 
$texty_tab['art_admin_a_blok']="Sperrungen der Absaetzbearbeitung wurden entfernt";
$texty_tab['art_admin_a_blok_log']="Artikeln - Entfernen der Sperrungen";	
$texty_tab['art_admin_konfig_form']="Bearbeitung der Details - Einstellungen des Elementes";
$texty_tab['art_admin_form_mapanie']="Keine Platzierung auf dem Sitemap";
$texty_tab['art_admin_form_hmapanie']="Option von Bedeutung wenn der WWW Service eine Sitemap-Funktion hat";		
$texty_tab['art_admin_form_tytulnie']="Zeigt keinen Titel der Unterseite/des Artikels";
$texty_tab['art_admin_form_htytulnie']="Benutzt, damit oberhalb des Textes der dem Element gegebener Titel nicht gezeigt wird. Es gilt nicht, wenn ein Element zu einer anderen Verknuepfung umgeleitet wird oder wenn der Titel auf eine nicht-standardisierte Weise benutzt wird";
$texty_tab['art_admin_form_stopkanie']="Keine Zeile des Artikels zeigen";
$texty_tab['art_admin_form_hstopkanie']="Artikel kann eine Zeile mit Verknuepfung zum Ausdrucken haben, mit Informationen ueber die Bearbeitungssdaten, Autoren usw. haben. Mit dieser Funktion wird das Aufzeigen der Zeile desaktiviert oder ihr Inhalt wird begrenzt";
$texty_tab['art_admin_form_idtflink']="Identifikator des Elements in einer suchmaschinenfreundlichen Form";	
$texty_tab['art_admin_form_hidtflink']="Erlaubt Erstellung einer Verknuepfung in einer der Suchmaschinen freundlichen Form, beinhaltet Schluesselwoerter oder relevante Phrasen. Achtung - der Identifikator darf keine speziellen Zeichen, keine Nationalzeichen beinhalten und das Leerzeichen muss mit dem Unterstrich oder dem Bindestrich ersetzt werden";
$texty_tab['art_admin_form_idtflinkh']="Ausschliesslich Ziffern, Bindestrich oder Buchstaben ohne nationale Sonderzeichen";
$texty_tab['art_admin_form_glowny']="Ale voreingestellte Webseite einstellen";
$texty_tab['art_admin_form_hglowny']="Funktion benutzt je nach Projekttyp; die ausgewaehlte Seite wird standardmaessig fuer die ganze WWW oder eine ausgewaehlte Sektion geoeffnet.";		
	
$texty_tab['art_admin_form_gwt']="Grafik gegenueber des Textes";
$texty_tab['art_admin_form_zrodlo']="Informationsquelle:";
$texty_tab['art_admin_form_hzrodlo']="Bitte die Informationsquelle angeben, wenn es erforderlich ist, die Urheberrechte zum eigetragenen Inhalt zu bestimmen";		
	
$texty_tab['art_admin_akapity_edytujk']="Absatzeinstellungen bearbeiten";
$texty_tab['art_admin_akapity_kramka']="Rahmenbreite:";
$texty_tab['art_admin_akapity_kramkah']="Rahmen un den Absatz in Pixel. Bei einem 0-Wert kein Rahmen.";	
$texty_tab['art_admin_akapity_ksser']="Absatbreite:";
$texty_tab['art_admin_akapity_kszerh']="Breite des Absatzes als Prozentsatz der gesamten zur Verfuegung stehenden Breite. Bei einem 0- oder 100-Wert wird die ganze Breite verwendet.";			
$texty_tab['art_admin_akapity_kmargines']="Rand:";
$texty_tab['art_admin_akapity_kmarginesh']="Rand um den Text, in Pixel";			
$texty_tab['art_admin_akapity_kramkak']="Rahmenfarbe:";
$texty_tab['art_admin_akapity_kramkakh']="Farbe des Rahmens des Absatzes. Bei keiner ausgewaehlten Fabre kein Rahmen";	
$texty_tab['art_admin_akapity_ktlo']="Hintergrundfarbe:";
$texty_tab['art_admin_akapity_ktloh']="Farbe des Hintergrundes des Absaztes. Bei keiner ausgewaehlten Fabre kein Hintergrund";	
$texty_tab['art_admin_akapity_kgalw']="Anzahl der Bilder in einer Zeile:";
$texty_tab['art_admin_akapity_kgalwh']="Die Art und Weise der Teilung der Seite in Zeilen richtet sich an den Projekttyp und den ausgewaehlten Typ der Galerie. Bei einem 0-Wert wird die voreingestellte Anzahl der Bilder in einer Zeile verwendet.";
$texty_tab['art_admin_akapity_kgalh']="Anzahl der Zeilen auf einer Unterseite:";
$texty_tab['art_admin_akapity_kgalhh']="Die Art und Weise der Teilung der Galerie in Unterseiten haengt vom Projekt und dem ausgewahlten Typ der Galerie. Bei einem 0-Wert wird keine oder voreingestellte Seitenteilung benutzt.";
$texty_tab['art_admin_akapity_kgalt']="Typ der Bildergalerie:";
$texty_tab['art_admin_akapity_kgalth']="Art und Weise, wie Bilder auf der WWW angezeigt werden, je nach Projekttyp.";
$texty_tab['art_admin_akapity_kpowrot']="Zurueck zur Uebersicht";
$texty_tab['art_admin_akapity_klog']="Absatzeinstellungen bearbeiten ";
$texty_tab['art_admin_akapity_zalezne']="Galeriezeilen abhaengig";
$texty_tab['art_admin_akapity_zalezneh']="Durch diese Option erstellt die Galerie eine Tabelle und die Platzierung der Bilder in den Spalten ist gleich";				

$texty_tab['art_admin_akapity_sgalt']="Art der Skalierung der Vorschaubilder";					
$texty_tab['art_admin_akapity_galw']="Breite der Vorschaubilder:";			
$texty_tab['art_admin_akapity_wgalh']="Eine 'Null' steht fuer voreingestellte Skaliegungsgroesse. Dieses Parameter wird je anch Projektart und Skalierungstyp eingesetzt";									
$texty_tab['art_admin_akapity_galh']="Hoehe der Vorschaubilder:";			

$texty_tab['art_admin_form_idtflinkh']="Untertitel";
$texty_tab['art_admin_gal_param_log']="Galerien Parameter bearbeiten";
$texty_tab['art_admin_galeria_usun_log']="Galerien Bilder entfernen";
$texty_tab['art_galerie_edytujk']="Bildparameter bearbeiten";
$texty_tab['artadmin_galeria']="Bildergalerie";
$texty_tab['artadmin_gal_nr']="Nr.";
$texty_tab['artadmin_gal_zdjecie']="Bild";
$texty_tab['artadmin_gal_param']="Parameter";		
$texty_tab['artadmin_gal_wysokosc']="Hoehe";		
$texty_tab['artadmin_gal_szerokosc']="Breite";	
$texty_tab['artadmin_gal_px']="px";	
$texty_tab['artadmin_gal_status']="Status";		
$texty_tab['artadmin_gal_wys']="Hoehe";		
$texty_tab['artadmin_gal_glosow']="Stimmen";		
$texty_tab['artadmin_gal_ocen']="Bewertungen";					
$texty_tab['artadmin_gal_obrobka']="zum Bearbeiten";
$texty_tab['artadmin_gal_powrot']="zurueck zum Artikel";
$texty_tab['artadmin_galf_dodawanie']="Bild hinzufuegen";
$texty_tab['artadmin_galf_edycja']="Bilder in der Galerie bearbeiten";
$texty_tab['artadmin_galf_powrot']="Zurueck zur Galerie";

$texty_tab['art_admin_gal_kedycja']="Galerie Bildeinstellungen bearbeiten";
$texty_tab['artadmin_gal_eplik']="Grafik bearbeiten";	 				
$texty_tab['art_admin_gal_kobrot']="Galerie Bild drehen";
$texty_tab['artadmin_galf_pkonfig']="Grafik bearbeiten";
$texty_tab['art_admin_gal_dodaniek']="Galerie - Bild hinzufuegen";
$texty_tab['art_admin_gal_edycjak']="Galerie Bild bearbeiten";

?>