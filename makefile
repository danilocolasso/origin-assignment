start:
	cp .env.dev .env
	docker-compose up -d --build
	docker-compose exec app composer install
	docker-compose exec app composer dump-autoload
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan key:generate
	docker-compose exec app chmod 777 ./storage
	docker-compose exec app php artisan serve --host 0.0.0.0 --port 8002

stop:
    docker-compose stop

down:
	docker-compose down -v

restart:
	${MAKE} down
	${MAKE} start
