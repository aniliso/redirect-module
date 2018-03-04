<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/redirect'], function (Router $router) {
    $router->bind('redirectReport', function ($id) {
        return app('Modules\Redirect\Repositories\ReportRepository')->find($id);
    });
    $router->get('reports', [
        'as' => 'admin.redirect.report.index',
        'uses' => 'ReportController@index',
        'middleware' => 'can:redirect.reports.index'
    ]);
    $router->get('reports/create', [
        'as' => 'admin.redirect.report.create',
        'uses' => 'ReportController@create',
        'middleware' => 'can:redirect.reports.create'
    ]);
    $router->post('reports', [
        'as' => 'admin.redirect.report.store',
        'uses' => 'ReportController@store',
        'middleware' => 'can:redirect.reports.create'
    ]);
    $router->get('reports/{redirectReport}/edit', [
        'as' => 'admin.redirect.report.edit',
        'uses' => 'ReportController@edit',
        'middleware' => 'can:redirect.reports.edit'
    ]);
    $router->put('reports/{redirectReport}', [
        'as' => 'admin.redirect.report.update',
        'uses' => 'ReportController@update',
        'middleware' => 'can:redirect.reports.edit'
    ]);
    $router->delete('reports/{redirectReport}', [
        'as' => 'admin.redirect.report.destroy',
        'uses' => 'ReportController@destroy',
        'middleware' => 'can:redirect.reports.destroy'
    ]);
    $router->bind('redirectRedirect', function ($id) {
        return app('Modules\Redirect\Repositories\RedirectRepository')->find($id);
    });
    $router->get('redirects', [
        'as' => 'admin.redirect.redirect.index',
        'uses' => 'RedirectController@index',
        'middleware' => 'can:redirect.redirects.index'
    ]);
    $router->get('redirects/create', [
        'as' => 'admin.redirect.redirect.create',
        'uses' => 'RedirectController@create',
        'middleware' => 'can:redirect.redirects.create'
    ]);
    $router->post('redirects', [
        'as' => 'admin.redirect.redirect.store',
        'uses' => 'RedirectController@store',
        'middleware' => 'can:redirect.redirects.create'
    ]);
    $router->get('redirects/{redirectRedirect}/edit', [
        'as' => 'admin.redirect.redirect.edit',
        'uses' => 'RedirectController@edit',
        'middleware' => 'can:redirect.redirects.edit'
    ]);
    $router->put('redirects/{redirectRedirect}', [
        'as' => 'admin.redirect.redirect.update',
        'uses' => 'RedirectController@update',
        'middleware' => 'can:redirect.redirects.edit'
    ]);
    $router->delete('redirects/{redirectRedirect}', [
        'as' => 'admin.redirect.redirect.destroy',
        'uses' => 'RedirectController@destroy',
        'middleware' => 'can:redirect.redirects.destroy'
    ]);
// append


});
