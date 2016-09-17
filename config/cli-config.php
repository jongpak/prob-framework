<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Core\DatabaseManager;

DatabaseManager::setConfig(require 'db.php');
return ConsoleRunner::createHelperSet(DatabaseManager::getEntityManager());
