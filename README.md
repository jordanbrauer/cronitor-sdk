# cronitor-php

A small wrapper object for Cronitor.io cron job monitoring service.

## Downloading & Installing

#### Composer

```shell
$ composer require jordanbrauer/cronitor-php
```

## Setup

```php
require_once "vendor/autoload.php";

use \Cronitor\Monitor;
```

#### Minimal

```php
$cronitor = new Monitor("monitor_id");
```

#### Extended

```php
$cronitor = new Monitor("monitor_id", [
  "base_url" => "https://cronitor.link",
  "auth_key" => "your_private_secret_confidential_auth_key",
]);
```

## Usage

#### run()

> `run ([ string $message ])`

```php
$cronitor->run(); // plain run ping
$cronitor->run("Hello Cronitor!"); // run ping with message
```

#### complete()

> `complete ([ string $message ])`

```php
$cronitor->complete(); // plain complete ping
$cronitor->complete("Goodbye Cronitor!"); // complete ping with message
```

#### fail()

> `fail ([ string $message ])`

```php
$cronitor->fail(); // plain fail ping
$cronitor->fail("Damn Cronitor!"); // fail ping with message
```

#### pause()

> `pause (integer $duration)`

```php
$cronitor->pause(1); // pause for 1 hour
```

#### start()

> `start ()`

```php
$cronitor->start(); // resume monitoring
```
