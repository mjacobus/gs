# PHP Micro Framework

For a very specific purpose

[![Build Status](https://travis-ci.org/mjacobus/gs.png?branch=master)](https://travis-ci.org/mjacobus/php-objects)
[![Coverage Status](https://coveralls.io/repos/mjacobus/gs/badge.png)](https://coveralls.io/r/mjacobus/php-objects)
[![Code Climate](https://codeclimate.com/github/mjacobus/gs.png)](https://codeclimate.com/github/mjacobus/gs)
[![Latest Stable Version](https://poser.pugx.org/gs/di/v/stable.svg)](https://packagist.org/packages/gs/di)
[![Total Downloads](https://poser.pugx.org/gs/di/downloads.svg)](https://packagist.org/packages/gs/di)
[![Latest Unstable Version](https://poser.pugx.org/gs/di/v/unstable.svg)](https://packagist.org/packages/gs/di)
[![License](https://poser.pugx.org/gs/di/license.svg)](https://packagist.org/packages/gs/di)

Includes:

- QueryBuilder
- View Renderer
- Simple Action controller

## Issues/Features proposals

[Here](https://github.com/mjacobus/gs/issues) is the issue tracker.

## Contributing

Only TDD code will be accepted. Please follow the [PSR-2 code standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md).

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request

### How to run the tests:

```bash
phpunit --configuration tests/phpunit.xml
```

### To check the code standard run:

```bash
phpcs --standard=Zend lib
phpcs --standard=Zend tests

# alternatively

./bin/travis/run_phpcs.sh
```

## Lincense
[MIT](MIT-LICENSE)

## Authors

- [Marcelo Jacobus](https://github.com/mjacobus)

