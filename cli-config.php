<?php
namespace Pleo\BSG;

require 'bootstrap.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$em = getEM();

return ConsoleRunner::createHelperSet($em);
