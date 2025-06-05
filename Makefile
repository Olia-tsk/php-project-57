start:
	php artisan serve --host 0.0.0.0
	
install:
	composer install

lint:
	composer exec --verbose phpcs -- --standard=phpcs.xml

lint-fix:
	composer exec --verbose phpcbf -- --standard=phpcs.xml
