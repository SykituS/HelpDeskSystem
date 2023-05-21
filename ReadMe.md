# Tytuł projektu

//TODO:
Help desk

## Wymagania systemowe

- wersja apache'a: Apache/2.4.38 (Debian)
- wersja PHP: 8.1.17
- wersja MySQL: 8.0.33

## Instalacja

//TODO:
Instrukcja instalacji projektu, w tym do jakich plików i do jakich katalogów należy ustawić odpowiednie uprawnienia

## Autorzy

- **Mateusz Jaruga**
- _nr album: 392803_
- _mjaruga_

- **Mateusz Kalenik**
- _nr album: nr_
- _login z manticory_

## Wykorzystane zewnętrzne biblioteki

- bootstrap 5.2.3
- jquery 3.6.0
- feather icons

## Development

- Zainstaluj najnowszą wersję Docker'a
- Uruchom Dockera
- Pobierz repozytorium
- Zkopiuj plik Docker-Compose.yml i php.Dockerfile do głównego katalogu
- W głównym katalogu odpal konsole i uruchom komendę: docker-compose up
- Po tym jak komenda się ukończy w Dcoker -> Containers powinien pojawić się item o nazwie "helpdesk" który powinien być uruchomiony
  Oznacza to że pomyślnie utworzył się nowy Container z systemem LAMP, terminal można zamknąć i dla czytelności usunąć 2 skopiowane pliki z głównego katalogu

## Adresy stron

    url: localhost - otworzy nam stronę na systemie LAMP, jeśli pojawia się komunikat "Forbiden" to znaczy że nie ma w głównym katalogu pliku o nazwie index
    url: localhost:8001 - strona MySQL login i hasło do strony: lamp_docker, lamp_docker
