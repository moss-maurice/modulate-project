<?php

use Modulatte\Bootstrap;

$modulePath = realpath(MODX_BASE_PATH . '/core/custom/packages/main/assets/modules/modulatte');

include_once realpath("{$modulePath}/bootstrap.php");

return Bootstrap::initModules();
