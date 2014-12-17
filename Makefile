composer.phar:
	curl -so composer.phar https://getcomposer.org/composer.phar
	chmod +x composer.phar

vendor: composer.phar
	./composer.phar install

tests: vendor
	./vendor/bin/phpunit \
		-c phpunit.xml.dist \
		--coverage-html ./build/coverage \
		--coverage-clover ./build/logs/clover.xml \

lint: force
	php -l src/J/

travis-init: vendor
travis-run: tests
travis-report: force
	php vendor/bin/test-reporter --stdout > codeclimate.json
	curl -X POST -d @codeclimate.json -H "Content-Type: application/json" -H "User-Agent: Code Climate (PHP Test Reporter v1.0.1-dev)"  https://codeclimate.com/test_reports

force: