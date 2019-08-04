<?php
require_once '../config/defined.php';
require_once CONFIG . '/config.php';
require_once '../vendor/autoload.php';
require_once CONFIG . '/routes.php';
require_once LIBS . '/functions.php';

use store\App;

new App;