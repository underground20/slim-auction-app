docker-up:
	docker-compose up -d

test-unit:
	docker-compose exec api-php-cli composer test -- --testsuite=unit

test-functional:
	docker-compose exec api-php-cli composer test -- --testsuite=functional

test:
	docker-compose exec api-php-cli composer test

psalm:
	docker-compose exec api-php-cli composer psalm

cs-fix:
	docker-compose exec api-php-cli composer cs-fix

lint:
	docker-compose exec api-php-cli composer lint
	docker-compose exec api-php-cli composer cs-check

api-composer-install:
	docker-compose run --rm api-php-cli composer install

docker-build:
	docker-compose up -d --build

docker-down:
	docker-compose down --remove-orphans
