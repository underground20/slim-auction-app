docker-up:
	docker-compose up -d

api-composer-install:
	docker-compose run --rm api-php-cli composer install

docker-build:
	docker-compose up -d --build

docker-down:
	docker-compose down --remove-orphans