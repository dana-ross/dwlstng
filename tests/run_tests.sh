#!/bin/bash
phpunit --configuration tests/phpunit.xml --coverage-clover=coverage.clover
wget https://scrutinizer-ci.com/ocular.phar
php ocular.phar code-coverage:upload --format=php-clover coverage.clover