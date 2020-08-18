<?php

require_once 'bootstrap/app.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
return ConsoleRunner::createHelperSet(app()->get('orm')->getEntityManager());
