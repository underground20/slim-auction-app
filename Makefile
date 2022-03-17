init: docker-build composer-install migrate

docker-up:
	docker-compose up -d

migrate:
	docker-compose exec api-php-cli composer app migrations:migrate

test-unit:
	docker-compose exec api-php-cli composer test -- --testsuite=unit

test-functional:
	docker-compose exec api-php-cli composer test -- --testsuite=functional

test:
	docker-compose exec api-php-cli composer test

psalm:
	docker-compose exec api-php-cli composer psalm

cs-fix:
	docker-compose exec api-php-cli vendor/bin/php-cs-fixer fix --allow-risky=yes

lint:
	docker-compose exec api-php-cli composer lint
	docker-compose exec api-php-cli vendor/bin/php-cs-fixer fix --allow-risky=yes --dry-run --diff

composer-install:
	docker-compose run --rm api-php-cli composer install

docker-build:
	docker-compose up -d --build

docker-down:
	docker-compose down --remove-orphans

validate-schema:
	docker-compose exec api-php-cli composer app orm:validate-schema

create-migration:
	docker-compose exec api-php-cli composer app migrations:generate

migrations-diff:
	docker-compose exec api-php-cli composer app migrations:diff
