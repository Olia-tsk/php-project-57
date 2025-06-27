start:
	php artisan serve --host 0.0.0.0
	
install:
	composer install
	npm install

key-generate:
	php artisan key:generate

migrate:
	php artisan migrate

seed:
	php artisan db:seed

build:
	npm run build

lint:
	composer exec --verbose phpcs -- --standard=phpcs.xml

lint-fix:
	composer exec --verbose phpcbf -- --standard=phpcs.xml

test:
	composer exec -- phpunit

setup:
	make install
	make key-generate
	make migrate
	make seed
	make build

reset:
	php artisan migrate:fresh --seed