<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => 'redirect/reports', 'middleware' => 'api.token'], function (Router $router) {
    $router->post('update', [
        'as'         => 'api.redirect.reports.update',
        'uses'       => 'ReportController@update',
        'middleware' => 'token-can:api.redirect.reports.update',
    ]);
    $router->post('destroy', [
        'as'         => 'api.redirect.reports.destroy',
        'uses'       => 'ReportController@destroy',
        'middleware' => 'token-can:api.redirect.reports.destroy',
    ]);
    $router->get('clear-reports', [
        'as'         => 'api.redirect.reports.clear',
        'uses'       => 'ReportController@clearReports',
        'middleware' => 'token-can:api.redirect.reports.clear',
    ]);
});

/** @var Router $router */
$router->group(['prefix' => 'redirect/redirects', 'middleware' => 'api.token'], function (Router $router) {
    $router->post('update', [
        'as'         => 'api.redirect.redirects.update',
        'uses'       => 'RedirectController@update',
        'middleware' => 'token-can:api.redirect.reports.update',
    ]);
});