### Test symfony login throttling


#### Test
```bash
docker-compose up
docker-compose exec php sh
/composer.phar install

bin/phpunit
```

#### Result
```
/var/www/app # bin/phpunit
PHPUnit 9.5.9 by Sebastian Bergmann and contributors.

Testing
F                                                                   1 / 1 (100%)

Time: 00:37.172, Memory: 40.00 MB

There was 1 failure:

1) App\Tests\LoginTest::testLoginThrottling
Attempts: 19; Spent: 25.384
Failed asserting that 200 is identical to 401.

/var/www/app/tests/LoginTest.php:53

FAILURES!
Tests: 1, Assertions: 49, Failures: 1.
```
