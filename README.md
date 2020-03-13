# SingletonContainer

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

PSR-11 container decorator caching resolved instances.
This package is compliant with [PSR-1], [PSR-2], [PSR-4] and [PSR-11]. If you notice compliance oversights,
please send a patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
[PSR-11]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-11-container.md

## Install

Via Composer

``` bash
$ composer require yuca/singleton-container
```

## Usage

``` php
/** @var Psr\Container\ContainerInterface */
$resolvingContainer;
$singletonContainer = new Yuca\SingletonContainer\SingletonContainer($resolvingContainer);
// Resolves the instance using the injected container
$instance = $singletonContainer->get('Interface');
// Returns same instance
$sameInstance = $singletonContainer->get('Interface');
// Clear cached instance
$singletonContainer->clear('Interface');
// Clear all cached instances
$singletonContainer->clear();
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email hrcajuka@gmail.com instead of using the issue tracker.

## Credits

- [Hrvoje Jukic][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/yuca/singleton-container.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/yuca/singleton-container/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/yuca/singleton-container.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/yuca/singleton-container.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/yuca/singleton-container.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/yuca/singleton-container
[link-travis]: https://travis-ci.org/yuca/singleton-container
[link-scrutinizer]: https://scrutinizer-ci.com/g/yuca/singleton-container/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/yuca/singleton-container
[link-downloads]: https://packagist.org/packages/yuca/singleton-container
[link-author]: https://github.com/Firtzberg
[link-contributors]: ../../contributors
