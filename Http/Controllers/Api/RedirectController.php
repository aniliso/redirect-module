<?php

namespace Modules\Redirect\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class RedirectController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }
}
