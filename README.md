# simple-log
A simple log wrapper around syslog

<a href="https://codeclimate.com/github/makopov/simple-log"><img src="https://codeclimate.com/github/makopov/simple-log/badges/gpa.svg" /></a>

Simple log is a singleton class that makes logging to syslog very easy.

Get an object instance:

```php
$oLogger = SLog::getInstance();
```

Configure application name (optional). If not set syslog will show 'php' as the application name. Good to do upon a bootstrap or init of applications.

```php
$oLogger->setApplicationName('MyApp');
```

Now log!
Using any of the 8 log level

```php
$oLogger->emergency('some message');
$oLogger->alert('some message');
$oLogger->critical('some message');
$oLogger->error('some message');
$oLogger->warning('some message');
$oLogger->notice('some message');
$oLogger->info('some message');
$oLogger->debug('some message');
```

Log messages will appear in syslog (/var/log/message). By default Simple Log will include the file name and line number of where the log was made from.

For example:

Foo.php
```php
function foo() {
    $oLogger->warning('something happened');
}
```

Will show up in syslog like so:
> Feb 26 22:11:47 localhost MyApp: Foo.php:2 - something happened

Thats it. Please submit bugs as you see them. I will add tests in the near future.

