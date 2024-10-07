# Htain Thein Backend

## What can you check in here 

You can check following my skill in this project

1. Coding skill
2. Design architecture
3. my experiences


## Functions

The functions that already implemented are as  below.

-   CRUD
-   Firebase Chatting.
-   Monthly Expire Record Deleted Function with Laravel Command
-   Docker
-   Excel Download
-   Laravel Breeze
-   Sanctum
-   2FA login with Laravel Socialite
-   Mail Implementation
-   observer
-   Authorization and so on


## Policy

The codes need to satisfy the requirements down below.

-   All the APIs need feature tests
-   Tests for UseCases and Models are highly recommended but not required.
-   All the APIs need to be documented on Open API
-   All the codes have to pass static analysis tests of larastan and phpcs

## Development Flow

1. Write Open API documentation. ([stoplight](https://stoplight.io/) is recommended as GUI editor.)
2. Write Feature test.
3. Write actual logics.

## Static Analysis

### [IDE helper](https://github.com/barryvdh/laravel-ide-helper)

```
php artisan ide-helper:generate
php artisan ide-helper:models -RW
```

### [PHP Code Sniffer](https://laravel-news.com/php-codesniffer-with-laravel)

To run testing

```
./vendor/bin/phpcs --standard=phpcs.xml ./ -d memory_limit=1G
```

To fix problems automatically,

```
./vendor/bin/phpcbf --standard=phpcs.xml ./ -d memory_limit=1G
```

### [larastan](https://github.com/nunomaduro/larastan)

```
./vendor/bin/phpstan analyse --memory-limit=1G
```

## Testing

You can run `php artisan test` for testing.

-   Feature Test: Check if the api has correct request and response by using [spectator](https://github.com/hotmeteor/spectator)
-   UseCase Test: Check if the action (UseCase) works appropriately
-   Unit Test: Check if the function in Models works correctly

## Routing Assurer

To check if all the routings are documented, run

```
php artisan routing-assurer:openapi
```

To check if all the routings are tested, run

```
php artisan routing-assurer:testcase
```

To work queue need to run following command

```
php artisan queue:work

```
