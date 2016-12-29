# Prob/Framework
*A simple PHP framework*

[![Build Status](https://travis-ci.org/jongpak/prob-framework.svg?branch=master)](https://travis-ci.org/jongpak/prob-framework)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jongpak/prob-framework/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jongpak/prob-framework/?branch=master)
[![codecov](https://codecov.io/gh/jongpak/prob-framework/branch/master/graph/badge.svg)](https://codecov.io/gh/jongpak/prob-framework)

## Installation
### Copy sample configuration
```
$ cp .htaccess.example .htaccess
$ cp config/site.php.example config/site.php
$ cp config/db.php.example config/db.php
$ cp app/Auth/config/config.php.example app/Auth/config/config.php
$ cp app/Auth/config/accounts.php.example app/Auth/config/accounts.php
```

### Setting configuration for your environment
.htaccess
```
RewriteBase ** YOUR_WEB_SITE_URL_PATH (ex: / or /prob) **
```

config/site.php
```php
'url' => '/',
'publicPath' => '/public/',
```

config/db.php
```php
'host'      => 'localhost',
'port'      => 3306,
'user'      => 'username',
'password'  => 'password',
'dbname'    => 'dbname',
'charset'   => 'utf8'
```

app/Auth/config/config.php
```php
'defaultAllow' => true,
'defaultAccountManager' => 'FileBaseAccountManager',
'defaultLoginManager' => 'SessionLoginManager',
'defaultPermissionManager' => 'FileBasePermissionManager',
// ...
```

app/Auth/config/accounts.php
```php
return [
    // ...

    'test' => [
        'password' => 'test',
        'role' => [ 'Member' ]
    ],

    //*** Add YOUR ACCONUTS
];
```


### Making directories
```
$ mkdir data
```

### Dependency package update (use [Composer](https://getcomposer.org/))
```
$ composer update
```

### Creating table schema
```
$ php ./vendor/doctrine/orm/bin/doctrine.php orm:schema-tool:create
```

## Starting a web application (using PHP built-in server)
 ```
 $ php -S 127.0.0.1:8080 -t public/
 ```