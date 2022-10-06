<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

	
$texty_tab['sklep_admin_wklej_nie']="Element nie może być tu wklejony";
$texty_tab['sklep_admin_wklej_akcja']="Akcja nie została prawidłowo wykonana";
$texty_tab['sklep_admin_wklej_wyt']="Dane gotowe do przeniesienia";

$texty_tab['sklep_admin_d']="Działy asortymentu sklepu (";
$texty_tab['sklep_admin_d_nazwa']="nazwa działu produktów:";
$texty_tab['sklep_admin_d_ilosc']="ilość:";
$texty_tab['sklep_admin_d_brak']="Brak zdefiniowanych działów";

$texty_tab['sklep_admin_arch']="Lista kategorii produktów (";
$texty_tab['sklep_admin_arch_listas']="Dostępne kategorie";  
$texty_tab['sklep_admin_arch_edytujk']="edytuj konfigurację";		   	   
$texty_tab['sklep_admin_arch_nr']="nr";
$texty_tab['sklep_admin_arch_tyt']="nazwa kategorii produktów";
$texty_tab['sklep_admin_arch_status']="status";		
$texty_tab['sklep_admin_arch_licznik']="licznik";		
$texty_tab['sklep_admin_arch_pod']="pod.";			   

$texty_tab['sklep_admin_arch_kategorie']="działy asortymentu sklepu";
$texty_tab['sklep_admin_arch_nied']="Nieprawidłowy dział";

$texty_tab['sklep_admin_arch_sdodaj_log']="struktura - dodawanie:";
$texty_tab['sklep_admin_arch_sedycja_log']="struktura - edycja:";
$texty_tab['sklep_admin_arch_zapisane']="Dane zostały zapisane";
$texty_tab['sklep_admin_arch_niezapisane']="Dane nie zostały prawidłowo zapisane!";
$texty_tab['sklep_admin_arch_nieprawidlowe']="Niepoprawne dane";

$texty_tab['sklep_admin_form_t']="Tworzenie kategorii:";  
$texty_tab['sklep_admin_form_e']="Edycja kategorii:"; 
$texty_tab['sklep_admin_form_datastart']="data startu wyświetlania";
$texty_tab['sklep_admin_form_dataw']="data ważności, wyświetlaj do dnia";
$texty_tab['sklep_admin_form_tytul']="nazwa kategorii produktów*:";
$texty_tab['sklep_admin_form_tytulz']="nazwa zastępcza do menu:";
$texty_tab['sklep_admin_form_dzial']="dział, przypisanie do menu:";
$texty_tab['sklep_admin_form_licznik']="stan licznika odsłon";
$texty_tab['sklep_admin_form_menuwyr']="wyróżnij w menu";
$texty_tab['sklep_admin_form_podtytul']="opis kategorii:";

$texty_tab['sklep_admin_form_zajawkai']="obrazek:";
$texty_tab['sklep_admin_form_grafika']="grafika:";

$texty_tab['sklep_admin_form_htytulz']="Uzupełniamy gdy chcemy aby w menu element mial inną nazwę, zwykle krótsza niż tytuł główny używany w treści podstrony";		
$texty_tab['sklep_admin_form_hlicznik']="Ile razy wyświetlono kategorię, nie uwzględnia wyświetleń przez konto zalogowanego administratora.";
$texty_tab['sklep_admin_form_himg']="Plik JPG spełniający wymagania co do rozmiarów. Uwaga, pliki JPG w palecie kolorów CMYK są odrzucane. Strony WWW obsługują wyłącznie paletę RGB";

$texty_tab['sklep_admin_form_description']="opis podstrony (description) dla wyszukiwarek";
$texty_tab['sklep_admin_form_hdescription']="Krótki (2-3 zdania) opis podstrony strony dla wyszukiwarek. Jeśli pusty to zastosowany będzie domyślny opis z konfiguracji.";
$texty_tab['sklep_admin_form_keywords']="słowa kluczowe (keywords) dla wyszukiwarek";
$texty_tab['sklep_admin_form_title']="title dla wyszukiwarek";
$texty_tab['sklep_admin_form_hkeywords']="Grupa wybranych słów - haseł, fraz oddzielonych przecinkami charakteryzujących serwis www. Nie więcej niz 20-30 haseł. Jeśli puste to zastosowany będzie domyślny zestaw słów  z konfiguracji.";

$texty_tab['sklep_admin_a_usuwanie_log']="sklepykuły - usuwanie";	
$texty_tab['sklep_admin_a_nieel']="Nieprawidłowy element!"; 
$texty_tab['sklep_admin_a_param_log']="zmiana parametrów struktury";
$texty_tab['sklep_admin_a_blok_log']="sklepykuły - usuwanie blokad";	
$texty_tab['sklep_admin_konfig_form']="Edycja szczegółów - konfiguracja kategorii";
$texty_tab['sklep_admin_form_idtflink']="identyfikator elementu w postaci przyjaznej dla wyszukiwarek";	
$texty_tab['sklep_admin_form_hidtflink']="Pozwala tworzyć do kategorii link w formie przyjaznej dla wyszukiwarek, zawierający słowa kluczowe lub znaczące frazy. Uwaga - identyfikator nie moze zawierać znaków specjalnych, narodowych a znak spacji należy zastąpić podkreśleniem lub myślnikiem";
$texty_tab['sklep_admin_form_idtflinkh']="Wyłącznie  cyfry, znak - oraz litery bez znaków narodowych";
$texty_tab['sklep_admin_form_idtflinkh']="podtytuł";
$texty_tab['sklep_admin_form_listas']="Lista kategorii produktów";  

