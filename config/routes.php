<?php

use store\Router;

Router::add('^admin/(?<controller>[a-z0-9-_&]+)/?(?<action>[a-z0-9-_&]*)$', ['prefix' => 'admin']);
Router::add('^admin$', ['controller' => 'index', 'action' => 'index', 'prefix' => 'admin']);
Router::add('^comparison/(?<key>[0-9]+)$', ['controller' => 'comparison', 'action' => 'comparison']);
Router::add('^profile/comment/(?<id>\d+)$', ['controller' => 'profile', 'action' => 'comments']);
Router::add('^login/service/(?<alias>\S+)$', ['controller' => 'login', 'action' => 'service']);
Router::add('^category/(?<alias>\S+)$', ['controller' => 'category', 'action' => 'index']);
Router::add('^product/comments/(?<alias>\S+)$', ['controller' => 'product', 'action' => 'comments']);
Router::add('^product/(?<alias>\S+)$', ['controller' => 'product', 'action' => 'index']);
Router::add('^(?<controller>[a-z0-9-_&]+)/?(?<action>[a-z0-9-_&]*)$');
Router::add('^$', ['controller' => 'index', 'action' => 'index']);
