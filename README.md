# Demo Optime

## Install and run

```bash
docker-compose up
```

## Run test

```
docker-compose exec -it webserver bash
php bin/phpunit

# Code coverage
php bin/phpunit --coverage-html tests/report/
```

## Common commands

```bash
docker-compose exec -it php-fpm bash

php bin/console doctrine:database:create

php bin/console doctrine:migrations:dump-schema

php bin/console make:entity Category
php bin/console make:entity Product

php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate 


# Category CRUD
php bin/console make:controller Category
php bin/console make:form

# Producto CRUD
php bin/console make:controller Product
php bin/console make:form
```

# Bibliography

* https://symfony.com/doc/current/reference/constraints/Length.html#min