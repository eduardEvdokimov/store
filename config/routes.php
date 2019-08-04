<?php

use store\Router;

Router::add('^(?<controller>[a-z0-9-]+)/?(?<action>[a-z0-9-]*)$');
Router::add('^$', ['controller' => 'index', 'action' => 'index']);
