<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$texty_tab['konfig_form_edycja']="Edycja konfiguracji";
$texty_tab['konfig_form_tytul']="Tytuł serwisu www";	
$texty_tab['konfig_form_htytul']="Tytuł domyślny, pojawia się w nagłówkowym pasku przeglądarki www oraz w zależności od projektu w wybranych częściach serwisu www";
$texty_tab['konfig_form_tytulp']="Przedrostek do tytułu";	
$texty_tab['konfig_form_htytulp']="Przedrostek po zdefiniowaniu jest automatycznie dodawany do tytułu strony tam gdzie tytuł główny jest zastępowany innym tekstem. Dla przykładu przedrostkiem może być krótka główna nazwa serwisu a na podstronach będzie do niego doklejony tytuł podstrony";
$texty_tab['konfig_form_description']="Opis (description) dla wyszukiwarek";
$texty_tab['konfig_form_hdescription']="Krótki (2-3 zdania) opis strony dla wyszukiwarek";
$texty_tab['konfig_form_keywords']="Słowa kluczowe (keywords) dla wyszukiwarek";
$texty_tab['konfig_form_hkeywords']="Grupa wybranych słów - haseł, fraz oddzielonych przecinkami charakteryzujących serwis www. Nie więcej niz 20-30 haseł";
$texty_tab['konfig_form_kontakte']="Email kontaktowy";	
$texty_tab['konfig_form_hkonakte']="Email kontaktowy używany w zależności od projektu, np. jako nadawca formularza kontaktowego lub wyświetlany w treści www";
$texty_tab['konfig_form_kontakta']="Nadawca kontaktowy (podpis)";
$texty_tab['konfig_form_hkonakta']="Nazwa nadawcy, podpis kontaktowego adresu email";
$texty_tab['konfig_form_lang']="Domyślna wersja językowa";	
$texty_tab['konfig_form_hlang']="Wersja językowa, która jest domyślnie aktywna po wejściu na www";		
$texty_tab['konfig_form_zapisz']="zapisz";
$texty_tab['konfig_form_panel']="Panel administracyjny";	
$texty_tab['konfig_zap_zmiana_log']="konfiguracja - zmiana danych";
$texty_tab['konfig_form_kodstat']="Kod statystyk oglądalności";
$texty_tab['konfig_form_hkodstat']="Kod statystyk oglądalności np. Google Analytics. Umieszany tutaj kod jest automatycznie dodawany na końcu każdej podstrony w celu zbierania informacji o użytkownikach korzystających z WWW";

$texty_tab['konfig_form_smtp']="Uwierzytenianie  wysyłanej poczty (dane SMTP)";	
$texty_tab['konfig_form_hsmtp']="Wymagane w zależności od ustawień serwera nadawcy, w celu uwierzyteniania poczty email wychodzącej ze strony WWW";
$texty_tab['konfig_form_smtphost']="Host:";				
$texty_tab['konfig_form_smtplogin']="Login:";
$texty_tab['konfig_form_smtphaslo']="Hasło:";		

?>