default: test

down:
	docker-compose down

up:
	docker-compose up -d --build

test:
	docker-compose exec server bash -c "./vendor/bin/phpunit --color --testdox --stop-on-failure"

coverage:
	docker-compose exec server bash -c "XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html coverage"

router:
	docker-compose exec server bash -c "./bin/console debug:router"

schema:
	docker-compose exec server bash -c "./bin/console doctrine:schema:update --force"
	docker-compose exec server bash -c "./bin/console doctrine:schema:update --force --env=test"

reset_database:
	docker-compose exec server bash -c "./bin/console doctrine:database:drop --force"
	docker-compose exec server bash -c "./bin/console doctrine:database:drop --force --env=test"
	docker-compose exec server bash -c "./bin/console doctrine:database:create"
	docker-compose exec server bash -c "./bin/console doctrine:database:create --env=test"

rebuild_db: reset_database schema

bash_server:
	docker-compose exec server bash

bash_database:
	docker-compose exec database bash
