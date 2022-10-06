<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$texty_tab['art_admin_stat']="Statystyka";
$texty_tab['art_admin_stat_ogolne']="Ogólne:";	
$texty_tab['art_admin_stat_nazwa']="nazwa:";
$texty_tab['art_admin_stat_ilosc']="ilość:";		
$texty_tab['art_admin_stat_ile']="Ilość wszystkich elementów";		
$texty_tab['art_admin_stat_ilea']="Ilość akapitów w artykułach";		
$texty_tab['art_admin_stat_ilen']="Ilość newsów, informacji";		
$texty_tab['art_admin_stat_ilena']="Ilość akapitów w newsach/informacjach";		
$texty_tab['art_admin_stat_ilek']="Ilość komentarzy";		
$texty_tab['art_admin_stat_kat']="Kategorie artykułów:";
$texty_tab['art_admin_stat_nazwa']="nazwa:";
$texty_tab['art_admin_stat_ilosc']="ilość:";		
$texty_tab['art_admin_stat_typy']="Typy elementów:";
$texty_tab['art_admin_stat_nazwa']="nazwa:";
$texty_tab['art_admin_stat_ilosc']="ilość:";		
$texty_tab['art_admin_stat_naj']="Najczęściej przeglądane:";		
$texty_tab['art_admin_stat_tyt']="tytuł:";
$texty_tab['art_admin_stat_wizyt']="wizyt:";	

$texty_tab['art_admin_d']="Kategorie elementów (";
$texty_tab['art_admin_d_nazwa']="nazwa działu:";
$texty_tab['art_admin_d_ilosc']="ilość:";
$texty_tab['art_admin_d_brak']="Brak zdefiniowanych kategori";
$texty_tab['art_admin_arch']="Lista elementów struktury (";
$texty_tab['art_admin_arch_listas']="Lista struktury";  
$texty_tab['art_admin_arch_edytujk']="edytuj konfigurację";		   	   
$texty_tab['art_admin_arch_nr']="nr";
$texty_tab['art_admin_arch_tyt']="tytuł";
$texty_tab['art_admin_arch_status']="status";		
$texty_tab['art_admin_arch_licznik']="licznik";		
$texty_tab['art_admin_arch_pod']="pod.";			
$texty_tab['art_admin_arch_sglowna']="strona główna serwisu";    
$texty_tab['art_admin_arch_t2']="news";
$texty_tab['art_admin_arch_t1']="tekst";
$texty_tab['art_admin_arch_t0']="html";
$texty_tab['art_admin_arch_data']="data";

$texty_tab['art_admin_arch_awyczysc']="wyczyść blokady edycji akapitów";
$texty_tab['art_admin_arch_kategorie']="kategorie struktury";
$texty_tab['art_admin_arch_nied']="Nieprawidłowy dział struktury";
$texty_tab['art_admin_arch_pidtf']="Podany identyfikator dla tej wersji językowej już istnieje, identyfikator nie został zapisany"; 
$texty_tab['art_admin_arch_elgrupn']="Element jest grupą newsów, wymaga usunięcia zawartości przed zmianą typu elementu!"; 
$texty_tab['art_admin_arch_elgrupa']="Element jest grupą artykułów, wymaga usunięcia zawartości przed zmianą typu elementu!";
$texty_tab['art_admin_arch_sdodaj_log']="struktura - dodawanie:";
$texty_tab['art_admin_arch_sedycja_log']="struktura - edycja:";
$texty_tab['art_admin_arch_zapisane']="Dane zostały zapisane";
$texty_tab['art_admin_arch_niezapisane']="Dane nie zostały prawidłowo zapisane!";
$texty_tab['art_admin_arch_nieprawidlowe']="Niepoprawne dane";
$texty_tab['art_admin_aka_dodaj_log']="artykuł - dodawanie akapitu:";
$texty_tab['art_admin_aka_edytuj_log']="artykuł - edycja akapitu:";
$texty_tab['art_admin_aka_usun_log']="artykuł: usuwanie akapitów";
$texty_tab['art_admin_edycjatresci']="Edycja treści";

