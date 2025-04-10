# ServerClock package

[![Packagist](https://img.shields.io/packagist/v/your-vendor/package-name.svg)](https://packagist.org/packages/your-vendor/package-name)

Provide correct server time based on its external IP


## Table of Contents

- [Installation](#installation)
- [TestRun](#test-run)
- [Usage](#usage)
- [Structure](#structure)
- [Configuration](#configuration)


## Installation


### Composer Installation

To install the package, you can use Composer:

```bash
composer require vladyslav-dyba/server-clock
```

This will add the package to your composer.json file and download it into the vendor directory.
Manual Installation

In case you want to include it manually, you can also follow these steps:

     - Download the package files.
     - Include the Composer autoloader in your project:

```php
require 'vendor/autoload.php';
```


## Test run

Once you clone the package sepparetly, you can perform a test run to get local time based on an IP

To get local time for specific IP 

```bash
  php ./bin/console.php 8.8.8.8
  php ./vendor/vladyslav-dyba/server-clock/bin/console.php 8.8.8.8
```

To get local time for external server IP

```bash
  php ./bin/console.php
  php ./vendor/vladyslav-dyba/server-clock/bin/console.php
```

## Usage

Here, explain how to use your package with practical examples. Provide some basic functionality and advanced use cases.

To get a local time of the external server IP:

```php
// Include the Composer autoloader
require 'vendor/autoload.php';

// IpSource object provides an IP for the next steps
$ipSource = new ExternalIpSource(IpInfoDataProviderFactory::make());
    
// Source of time
// Current example works based on defined IP
// Though, a client of the library can use its own implementation for TimeSourceDataProviderInterface
$timeSource = new DefaultTimeSource(TimeApiDataProviderFactory::make($ipSource));

// ServerClock is the core of the library
// It provides time based on TimeSourceInterface
// As well, a client of the library can use its own implementation for TimeSourceInterface

$serverClock = new ServerClock($timeSource);
$time = $serverClock->now();

echo $time->format(DateTime::ATOM) . "\n";
```

To get a local time of the provided a specific IP:

```php
// Include the Composer autoloader
require 'vendor/autoload.php';

// Receiving a specific IP
$ip = $argv[1];

// IpSource object provides an IP for the next steps
$ipSource = new CustomIpSource($ip);
    
// Source of time
// Current example works based on defined IP
// Though, a client of the library can use its own implementation for TimeSourceDataProviderInterface
$timeSource = new DefaultTimeSource(TimeApiDataProviderFactory::make($ipSource));

// ServerClock is the core of the library
// It provides time based on TimeSourceInterface
// As well, a client of the library can use its own implementation for TimeSourceInterface

$serverClock = new ServerClock($timeSource);
$time = $serverClock->now();

echo $time->format(DateTime::ATOM) . "\n";
```


## Structure


### Core

The core of the package is `ServerClock` object that implements `TimeSourceInterface` interface


### TimeSource

`ServerClock` gets a time from a `$timeSource` that implements `TimeSourceInterface`

Package has only one basic implementation of the `TimeSourceInterface` - `DefaultTimeSource` 
and its TimeSourse DataProvider: [TimeApi](https://timeapi.io) service

Client can substitute the DataProvider with their own solution that implements the `TimeSourceInterface`


### IpSource

Since `TimeSource` works based on an IP information, `IpSourceInterface` implementation has to be provided.

Package has two basic implementation of the `IpSourceInterface`:

 - `CustomIpSource` - provides any specific IP address
 - `ExternalIpSource` - uses [IpInfo](https://ipinfo.io/) service as IpSource DataProvider to get and provide the external server IP


## Configuration

Regardless, the package has its own `TimeSourceInterface` and `IpSourceInterface` implementations,

there is no any configuration that can be applied for the package
because the package was created with minimum dependencies 
and its the primary approach to configure the package 
is substituting the interfaces implementations on a client side 
