composer.phar:
	curl -so composer.phar https://getcomposer.org/composer.phar
	chmod +x composer.phar

vendor: composer.phar
	./composer.phar install

tests: vendor
	./vendor/bin/phpunit

coverage: vendor
	./vendor/bin/phpunit --coverage-html=./build/coverage