$texty_tab['art_admin_form_t']="Tworzenie struktury:";  
$texty_tab['art_admin_form_e']="Edycja struktury:"; 
$texty_tab['art_admin_form_sglowna']="strona główna serwisu";	
$texty_tab['art_admin_form_idtf']="pomocniczy identyfikator elementu";
$texty_tab['art_admin_form_unikalny']="Unikalny identyfikator dla danej wersji językowej, może zawierać wyłącznie litery, cyfry i znaki - oraz _";
$texty_tab['art_admin_form_datastart']="data startu wyświetlania";
$texty_tab['art_admin_form_dataw']="data ważności, wyświetlaj do dnia";
$texty_tab['art_admin_form_tytul']="tytuł*:";
$texty_tab['art_admin_form_tytulz']="tytuł zastępczy do menu:";
$texty_tab['art_admin_form_linkz']="link zastępujący element w menu:";
$texty_tab['art_admin_form_oknol']="okno, w którym otwieramy link";
$texty_tab['art_admin_form_noweo']="- nowe okno ,";
$texty_tab['art_admin_form_tosamoo']="- to samo okno";
$texty_tab['art_admin_form_zajawka']="zajawka treści:";
$texty_tab['art_admin_form_dzial']="dział, przypisanie do menu:";
$texty_tab['art_admin_form_typz']="typ zawartości*:";
$texty_tab['art_admin_form_ilosc']="ilość akapitów/elementów na podstronie (stronicowanie):";
$texty_tab['art_admin_form_iloscbez']="0 - bez stronicowania";
$texty_tab['art_admin_form_licznik']="stan licznika odsłon";
$texty_tab['art_admin_form_koment']="użytkownicy mogą dodawać komentarze";
$texty_tab['art_admin_form_rss']="kanał RSS";
$texty_tab['art_admin_form_menunie']="nie umieszczaj w menu";
$texty_tab['art_admin_form_menuwyr']="wyróżnij w menu";
$texty_tab['art_admin_form_dostep']="typ dostępu do elementu:";
$texty_tab['art_admin_form_dogory']="dodaj link przewinięcia do góry tekstu";
$texty_tab['art_admin_form_listas']="lista elementów struktury";
$texty_tab['art_admin_form_datawys']="data informacji";
$texty_tab['art_admin_form_podtytul']="podtytuł:";
$texty_tab['art_admin_form_statnie']="nie doklejaj kodu statystyk do postrony";

$texty_tab['art_admin_form_wytworzyl']="Informację wytworzył:";
$texty_tab['art_admin_form_wytworzylkiedy']="Data wytworzenia (YYYY-MM-DD)";

$texty_tab['art_admin_form_zajawkai']="obrazek zajawki:";
$texty_tab['art_admin_form_grafika']="grafika:";

$texty_tab['art_admin_form_submenu']="submenu";
$texty_tab['art_submenu0']="elementy podrzędne";
$texty_tab['art_submenu1']="elementy równorzędne";
$texty_tab['art_submenu2']="nie wyświetlaj submenu";

$texty_tab['art_admin_form_hidtf']="Identyfikator używany do pobrania treści poza standardowym menu lub gdy element ma przypisane specjalne zadanie odróżniające go od innych. W innych przypadkach nie posiada funkcji";
$texty_tab['art_admin_form_htytulz']="Uzupełniamy gdy chcemy aby w menu element mial inną nazwę, zwykle krótsza niż tytuł główny używany w treści podstrony";		
$texty_tab['art_admin_form_hlink']="Powoduje że element w menu zostaje zastąpiony podanym linkiem - przekierowaniem do innej części www lub do zupełnie niezależnej zewnętrzej strony www";
$texty_tab['art_admin_form_hzajawka']="Używana do tworzenia zapowiedzi artykułów lub do menu opisowego zawartości strony";			
$texty_tab['art_admin_form_htypz']="Standardowa strona to typ HTML, strony bez edytora tylko do specjalnych zastosowań. Wybór typu newsy, informacje powoduje wyświetlanie zawartości w postaci zestawu informacji sortowanych według daty bez możliwości dalszego zagłębiania w strukturze www";
$texty_tab['art_admin_form_hilosc']="Podział dłuższej treści na numerowane porcje - stronicowanie. Zalecane zwłaszcza do elementów typu newsy, informacje";
$texty_tab['art_admin_form_hlicznik']="Ile razy wyświetlono zawartość www, nie uwzględnia wyświetleń przez konto zalogowanego administratora.";
$texty_tab['art_admin_form_hdostep']="Określa dla kogo jest dostępna zawartość elementu: <br /> <b>ogólny</b> - czyli dostępny dla wszystkich odwiedzających www, <b>dla zalogowanych</b> - tylko dla osób, które mają konta na www i poprawnie zalogowały się,<br /> <b>uprawnienie</b> - tylko dla osób zalogowanych posiadających odpowiednie uprawnienie,<br /> <b>specjalny</b> - element wykorzystywany w specalny sposób nie mający dostępu za pomocą bezpośredniego linku ";
$texty_tab['art_admin_form_hrss']="Elementy znajdujące się wewnątrz bierzacego elementu (podstrony lub newsy/informacje) będą wykorzystane jako informacje w postaci kanału RSS";
$texty_tab['art_admin_form_hmenunie']="Element nie będzie wyświetlany bezpośrednio w menu. Wykorzystanie opcji zależy od projektu.";
$texty_tab['art_admin_form_hmenuwyr']="Element zostanie wyróżniony w menu - np. inny kolor tła. Sposób wykorzystania zależny od projektu.";
$texty_tab['art_admin_form_hdogory']="Na końcu treści zostanie umieszczony link, który pozwala przewinąć www do góry na początek tekstu. Przydatna opcja dla zbyt długiego tekstu.";
$texty_tab['art_admin_form_himg']="Plik JPG spełniający wymagania co do rozmiarów. Uwaga, pliki JPG w palecie kolorów CMYK są odrzucane. Strony WWW obsługują wyłącznie paletę RGB";
$texty_tab['art_admin_form_hstatnie']="Powoduje, że dana strona nie będzie uzgledniana w zewnętrznych systemach statystyk, jeśli są one zdefiniowane.";

$texty_tab['art_admin_form_description']="opis podstrony (description) dla wyszukiwarek";
$texty_tab['art_admin_form_hdescription']="Krótki (2-3 zdania) opis podstrony strony dla wyszukiwarek. Jeśli pusty to zastosowany będzie domyślny opis z konfiguracji.";
$texty_tab['art_admin_form_keywords']="słowa kluczowe (keywords) dla wyszukiwarek";
$texty_tab['art_admin_form_title']="title dla wyszukiwarek";
$texty_tab['art_admin_form_hkeywords']="Grupa wybranych słów - haseł, fraz oddzielonych przecinkami charakteryzujących serwis www. Nie więcej niz 20-30 haseł. Jeśli puste to zastosowany będzie domyślny zestaw słów  z konfiguracji.";

