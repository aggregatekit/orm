test:
	docker compose run --rm orm-test bash -c "\
		composer dump-autoload && \
		vendor/bin/phpunit tests --display-deprecations"
stan:
	docker compose run --rm orm-test vendor/bin/phpstan analyse