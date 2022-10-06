<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$texty_tab['rot_stat']="Statystyka";
$texty_tab['rot_stat_ogolne']="Ogólne:";	
$texty_tab['rot_stat_nazwa']="Nazwa:";
$texty_tab['rot_stat_ilosc']="Ilość:";		
$texty_tab['rot_stat_ilew']="Ilość wszystkich elementów";		
$texty_tab['rot_stat_sumaw']="Suma wyświetleń";		
$texty_tab['rot_stat_sumak']="Suma kliknięć";		
$texty_tab['rot_stat_typy']="Typy plików:";	
$texty_tab['rot_stat_link']="Linki zewnętrzne";		
$texty_tab['rot_stat_nw']="Najczęściej wyświetlane:";
$texty_tab['rot_stat_nk']="Najczęściej klikane:";	
$texty_tab['rot_stat_kw']="Kliknięcia do wyświetleń:";	
$texty_tab['rot_typy']="Typy banerów:";
$texty_tab['rot_typy_nazwa']="nazwa kategorii:";
$texty_tab['rot_typy_ilosc']="ilość";
$texty_tab['rot_typy_typyp']="typy plików:";
$texty_tab['rot_typy_sod']="szerokość od:";
$texty_tab['rot_typy_px']="px";
$texty_tab['rot_typy_do']="do:";
$texty_tab['rot_typy_wod']="wysokość od:";
$texty_tab['rot_typy_do']="do:";
$texty_tab['rot_typy_max']="max.:";
$texty_tab['rot_typy_kb']="kb)";			
$texty_tab['rot_typy_wszystkie']="wszystkie banery";		

$texty_tab['rot_arch_lista']="Lista banerów, reklam (";
$texty_tab['rot_arch_typ']="Typ banerów:";
$texty_tab['rot_arch_id']="id";
$texty_tab['rot_arch_baner']="baner";
$texty_tab['rot_arch_aktywnosc']="daty";
$texty_tab['rot_arch_status']="status";
$texty_tab['rot_arch_jezyk']="język";
$texty_tab['rot_arch_prio']="prior.";
$texty_tab['rot_arch_udzial']="udział";
$texty_tab['rot_arch_wys']="wys.";
$texty_tab['rot_arch_klik']="klik.";
$texty_tab['rot_arch_od']="od:";
$texty_tab['rot_arch_do']="do:";
$texty_tab['rot_arch_astat']="statystyka";	
$texty_tab['rot_arch_listakat']="lista kategorii rotatorów/informacji";		
$texty_tab['rot_arch_szuk_status1']="tylko aktywne";
$texty_tab['rot_arch_szuk_status2']="tylko nieaktywne";
$texty_tab['rot_arch_szuk_status0']="--status banera--";
$texty_tab['rot_arch_szuk_dostepne']="tylko dostępne";
$texty_tab['rot_arch_szuk_niedostepne']="tylko niedostępne";
$texty_tab['rot_arch_szuk_dostepnosc']="--dostępność wyświetlania--";
$texty_tab['rot_arch_lang']="--wersja językowa--";

