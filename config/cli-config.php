<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Core\DatabaseManager;

DatabaseManager::getInstance()->setConfig(require 'db.php');
$entityManager = DatabaseManager::getInstance()->getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
