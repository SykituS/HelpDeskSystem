#Development

 - Zainstaluj najnowszą wersję Docker'a
 - Uruchom Dockera
 - Pobierz repozytorium
 - Zkopiuj plik Docker-Compose.yml i php.Dockerfile do głównego katalogu
 - W głównym katalogu odpal konsole i uruchom komendę: docker-compose up
 - Po tym jak komenda się ukończy w Dcoker -> Containers powinien pojawić się item o nazwie "helpdesk" który powinien być uruchomiony
    Oznacza to że pomyślnie utworzył się nowy Container z systemem LAMP, terminal można zamknąć i dla czytelności usunąć 2 skopiowane pliki z głównego katalogu

#Adresy stron

    url: localhost - otworzy nam stronę na systemie LAMP, jeśli pojawia się komunikat "Forbiden" to znaczy że nie ma w głównym katalogu pliku o nazwie index
    url: localhost:8001 - strona MySQL login i hasło do strony: admin, admin