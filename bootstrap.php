<?php

use testModule\Module;

$config = include realpath(dirname(__FILE__) . '/config/module.php');

require_once realpath(dirname(__FILE__) . '/src/Module.php');

$module = new Module($config);
