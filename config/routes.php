<?php

use store\Router;

Router::add('^category/(?<alias>\S+)$', ['controller' => 'category']);
Router::add('^product/(?<alias>\S+)$', ['controller' => 'product']);
Router::add('^(?<controller>[a-z0-9-_&]+)/?(?<action>[a-z0-9-_&]*)$');
Router::add('^$', ['controller' => 'index', 'action' => 'index']);
