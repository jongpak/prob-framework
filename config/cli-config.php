<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Core\Framework;

$framework = Framework::getInstance();
$framework->setSiteConfig(require 'site.php');
$framework->setDbConfig(require 'db.php');

$entityManager = Framework::getInstance()->getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
