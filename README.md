# The Witcher Cards

## Setup

```
composer install
./bin/console app:project-init
```

## Run

```
symfony server:start

OR

./bin/console server:run
```

## Run front

```
yarn install
yarn watch
```

## Tests
```
./bin/phpunit tests/Controller/Api/CardControllerTest.php
./bin/phpunit tests/Controller/Api/DeckControllerTest.php
./bin/phpunit tests/Controller/Api/GameControllerTest.php
```