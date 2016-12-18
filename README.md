# concrete5 DebugBar

A package to integrate [PHP Debug Bar](http://phpdebugbar.com/) with concrete5 CMS.

![Database Tab](https://raw.githubusercontent.com/hissy/concrete5-debugbar/master/screenshots/database.png)

## Usage

### Messages

Provides a way to log messages (compatible with [PSR-3 logger](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md)).

```php
\Core::make('debugbar/messages')->info('hello world');
\Core::make('debugbar/messages')->info($object);
```

![Messages Tab](https://raw.githubusercontent.com/hissy/concrete5-debugbar/master/screenshots/messages.png)

### TimeData

Provides a way to log total execution time as well as taking "measures" (ie. measure the execution time of a particular operation).

```php
\Core::make('debugbar/time')->startMeasure('longop', 'My long operation');
sleep(2);
\Core::make('debugbar/time')->stopMeasure('longop');
```

![Timeline Tab](https://raw.githubusercontent.com/hissy/concrete5-debugbar/master/screenshots/time.png)