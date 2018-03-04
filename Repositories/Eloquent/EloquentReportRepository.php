<?php

namespace Modules\Redirect\Repositories\Eloquent;

use Modules\Redirect\Repositories\ReportRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentReportRepository extends EloquentBaseRepository implements ReportRepository
{
    public function clearReports()
    {
        return $this->model->whereNull('redirect_id')->delete();
    }
}
