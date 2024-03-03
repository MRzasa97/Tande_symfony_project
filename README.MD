Zbudowanie projektu:
    make build lub docker-compose build

Po zbudowaniu:
    make start lub docker-compose start

Po wstaniu kontenerów należy uruchomić migrację:
    make migrate lub ./bin/console doctrine:migration:migrate w kontenerze php-interview

localhost/form zawiera formularz do którego należy wpisać dane i plik. Po wysłaniu formularza jest wysyłana wiadomość z danymi na kolejkę rabbitmq. Aby wiadomość została skonsumowana należy uruchomić:
    make consume lub ./bin/console messenger:consume async_transport w kontenerze php-interview

localhost/list zawiera listę danych znajdujących się w bazie. Strona jest chroniona przed dostępem na podstawie IP. Dobrze też by pewnie było utworzyć usera z odpowiednim dostępem, ale zabrakło mi na to czasu.

Napisałem też kilka testów jednostkowych i funkcjonalnych (dla kontrolera). Dla funkcjonalnych pewnie przydałoby się stworzyć jakąś testową bazę danych i skonfigurować, żeby testy do niej zapisywały. Niestety na to również zabrakło mi trochę czasu, więc póki co zapisują do tej samej bazy co reszta projektu.
Jak na razie można się dostać tylko z localhosta, ale można to modyfikować w configu.

Testy:
    make test lub ./bin/phpunit w kontenerze php-interview

Testy funkcjonalne:
    make test_unit lub ./bin/phpunit --testsuite=unit w kontenerze php-interview