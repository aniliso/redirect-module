<?php namespace Modules\Redirect\Composers;


use Illuminate\Contracts\View\View;

class RedirectStatusComposer
{
    public function compose(View $view)
    {
        $statuses = [
            301 => trans('redirect::redirects.status.Moved Permanently'),
            302 => trans('redirect::redirects.status.Found'),
            307 => trans('redirect::redirects.status.Temporary Redirect'),
            308 => trans('redirect::redirects.status.Permanent Redirect'),
        ];
        $view->with('redirectStatuses', $statuses);
    }
}