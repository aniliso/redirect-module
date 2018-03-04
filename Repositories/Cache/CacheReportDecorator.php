<?php

namespace Modules\Redirect\Repositories\Cache;

use Modules\Redirect\Repositories\ReportRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheReportDecorator extends BaseCacheDecorator implements ReportRepository
{
    public function __construct(ReportRepository $report)
    {
        parent::__construct();
        $this->entityName = 'redirect.reports';
        $this->repository = $report;
    }

    public function clearReports()
    {
        return $this->cache->tags($this->entityName)->flush();
    }
}
