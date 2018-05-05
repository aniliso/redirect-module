<?php

namespace Modules\Redirect\Http\Middleware;

use Closure;
use DaveJamesMiller\Breadcrumbs\Exception;
use Illuminate\Http\Request;
use Modules\Redirect\Events\NotFoundHttpEventHandler;
use Modules\Redirect\Repositories\RedirectRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RedirectModuleMiddleware
{
    /**
     * @var RedirectRepository
     */
    private $redirect;

    public function __construct(RedirectRepository $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!str_contains($request->fullUrl(), '/api/')) {
            if($response->exception) {
                $className = new \ReflectionClass(get_class($response->exception));
                if($className->getShortName() == "NotFoundHttpException") {
                    event(new NotFoundHttpEventHandler($request->url(), $request->getClientIp(), $response->getStatusCode()));
                }
            }
            if($redirect = $this->redirect->findByAttributes(['from' => $request->getRequestUri()])) {
                return redirect($redirect->to, $redirect->status);
            }
        }

        return $response;
    }
}
