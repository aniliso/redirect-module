<?php

namespace Modules\Redirect\Events\Handlers;

use Modules\Redirect\Events\NotFoundHttpEventHandler;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Redirect\Repositories\ReportRepository;

class NotFoundHttpExceptionEvent
{
    /**
     * @var ReportRepository
     */
    private $report;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ReportRepository $report)
    {
        $this->report = $report;
    }

    /**
     * Handle the event.
     *
     * @param \Modules\Redirect\Events\NotFoundHttpEventHandler $event
     * @return void
     */
    public function handle(\Modules\Redirect\Events\NotFoundHttpEventHandler $event)
    {
        if (!$this->report->findByAttributes(['url' => $event->getUrl()])) {
            $this->report->create([
                'url'         => $event->getUrl(),
                'ip'          => $event->getIp(),
                'status_code' => $event->getStatusCode()
            ]);
        }
    }
}