$texty_tab['sklep_admin_gal_param_log']="Galerie zmiana parametru";
$texty_tab['sklep_admin_galeria_usun_log']="Galerie usuwanie zdjęć";
$texty_tab['sklep_galerie_edytujk']="Edytuj parametry zdjęcia";
$texty_tab['sklepadmin_galeria']="Galeria zdjęciowa";
$texty_tab['sklepadmin_gal_nr']="Nr";
$texty_tab['sklepadmin_gal_zdjecie']="Zdjęcie";
$texty_tab['sklepadmin_gal_param']="Parametry";		
$texty_tab['sklepadmin_gal_wysokosc']="wysokość";		
$texty_tab['sklepadmin_gal_szerokosc']="szerokość";	
$texty_tab['sklepadmin_gal_px']="px";	
$texty_tab['sklepadmin_gal_status']="Status";		
$texty_tab['sklepadmin_gal_wys']="Wys.";		
$texty_tab['sklepadmin_gal_glosow']="Głosów";		
$texty_tab['sklepadmin_gal_ocen']="Ocen";					
$texty_tab['sklepadmin_gal_obrobka']="do edycji";
$texty_tab['sklepadmin_gal_powrot']="Powrót do sklepykułu";
$texty_tab['sklepadmin_galf_dodawanie']="Dodawanie zdjęcia do galerii";
$texty_tab['sklepadmin_galf_edycja']="Edycja zdjęcia w galerii";
$texty_tab['sklepadmin_galf_tytul']="tytuł zdjęcia:";
$texty_tab['sklepadmin_galf_opis']="opis zdjęcia:";				
$texty_tab['sklepadmin_galf_licznik']="licznik wyświetleń";
$texty_tab['sklepadmin_galf_suma']="suma głosów";
$texty_tab['sklepadmin_galf_ilosc']="ilość głosów";			
$texty_tab['sklepadmin_galf_obrobka']="zdjęcie do dalszej obróbki graficznej";
$texty_tab['admin_galf_obrobkah']="Zdjęcie będzie dostępne wyłącznie w administracji zapisane w możliwie dużym rozmiarze, przeznaczone do dalszej obróbki graficznej z poziomu panelu administracyjnego - skalowanie, kadrowanie itp";	
$texty_tab['sklepadmin_galf_powrot']="Powrót do galerii";

$texty_tab['sklep_admin_gal_kedycja']="Galeria edycja konfiguracji zdjęcia";
$texty_tab['sklepadmin_gal_eplik']="Edycja pliku graficznego";	 				
$texty_tab['sklep_admin_gal_kobrot']="Galeria obrót zdjęcia";
$texty_tab['sklepadmin_galf_pkonfig']="Edycja pliku graficznego";
$texty_tab['sklep_admin_galf_obr90']="Obróc o 90 stopni w lewo"; 	
$texty_tab['sklep_admin_galf_obr90w']="obróć zdjęcie o 90 stopni w lewo";			
$texty_tab['sklep_admin_galf_obr90n']="Obróc o 90 stopni w prawo"; 	
$texty_tab['sklep_admin_galf_obr90nw']="obróć zdjęcie o 90 stopni w prawo";								  
$texty_tab['sklep_admin_galf_obr180']="Obróc o 180 stopni"; 	
$texty_tab['sklep_admin_galf_obr180w']="obróć zdjęcie o 180 stopni";					
$texty_tab['sklep_admin_galf_zaznacz']="Zaznacz myszką obszar kadrowania zdjęcia:";
$texty_tab['sklep_admin_galf_zaznaczh']="Obrazek po kliknięciu ZAPISZ zostanie przycięty do zaznaczonego obszaru. Jeśli chcesz zaznaczyć kwadratowy obszar podczas przeciągania myszką przytrzymaj SHIFT na klawiaturze.";		
$texty_tab['sklep_admin_galf_oparametry']="Parametry zaznaczonego obszaru zdjęcia:";
$texty_tab['sklep_admin_galf_oszerokosc']="szerokośc:";
$texty_tab['sklep_admin_galf_opolozenie']="położenie";
$texty_tab['sklep_admin_galf_owysokosc']="wysokość:";
$texty_tab['sklep_admin_galf_oresetuj']="Resetuj";						
$texty_tab['sklep_admin_galf_okadruj']="Kadruj zdjęcie";		
$texty_tab['sklep_admin_galf_owielokrotne']="Wielokrotne edytowanie zdjęcia może spowodować utratę jakości w stosunku do jego pierwotnej wersji.";
$texty_tab['sklep_admin_galf_owszystkie']="Wszystkie naniesione zmiany graficzne są nieodwracalne, nie ma możliwości wycofania akcji wykonanych na danym zdjęciu.";
$texty_tab['sklep_admin_gal_dodaniek']="Galeria - dodanie zdjęcia";
$texty_tab['sklep_admin_gal_edycjak']="Galeria edycja zdjęcia";
 
?>