$texty_tab['art_admin_aform_t']="Tworzenie nowego akapitu:";
$texty_tab['art_admin_aform_e']="Edycja akapitu:";
$texty_tab['art_admin_aform_tytul']="podtytuł akapitu:";
$texty_tab['art_admin_aform_tresc']="treść:";
$texty_tab['art_admin_aform_gjpg']="grafika JPG:";
$texty_tab['art_admin_aform_opisg']="opis obrazka, tekst alternatywny:";
$texty_tab['art_admin_aform_linkg']="link na grafice:";
$texty_tab['art_admin_aform_oknog']="okno, w którym otwieramy link";
$texty_tab['art_admin_aform_noweo']="- nowe okno ,";
$texty_tab['art_admin_aform_tosamo']="- to samo okno";
$texty_tab['art_admin_aform_nieskaluj']="nie skaluj";
$texty_tab['art_admin_aform_px']="px";
$texty_tab['art_admin_aform_przeskaluj']="nową grafikę przeskaluj na wybrany wymiar";
$texty_tab['art_admin_aform_polozenieg']="grafika względem tekstu";
$texty_tab['art_admin_aform_katalog']="katalog z galerią zdjęć:";
$texty_tab['art_admin_aform_podglad']="Podgląd treści";
$texty_tab['art_admin_aform_listael']="lista elementów struktury";
$texty_tab['art_admin_a_usuwanie_log']="artykuły - usuwanie";	
$texty_tab['art_admin_a_glowny_log']="ustawienie elementu głównego";
$texty_tab['art_admin_a_nieel']="Nieprawidłowy element!"; 
$texty_tab['art_admin_a_param_log']="zmiana parametrów struktury";
$texty_tab['art_admin_a_blok']="Blokady edycji artykułów zostały usunięte";
$texty_tab['art_admin_a_blok_log']="artykuły - usuwanie blokad";	
$texty_tab['art_admin_konfig_form']="Edycja szczegółów - konfiguracja elementu";
$texty_tab['art_admin_form_mapanie']="nie umieszczaj w mapie www";
$texty_tab['art_admin_form_hmapanie']="Opcja ma znaczenie gdy serwis www posiada funkcję mapa strony";		
$texty_tab['art_admin_form_tytulnie']="nie wyświetlaj tytułu podstrony/artykułu";
$texty_tab['art_admin_form_htytulnie']="Używamy gdy nie chcemy aby nad tekstem pojawił sie tytuł nadany danemu elementowi. Nie dotyczy jeśli element jest przekierowaniem na inny link lub gdy tytuł jest wykorzystywany w niestandardowy sposób";
$texty_tab['art_admin_form_stopkanie']="nie wyświetlaj stopki artykułu";
$texty_tab['art_admin_form_hstopkanie']="Artykuł może posiadać stopke z linkami do druku, z informacjami o datach edycji, autorach, itp. Zaznaczająć tą opcje wyłączamy dla danego elementu wyświetlanie stopki lub ewentualnie ograniczamy jej zawartość";
$texty_tab['art_admin_form_idtflink']="identyfikator elementu w postaci przyjaznej dla wyszukiwarek";	
$texty_tab['art_admin_form_hidtflink']="Pozwala tworzyć do artykułu link w formie przyjaznej dla wyszukiwarek, zawierający słowa kluczowe lub znaczące frazy. Uwaga - identyfikator nie moze zawierać znaków specjalnych, narodowych a znak spacji należy zastąpić podkreśleniem lub myślnikiem";
$texty_tab['art_admin_form_idtflinkh']="wyłącznie  cyfry, znak - oraz litery bez znaków narodowych";
$texty_tab['art_admin_form_glowny']="ustaw jako stronę domyślną";
$texty_tab['art_admin_form_hglowny']="Używane w zależności od projektu, powoduje, że podstrona jest wyświetlana domyślnie dla całej WWW lub wybranego działu";		

$texty_tab['art_admin_form_gwt']="grafika względem tekstu";
$texty_tab['art_admin_form_zrodlo']="źródło informacji:";
$texty_tab['art_admin_form_hzrodlo']="Podaj źródło pochodzenia informacji, jeśli trzeba określić prawa autorskie do zamieszczonej treści";		

