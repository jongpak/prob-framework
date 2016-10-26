# Prob/Framework
*A simple PHP framework*

[![Build Status](https://travis-ci.org/jongpak/prob-framework.svg?branch=master)](https://travis-ci.org/jongpak/prob-framework)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jongpak/prob-framework/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jongpak/prob-framework/?branch=master)
[![codecov](https://codecov.io/gh/jongpak/prob-framework/branch/master/graph/badge.svg)](https://codecov.io/gh/jongpak/prob-framework)

## Installation
### Copy sample configuration
```
> cp .htaccess.example .htaccess
> cp config/site.php.example config/site.php
> cp config/db.php config/db.php
> cp app/Auth/config/accounts.php.example app/Auth/config/accounts.php
```

### Setting configuration for your environment
.htaccess
```
RewriteBase ** YOUR_WEB_SITE_URL **
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

accounts.php
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
> mkdir data/attachment
```


### Dependency package update (use Composer)
```
> ./composer.phar update
```

### Creating table schema
```
> php .\vendor\doctrine\orm\bin\doctrine.php orm:schema-tool:create
```
