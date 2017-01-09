# Middleland

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-scrutinizer]][link-scrutinizer]

Simple (but powerful) PSR-15 middleware dispatcher:

## Requirements

* PHP 7
* A [PSR-7 Message implementation](http://www.php-fig.org/psr/psr-7/), for example [zend-diactoros](https://github.com/zendframework/zend-diactoros)
* Optionally, a [container-interop](https://github.com/container-interop/container-interop) implementation to create the middleware components on demand.

## Example

```php
use Middleland\Dispatcher;

$middleware = [
	new Middleware1(),
	new Middleware2(),
	new Middleware3(),

	//You can nest middleware frames
	new Dispatcher([
		new Middleware4(),
		new Middleware5(),
	]),

	//Or use closures
	function ($request, $next) {
		$response = $next($request);
		return $response->withHeader('X-Foo', 'Bar');
	},

	//Or use a string to create the middleware on demand using container-interop
	'middleware6'

	//USE AN ARRAY TO ADD CONDITIONS:

	//This middleware is processed only in paths starting by "/admin"
	['/admin', new MiddlewareAdmin()],

	//and this is processed in DEV 
	[ENV === 'DEV', new MiddlewareAdmin()],

	//we can create more custom matchers
	[new RequestIsHttps(), new MiddlewareHttps()]

	//And use several for each middleware component
	[ENV === 'DEV', new RequestIsHttps(), new MiddlewareHttps()],
];

$dispatcher = new Dispatcher($middleware, new ContainerInterop());

$response = $dispatcher->dispatch(new Request());
```

## How to create matchers

Just use the `Middleland\Matchers\MatcherInterface`. Example:

```php
use Middleland\Matchers\MatcherInterface;
use Psr\Http\Message\ServerRequestInterface;

class IsAjax implements MatcherInterface
{
    public function match(ServerRequestInterface $request): bool
    {
    	return $request->getHeaderLine('X-Requested-With') === 'xmlhttprequest';
	}
}
```

---

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes.

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/oscarotero/middleland.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/middlewares/oscarotero/middleland.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/g/oscarotero/middleland.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/oscarotero/middleland
[link-travis]: https://travis-ci.org/oscarotero/middleland
[link-scrutinizer]: https://scrutinizer-ci.com/g/oscarotero/middleland
