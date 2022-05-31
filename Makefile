ARGS=$(filter-out $@, $(MAKECMDGOALS))

up: docker-up
down: docker-down
stop: docker-stop
start: docker-star
restart: docker-restart
build: docker-build
init: create-env create-var-dir create-logs-dir docker-down-clear docker-pull build-php-fpm-image docker-build docker-up composer-install

create-env:
	if [ ! -f './.env' ]; then cp ./.env-sample ./.env; else exit 0; fi;

create-logs-dir:
	if [ ! -d 'app/logs' ]; then mkdir -m 777 app/logs; else exit 0; fi;

create-var-dir:
	if [ ! -d 'app/var' ]; then mkdir -m 777 app/var; else exit 0; fi;

docker-up:
	docker-compose up --detach

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down --volumes --remove-orphans

docker-stop:
	docker-compose stop

docker-start:
	docker-compose start

docker-restart:
	docker-compose restart

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

composer-install:
	docker-compose run --rm --no-deps php-cli composer install

composer-update:
	docker-compose run --rm --no-deps php-cli composer update ${ARGS}

composer-require:
	docker-compose run --rm --no-deps php-cli composer require ${ARGS}

composer-remove:
	docker-compose run --rm --no-deps php-cli composer remove ${ARGS}

composer-install-no-dev:
	docker-compose run --rm --no-deps php-cli composer install --no-dev

shell-cli:
	docker-compose run --rm --no-deps php-cli bash

shell-fpm:
	docker-compose exec php-fpm bash

shell-nginx:
	docker-compose exec nginx sh

shell-mysql:
	docker exec -it blog-mysql bash

build-php-fpm:
	docker-compose build php-fpm

build-php-cli:
	docker-compose build php-cli

build-php: composer-install-no-dev build-php-fpm composer-install

log-application: service=php-fpm
log-application: log

log:
	docker-compose logs -f $(service)

%:
	@true
