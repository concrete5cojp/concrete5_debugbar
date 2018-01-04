# concrete5 DebugBar

A package to integrate [PHP Debug Bar](http://phpdebugbar.com/) with concrete5 CMS.

## Installation

### Install the debug bar to the site that managed using composer

If you are managing your concrete5 site using [concrete5/composer](https://github.com/concrete5/composer), you can manage this package with composer too.

#### 1. Modify your composer.json file

Add these packages to `"require"` section:

```
"concrete5cojp/concrete5_debugbar": "~0.2",
"slowprog/composer-copy-file": "~0.2"
```

Add these lines to `"extra"` section:

```
"copy-file": {
  "vendor/maximebf/debugbar/src/DebugBar/Resources/": "public/packages/concrete5_debugbar/vendor/maximebf/debugbar/src/DebugBar/Resources/"
}
```

Add `"scripts"` section:

```
"scripts": {
  "post-install-cmd": [
    "SlowProg\\CopyFile\\ScriptHandler::copy"
  ],
  "post-update-cmd": [
    "SlowProg\\CopyFile\\ScriptHandler::copy"
  ]
}
```

When you are managing your concrete5 site using composer, the `vendor` directory is outside from the document root.
However, the `debugbar` package has some css/js/images in the `vendor` directory, so you have to move these static files.
That's why we need to add the `composer-copy-file` package and the scripts section.
You are also able to move `Resources` directory manually.

Entire composer.json example:

```json
{
  "name": "concrete5/composer",
  "description": "A fully featured skeleton for a composer managed concrete5 site",
  "type": "project",
  "license": "MIT",
  "prefer-stable": true,
  "autoload": {
    "psr-4": {
      "ConcreteComposer\\" : "./src"
    }
  },
  "require": {
    "composer/installers": "^1.3",
    "concrete5/core": "^8.3",
    "vlucas/phpdotenv": "^2.4",
    "concrete5cojp/concrete5_debugbar": "dev-master",
    "slowprog/composer-copy-file": "~0.2"
  },
  "config": {
    "preferred-install": "dist"
  },
  "extra": {
    "branch-alias": {
      "dev-8.x": "8.x-dev"
    },
    "installer-paths": {
      "public/concrete": ["type:concrete5-core"],
      "public/application/themes/{$name}": ["type:concrete5-theme"],
      "public/packages/{$name}": ["type:concrete5-package"],
      "public/application/blocks/{$name}": ["type:concrete5-block"]
    },
    "copy-file": {
      "vendor/maximebf/debugbar/src/DebugBar/Resources/": "public/packages/concrete5_debugbar/vendor/maximebf/debugbar/src/DebugBar/Resources/"
    }
  },
  "scripts": {
    "post-install-cmd": [
      "SlowProg\\CopyFile\\ScriptHandler::copy"
    ],
    "post-update-cmd": [
      "SlowProg\\CopyFile\\ScriptHandler::copy"
    ]
  }
}
```

#### 2. Download the package

```bash
$ composer update
```

#### 3. Install the package

```bash
$ ./public/concrete/bin/concrete5 c5:package-install concrete5_debugbar
```

### Install the debug bar to the site that managed *without* using composer

```bash
$ cd ./packages
$ git clone git@github.com:concrete5cojp/concrete5_debugbar.git
$ cd concrete5_debugbar
$ composer install
$ cd ../../
$ ./concrete/bin/concrete5 c5:package-install concrete5_debugbar
```

## Usage

### Messages

You can add messages to this tab using compatible usage with [PSR-3 logger](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md).

```php
\Core::make('debugbar/messages')->info('hello world');
\Core::make('debugbar/messages')->info($object);
```

![Messages Tab](https://raw.githubusercontent.com/hissy/concrete5-debugbar/master/screenshots/messages.png)

### Timeline

Provides a way to log total execution time as well as taking "measures" (ie. measure the execution time of a particular operation).

```php
\Core::make('debugbar/time')->startMeasure('longop', 'My long operation');
sleep(2);
\Core::make('debugbar/time')->stopMeasure('longop');
```

![Timeline Tab](https://raw.githubusercontent.com/hissy/concrete5-debugbar/master/screenshots/time.png)

### Request

You can check how concrete5 retreive request data in this tab.

![Request Tab](https://raw.githubusercontent.com/hissy/concrete5-debugbar/master/screenshots/request.png)

### Database

You can check all sql queries on current request in this tab.

![Database Tab](https://raw.githubusercontent.com/hissy/concrete5-debugbar/master/screenshots/database.png)

### Logs

You can check application logs (same as dashboard/reports/logs but you can quick access!).

![Logs Tab](https://raw.githubusercontent.com/hissy/concrete5-debugbar/master/screenshots/logs.png)
