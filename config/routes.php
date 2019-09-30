<?php

use store\Router;

Router::add('^login/service/(?<alias>\S+)$', ['controller' => 'login', 'action' => 'service']);
Router::add('^category/(?<alias>\S+)$', ['controller' => 'category', 'action' => 'index']);
Router::add('^product/(?<alias>\S+)$', ['controller' => 'product', 'action' => 'index']);
Router::add('^(?<controller>[a-z0-9-_&]+)/?(?<action>[a-z0-9-_&]*)$');
Router::add('^$', ['controller' => 'index', 'action' => 'index']);
