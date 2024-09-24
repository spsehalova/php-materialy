<?php

use App\Controllers\SiteController;
use App\Controllers\SiteHtmlController;
use App\Router;

require_once 'vendor/autoload.php';
require_once 'app/functions.php';

$router = new Router();

$router->get('/', function () {
    require 'views/index.php';
});

$router->get('/sites/{site}', fn() => (new SiteHtmlController())->show(...func_get_args()));

$router->get('/api/sites', fn() => (new SiteController)->index(), true);
$router->get('api/sites/{site}', fn() => (new SiteController)->show(...func_get_args()), true);

$router->resolve();