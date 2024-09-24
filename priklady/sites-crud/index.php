<?php

use App\Controllers\SiteController;
use App\Router;

require_once 'vendor/autoload.php';

$router = new Router();

$router->get('/', function () {
    require 'views/index.php';
});

$router->get('/api/sites', fn() => (new SiteController)->index(), true);
$router->get('api/sites/{site}', fn() => (new SiteController)->show(...func_get_args()), true);

$router->resolve();