$texty_tab['art_admin_akapity_edytujk']="Edycja konfiguracji akapitu";
$texty_tab['art_admin_akapity_kramka']="grubość ramki:";
$texty_tab['art_admin_akapity_kramkah']="Obramowanie wokół akapitu wyrażone w pikselach. Wartość równa 0 oznacza brak obramowania.";	
$texty_tab['art_admin_akapity_ksser']="szerokość akapitu:";
$texty_tab['art_admin_akapity_kszerh']="Szerokośc w % dostępnej całkowitej szerokości. Wartość równa 0 lub 100 oznacza całkowitą dostępną szerokość.";			
$texty_tab['art_admin_akapity_kmargines']="margines:";
$texty_tab['art_admin_akapity_kmarginesh']="margines wokół tekstu wyrażony w pikselach";			
$texty_tab['art_admin_akapity_kramkak']="kolor ramki:";
$texty_tab['art_admin_akapity_kramkakh']="Kolor obramowania akapitu. Brak wybranego koloru oznacza brak obramowania";	
$texty_tab['art_admin_akapity_ktlo']="kolor tła:";
$texty_tab['art_admin_akapity_ktloh']="kolor tła akapitu. Brak wybranego koloru oznacza brak tła";	
$texty_tab['art_admin_akapity_kgalw']="ilość zdjęć w wierszu:";
$texty_tab['art_admin_akapity_kgalwh']="sposób podziału na wiersze zależny od projektu i od wybranego typu galerii. Wartość 0 oznacza domyślną ilośc zdjęć w wierszu.";
$texty_tab['art_admin_akapity_kgalh']="ilość wierszy na podstronie:";
$texty_tab['art_admin_akapity_kgalhh']="sposób podziału galerii na podstrony zależny od projektu i od wybranego typu galerii. Wartość = 0 oznacza brak stronicowania galerii lub domyślne stronicowanie";
$texty_tab['art_admin_akapity_kgalt']="typ galerii zdjęciowej:";
$texty_tab['art_admin_akapity_kgalth']="sposób wyświetlania zdjęć na WWW, zależny od projektu.";
$texty_tab['art_admin_akapity_kpowrot']="Powrót do podglądu";
$texty_tab['art_admin_akapity_klog']="Edycja konfiguracji akapitu ";

$texty_tab['art_admin_akapity_sgalt']="typ skalowania miniaturek zdjęć";					
$texty_tab['art_admin_akapity_galw']="szerokość miniaturek zdjęć:";			
$texty_tab['art_admin_akapity_wgalh']="Wartośc zerowa oznacza domyślny rozmiar sklowania. Użycie parametru jest zależne od projektu i wyboru typu skalowania";									
$texty_tab['art_admin_akapity_galh']="wysokość miniaturek zdjęć:";			
$texty_tab['art_admin_akapity_zalezne']="wiersze galerii zależne";
$texty_tab['art_admin_akapity_zalezneh']="Zaznaczenie opcji oznacza, że galeria tworzy jedną tabelę i rozklad zdjęć w kolumnach jest identyczy";				

$texty_tab['artadmin_gal_eplik']="Edycja pliku graficznego";	 				
$texty_tab['art_admin_gal_kobrot']="Galeria obrót zdjęcia";
$texty_tab['artadmin_galf_pkonfig']="Edycja pliku graficznego";
$texty_tab['art_admin_form_idtflinkh']="podtytuł";
$texty_tab['art_admin_gal_param_log']="Galerie zmiana parametru";
$texty_tab['art_admin_galeria_usun_log']="Galerie usuwanie zdjęć";
$texty_tab['art_galerie_edytujk']="Edytuj parametry zdjęcia";
$texty_tab['artadmin_galeria']="Galeria zdjęciowa";
$texty_tab['artadmin_gal_nr']="Nr";
$texty_tab['artadmin_gal_zdjecie']="Zdjęcie";
$texty_tab['artadmin_gal_param']="Parametry";		
$texty_tab['artadmin_gal_wysokosc']="wysokość";		
$texty_tab['artadmin_gal_szerokosc']="szerokość";	
$texty_tab['artadmin_gal_px']="px";	
$texty_tab['artadmin_gal_status']="Status";		
$texty_tab['artadmin_gal_wys']="Wys.";		
$texty_tab['artadmin_gal_glosow']="Głosów";		
$texty_tab['artadmin_gal_ocen']="Ocen";					
$texty_tab['artadmin_gal_obrobka']="do edycji";
$texty_tab['artadmin_gal_powrot']="Powrót do artykułu";
$texty_tab['artadmin_galf_dodawanie']="Dodawanie zdjęcia do galerii";
$texty_tab['artadmin_galf_edycja']="Edycja zdjęcia w galerii";
$texty_tab['artadmin_galf_powrot']="Powrót do galerii";
$texty_tab['art_admin_gal_kedycja']="Galeria edycja konfiguracji zdjęcia";
$texty_tab['art_admin_gal_dodaniek']="Galeria - dodanie zdjęcia";
$texty_tab['art_admin_gal_edycjak']="Galeria edycja zdjęcia";
 
	
?>