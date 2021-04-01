# The Witcher Cards

## Setup

```
composer install
./bin/console doctrine:database:create
./bin/console doctrine:migrations:migrate
```

## Run

```
symfony server:start

OR

./bin/console server:run
```

## Tests
```
./bin/phpunit
```