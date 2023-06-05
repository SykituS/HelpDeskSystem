# Tytuł projektu

Projekt “Help Desk” ma za zadanie ułatwić komunikację między użytkownikami a osobami z danych działów odpowiedzialnym za pomoc w razie awarii czy też innych problemów. Aplikacja nie dosyć, że ułatwi kontakt i przeprowadzanie konwersacji z odpowiednimi osobami, to dodatkowo umożliwi nam na trzymanie i przeglądanie historii złożonych przez nas zgłoszeń lub też zgłoszeń w których braliśmy udział lub je do siebie przypisaliśmy.

## Wymagania systemowe

- wersja apache'a: Apache/2.4.38 (Debian)
- wersja PHP: 8.1.17
- wersja MySQL: 8.0.33

## Instalacja

Po wrzuceniu strony na serwer należy udać się na adres url naszej strony gdzie powinna się znajdować, zostanie uruchomiony wówczas instalator strony, w przypadku gdy instalator się nie uruchamia upewnij się że plik "Install.php" znajduje się w tej samej lokalizacji co index.php, wówczas przejdź ręcznie do instalatora poprzez podanie url _/Install.php gdzie _ to jest bazowy adres url naszej strony.

Przykład:
Przypadek 1: automatyczne uruchomienie instalatora:
Wejście na stronę: https://www.manticore.uni.lodz.pl/~mjaruga
Automatyczne uruchomienie instalatora.

Przypadek 2: ręczne uruchomienie instalatora:
Wejście na stronę: https://www.manticore.uni.lodz.pl/~mjaruga
instalator się nie uruchamia
Ręczne uruchomienie instalatora poprzez podanie url https://www.manticore.uni.lodz.pl/~mjaruga/Install.php
Uruchomienie instalatora

Przed przejściem do procesu instalacji upewnij się że utworzona została baza danych w technologii MySQL która będzie przetrzymywała dane na temat systemu HelpDesk.

### Proces instalacji:

Instalator składa się z 7 kroków

1. Rozpoczęcie instalacji: tutaj sprawdzane jest czy istnieje plik Config.php, w przypadku jego braku wymagane jest jego utworzenie, jeśli plik istnieje sprawdzone zostanie czy plik ten posiada odpowiednie uprawnienia, wymagane jest aby można było odczytywać i zapisywać plik Config.php.
   Jeśli te warunki są spełniane instalator uruchomi krok 2
2. Formularz konfiguracji bazy danych, tutaj będzie wymagane podanie nazwy wcześniej utworzonej bazy danych, serwera na którym ta baza się znajduje, login i hasło użytkownika bazy danych który ma możliwość tworzenia tabel, dodawania, modyfikacji danych do tabel. Możliwe też jest dodanie prefix'a dla tabel w bazie.
3. Zaimportowane zostają tutaj tabele dla bazy danych, użytkownik nic tutaj nie musi robić.
4. Formularz konfiguracji aplikacji, wymagane tutaj jest podanie danych takie nazwa aplikacji, bazowy adres domenowy dla naszej aplikacji, datę powstania, wersja, nazwa firmy, ulica i miasto położenia firmy jak i numer telefonu firmowego.
   Kolejnymi polami tego formularza jest utworzenie konta administratora, musimy podać imię i nazwisko administratora, nazwę działu w którym pracuje administrator, jego adres email oraz wymagane jest podanie hasła i jego potwierdzenie.
5. Zapisywane są tutaj dane na temat konfiguracji aplikacji, dane te znajdziemy w pliku Config.php, użytkownik nic tutaj nie musi robić.
6. Tworzone są tutaj nowe rekordy do bazy na temat oddziału w którym pracuje administrator i tworzone jest także konto administratora, użytkownik nic tutaj nie musi robić.
7. Zakonczenie instalatora, możliwe jest usunięcie plików związane z instaltorem taki jak Install.php oraz folderu InstallationResources w folderze Configuration.

//TODO:
Instrukcja instalacji projektu, w tym do jakich plików i do jakich katalogów należy ustawić odpowiednie uprawnienia

## Autorzy

#### **Mateusz Jaruga**

- **nr album: 392803**
- **Login: mjaruga**

#### **Mateusz Kalenik**

- **nr album: 392799**
- **Login: mati9821**

## Wykorzystane zewnętrzne biblioteki

- bootstrap 5.2.3
- jquery 3.6.0
- feather icons
- Flastpicker -> Wybieranie daty
