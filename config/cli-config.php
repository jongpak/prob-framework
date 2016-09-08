<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Core\Application;

$app = Application::getInstance();
$app->setSiteConfig(require 'site.php');
$app->setDbConfig(require 'db.php');

$entityManager = Application::getInstance()->getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
