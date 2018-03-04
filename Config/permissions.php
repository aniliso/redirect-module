<?php

return [
    'redirect.reports' => [
        'index' => 'redirect::reports.list resource',
        'create' => 'redirect::reports.create resource',
        'edit' => 'redirect::reports.edit resource',
        'destroy' => 'redirect::reports.destroy resource',
    ],
    'redirect.redirects' => [
        'index' => 'redirect::redirects.list resource',
        'create' => 'redirect::redirects.create resource',
        'edit' => 'redirect::redirects.edit resource',
        'destroy' => 'redirect::redirects.destroy resource',
    ],
    'api.redirect.reports'  => [
        'update'  => 'redirect::reports.api.update resource',
        'clear'   => 'redirect::reports.api.clear resource',
        'destroy' => 'redirect::reports.api.destroy resource'
    ],
    'api.redirect.redirects'  => [
        'update'  => 'redirect::redirects.api.update resource'
    ],
];
