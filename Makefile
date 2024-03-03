PHP_CONTAINER_NAME = php-interview


build:
	docker-compose build

up:
	docker-compose up

down:
	docker-compose down

migrate:
	docker exec -it $(PHP_CONTAINER_NAME) ./bin/console doctrine:migrations:migrate

consume:
	docker exec -it $(PHP_CONTAINER_NAME) ./bin/console messenger:consume async_transport -vv

test:
	docker exec -it $(PHP_CONTAINER_NAME) ./bin/phpunit

test_unit:
	docker exec -it $(PHP_CONTAINER_NAME) ./bin/phpunit --testsuite=unit