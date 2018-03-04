<?php

namespace Modules\Redirect\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Redirect\Entities\Redirect;
use Modules\Redirect\Repositories\RedirectRepository;
use Modules\Redirect\Repositories\ReportRepository;

class ReportController extends AdminBaseController
{
    /**
     * @var ReportRepository
     */
    private $report;
    /**
     * @var RedirectRepository
     */
    private $redirect;

    /**
     * ReportController constructor.
     * @param ReportRepository $report
     * @param RedirectRepository $redirect
     */
    public function __construct(ReportRepository $report, RedirectRepository $redirect)
    {
        parent::__construct();
        $this->report = $report;
        $this->redirect = $redirect;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        try {
            if ($request->ajax()) {
                $inputData = $request->all();
                if ($report = $this->report->find($inputData['pk'])) {
                    $url = parse_url($report->url);
                    if ($url['path'] == $inputData['value']) {
                        throw new \Exception(trans('Geçersiz URL ile aynı olamaz!'));
                    }
                    if ($redirect = $this->redirect->findByAttributes(['from' => $url['path']])) {
                        if (!isset($report->redirect->id)) {
                            $report->redirect()->associate($redirect);
                        }
                        if (empty($inputData['value'])) {
                            $report->redirect()->dissociate($redirect);
                            $redirect->delete();
                        } else {
                            $redirect->to = $inputData['value'];
                            $redirect->save();
                        }
                    } else {
                        $newRedirect = new Redirect([
                            'from'   => $url['path'],
                            'to'     => $inputData['value'],
                            'status' => 302
                        ]);
                        $newRedirect->save();
                        $report->redirect()->associate($newRedirect);
                    }
                    $report->save();
                    return response()->json([
                        'success'      => true,
                        'message'      => 'Yönlendirme işlemi başarıyla gerçekleştirildi.'
                    ]);
                }
            }
        }
        catch (\Exception $exception) {
            return response()->json([
                'success' => true,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'success'      => true,
            'message'      => 'Yönlendirme işlemi başarıyla gerçekleştirildi.'
        ]);
    }

    /**
     * @return mixed
     */
    public function clearReports()
    {
        try {
            $this->report->clearReports();
            return response()->json([
                'success'      => true,
                'message'      => 'Yönlendirme yapılmayan URL ler başarıyla temizlendi.'
            ]);
        }
        catch (\Exception $exception) {
            return response()->json([
                'success' => true,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Request $request)
    {
        try {
            if($report = $this->report->find($request->get('reportId'))) {
                $this->report->destroy($report);
            }
            return response()->json([
                'success'      => true,
                'message'      => 'Yönlendirme yapılmayan URL ler başarıyla temizlendi.'
            ]);
        }
        catch (\Exception $exception) {
            return response()->json([
                'success' => true,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
