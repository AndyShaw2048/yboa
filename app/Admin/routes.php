<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('leave', LeaveController::class);
    $router->resource('applyrole', ApplyroleController::class);
    $router->resource('inventory', InventoryController::class);
    $router->resource('itemdetail', ItemDetailController::class);
    $router->resource('applyitem', ApplyItemController::class);
    $router->resource('applyitemdetail', ApplyItemDetailController::class);
    $router->resource('prizedoc', PrizeDocController::class);
    $router->resource('pp', PPController::class);
});
