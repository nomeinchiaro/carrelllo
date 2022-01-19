default: tests

tests:
	./bin/phpunit --color

down:
	docker-compose down

up:
	docker-compose up -d --build

test:
	docker-compose exec server bash -c "./vendor/bin/phpunit --color --testdox"

router:
	docker-compose exec server bash -c "./bin/console debug:router"

schema:
	docker-compose exec server bash -c "./bin/console doctrine:schema:update --force"
	docker-compose exec server bash -c "./bin/console doctrine:schema:update --force --env=test"

bash_server:
	docker-compose exec server bash

bash_database:
	docker-compose exec database bash
