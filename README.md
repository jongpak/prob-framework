# Prob/Framework
*A simple PHP framework*

[![Build Status](https://travis-ci.org/jongpak/prob-framework.svg?branch=master)](https://travis-ci.org/jongpak/prob-framework)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jongpak/prob-framework/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jongpak/prob-framework/?branch=master)
[![codecov](https://codecov.io/gh/jongpak/prob-framework/branch/master/graph/badge.svg)](https://codecov.io/gh/jongpak/prob-framework)

## Initial configuration setting
### Configure site
1. copy *config/site.php.example* to *config/site.php*
2. configure your website url on *config/site.php*

config/site.php
```php
<?php

return [
    'url' => '/',
    'publicPath' => '/public/',
];
```

### Configure database
1. copy *config/db.php.example* to *config/db.php*
2. configure your database on *config/db.php*

config/db.php
```php
<?php

//...
'connections' => [
    'mysql' => [
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'port'      => 3306,
        'user'      => 'username',
        'password'  => 'password',
        'dbname'    => 'dbname',
        'charset'   => 'utf8'
    ]
]
//...
```

## Database Initializing
```
> php .\vendor\doctrine\orm\bin\doctrine.php orm:schema-tool:create
```