$texty_tab['rot_form_edycja']="Edycja banera:";
$texty_tab['rot_form_uzupelnij']="Uzupełnij dane";
$texty_tab['rot_form_dodawanie']="Dodawanie banera:";		
$texty_tab['rot_form_dataod']="data startu wyświetlania";
$texty_tab['rot_form_datado']="data ważności, wyświetlaj do dnia";
$texty_tab['rot_form_typ']="typ banera/reklamy*:";
$texty_tab['rot_form_typwyb']="--wybierz--";
$texty_tab['rot_form_tytul']="tytuł/nazwa*:";
$texty_tab['rot_form_linkg']="link na banerze:";
$texty_tab['rot_form_okno']="okno, w którym otwieramy link";		
$texty_tab['rot_form_noweokno']="- nowe okno";
$texty_tab['rot_form_tosamookno']="- to samo okno";
$texty_tab['rot_form_dotychczasowa']="dotychczasowa grafika:";		
$texty_tab['rot_form_grafika']="grafika:*";
$texty_tab['rot_form_wymiary']="wymiary:";
$texty_tab['rot_form_mozliwosc']="(możliwość ręcznej zmiany tylko dla SWF)";		
$texty_tab['rot_form_wys']="wysokość (px)";
$texty_tab['rot_form_szer']="szerokość (px)";
$texty_tab['rot_form_tlo']="tło";
$texty_tab['rot_form_tylko swf']="(tylko dla SWF)";			
$texty_tab['rot_form_przezroczysty']="przezroczysty"; 				
$texty_tab['rot_form_link']="kod do linku/grafiki:";
$texty_tab['rot_form_opis']="opis, informacje:";
$texty_tab['rot_form_czywys']="czy zliczać wyświetlenia";
$texty_tab['rot_form_wysw']="ilość wyświetleń";
$texty_tab['rot_form_wyslimit']="limit wyświetleń (0 = bez limitu)";
$texty_tab['rot_form_czyklik']="czy zliczać kliknięcia";
$texty_tab['rot_form_klik']="ilość kliknięć";
$texty_tab['rot_form_kliklimit']="limit kliknięć (0 = bez limitu)";
$texty_tab['rot_form_brak']="--brak--";
$texty_tab['rot_form_najwyzszy']=" - najniższy";
$texty_tab['rot_form_najnizszy']=" - najwyższy";
$texty_tab['rot_form_priorytet']="priorytet - kolejność";
$texty_tab['rot_form_udzial']="udział procentowy";
$texty_tab['rot_form_dowolna']="--dowolna--";
$texty_tab['rot_form_lang']="wersja językowa";		
$texty_tab['rot_form_lista']="lista banerów/reklam";
$texty_tab['rot_form_reset']="Reset"; 

$texty_tab['rot_form_htyp']="Dostępne typy banerów zależą od konfiguracji www tworzonej na indywidualne potrzeby projektu";		
$texty_tab['rot_form_hadres']="Adres www do którego kieruje dany baner - przekierowanie na link przy kliknięciu na baner. Nie dotyczy banerów SWF.";
$texty_tab['rot_form_hgrafika']="Plik graficzny spełniający wymagania co do rodzaju i rozmiaru zdefiniowanych dla danego typu banerów";
$texty_tab['rot_form_hwymiary']="System automatycznie odczytuje rozmiar banerów, nie skaluje ich z wyjątkiem SWF. Dla plików SWF mozna zmienić odczytane rozmiary w granicach na które pozwala wybrany typ banera.";
$texty_tab['rot_form_htlo']="Wybranie przezroczystości powoduje ignorowanie koloru tła";
$texty_tab['rot_form_hlink']="Link wyświetlający zewnętrzny baner. Podanie go powoduje ignorowanie wprowadzonego banera, wprowadzonego linku na banerze oraz innych parametrów banera. Ten rodzaj banera nie ma możliwości zliczania kliknięć";
$texty_tab['rot_form_hopis']="Tylko do celów administracyjnych, np notowanie informacji o pochodzeniu banera lub o umowie na reklamę";
$texty_tab['rot_form_hwys']="Podanie limitu wyświetleń powoduje, że baner może być wyświetlany dopóki limit wyświetleń jest większy lub równy ilości wyświetleń";		
$texty_tab['rot_form_hklik']="Podanie limitu kliknięć powoduje, że baner może być wyświetlany dopóki limit kliknięć jest większy lub równy ilości Kliknięć. Zliczanie kliknięć nie dotyczy baneró wprowadzonych za pomoca linku oraz banerów SWF nie przygotowanych do obsługi zliczania kliknięć";
$texty_tab['rot_form_hpriorytet']="Opcja używana przy wyświetlaniu kilku banerów na raz. Banery są pobierane zaczynając od najwyższego priorytetu. Banery o tym samym priorytecie mają względem siebie kolejność losową";
$texty_tab['rot_form_hlangt']="Określamy czy baner ma się pojawiać tylko dla jednej wersji językowej czy dla wszystkich dostępnych";
$texty_tab['rot_form_hudzial']="Opcja używana przy wyświetlaniu kilku banerów na raz. Im większy udział tym większe prawdopodobieństwo, ze baner będzie wylosowany jako pierwszy";


$texty_tab['rot_zmiena_log']="rotator - zmiana parametru:";
$texty_tab['rot_usuna_log']="rotator - usuwanie";	
$texty_tab['rot_img_brak']="Nieprawidłowy typ pliku - odrzucono.";				


?>