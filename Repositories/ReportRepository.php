<?php

namespace Modules\Redirect\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ReportRepository extends BaseRepository
{
    public function clearReports();
}
