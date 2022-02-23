docker-up:
	docker-compose up -d

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
