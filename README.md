# Tytuł projektu
Fiszki - system do nauki języka angielskiego

## Wymagania systemowe
* wersja apache'a: 2.4.41
* wersja PHP'a: 7.4.3
* wersja MySQL: 5.1.1

## Instrukcja
GUEST:
Gdy wejdziemy na strone możemy z niej korzystać jako i się nie zalogujemy to możemy korzystać z funkcjonalności Guest'a:
-   Przeglądanie strony startowej z krótkim opisem funkcjonalności
-   Zalogowanie się do istniejącego konta
-   Zarejestrowanie się

USER:
Email: user1@example.com
Hasło: user1

Gdy zalogoujemy się na konto usera, możemy korzystać z takich funkcjonalności jak:
-   Zmiana ustawień konta: Imię, nazwisko, email, miejscowość, ulica, numer ulicy
-   Tworzenie, edycja i kasowanie własnych fiszek
-   Przeglądanie fiszek wszystkich użytkowników
-   Raportowanie błędów dotyczących fiszek

ADMIN:
Email: admin@example.com
Hasło: admin

Po zalogowaniu się na konto admina, możemy jako admin mieć dostęp do:
-   Edycje danych użytkowników: Imię, nazwisko, email, miejscowość, ulica, numer ulicy
-   Edycja fiszek wszystkich użytkowników
-   Wyświetlenie zgłoszeń na temat fiszek. Admin po przeanalizowaniu ma możliwość usunięcia zgłoszonej fiszki lub anulowanie zgłoszenia i zachowanie fiszki.

Zaimplementowane został wszystkie podstawowe operacje bazodanowe (CRUD). Aplikacja posiada trzy poziomy uwierzytelniania (tj. Guest, User, Admin), zapewniając odpowiedni poziom bezpieczeństwa dla różnych typów użytkowników. W folderze na manticore znajduje się schemat bazy danych (schemat bazy danych).

## Instalacja
Opis instalacji, czyli jak uruchomić system fiszki
1. Pobieramy XAMPP ze strony https://www.apachefriends.org/pl/download.html 
2. Następnie przechodzimy do pobrania plików systemu fiszek
3. Po pobraniu i zainstalowaniu XAMPP. W pliku htdocs należy umieścić pliki systemu fiszek
4. Uruchamiamy XAMPP i startujemy przyciskiem start przy module APACHE oraz MYSQL
5. W wyszukiwarkę wpisujemy http://127.0.0.1/phpmyadmin/
6. W zakładce po lewej stronie klikamy NEW i wpisujemy nazwę bazy danych (2025_pawel123). Potiwerdzamy zmiany klikając przycisk CREATE
7. Następnie wybieramy utworzony projekt i klikamy zakładkę import. Wybieramy plik załączamy pobraną baze systemu z fiszkami i potwierdzamy klikając import na dole strony. Zostanie utworzona baza danych. Aby przeglądać tabele należy wybrać zakładkę Structure.
8. Końcowym krokiem jest wpisanie w wyszukiwarkę http://127.0.0.1/ zostanie nam wyświetlona strona startowa, która zawiera podstawowe informacje na temat naszego systemu

## Wykorzystane zewnętrzne biblioteki

* bootstrap (v5.0.6)
* fonts.googleapis.com

