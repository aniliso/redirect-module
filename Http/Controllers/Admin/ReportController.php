<?php

namespace Modules\Redirect\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Redirect\Entities\Report;
use Modules\Redirect\Http\Requests\CreateReportRequest;
use Modules\Redirect\Http\Requests\UpdateReportRequest;
use Modules\Redirect\Repositories\ReportRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;
use Datatables;

class ReportController extends AdminBaseController
{
    /**
     * @var ReportRepository
     */
    private $report;

    public function __construct(ReportRepository $report, AssetPipeline $assetPipeline)
    {
        parent::__construct();
        $this->report = $report;
        $this->assetPipeline->requireJs('x-editable.js');
        $this->assetPipeline->requireCss('x-editable.css');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reports = Report::query();
        if(request()->ajax())
        {
            return Datatables::of($reports)
                ->addColumn('to', function ($report){
                    return '<a href="#" id="to" class="editable" data-type="text" data-pk="' . $report->id . '" data-url="'.route('api.redirect.reports.update').'" data-title="">' . @$report->redirect->to. '</a>';
                })
                ->addColumn('status', function($report){
                    return isset($report->redirect->status) ? $report->redirect->status : '';
                })
                ->addColumn('action', function($report){
                    $action_buttons =  \Html::decode(\Form::button(
                        '<i class="fa fa-trash"></i>',
                        ["data-item-id" => $report->id,
                         "class"=>"btn btn-danger btn-flat jsDeleteItem"]
                    ));
                    return $action_buttons;
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('redirect::admin.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('redirect::admin.reports.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateReportRequest $request
     * @return Response
     */
    public function store(CreateReportRequest $request)
    {
        $this->report->create($request->all());

        return redirect()->route('admin.redirect.report.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('redirect::reports.title.reports')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Report $report
     * @return Response
     */
    public function edit(Report $report)
    {
        return view('redirect::admin.reports.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Report $report
     * @param  UpdateReportRequest $request
     * @return Response
     */
    public function update(Report $report, UpdateReportRequest $request)
    {
        $this->report->update($report, $request->all());

        return redirect()->route('admin.redirect.report.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('redirect::reports.title.reports')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Report $report
     * @return Response
     */
    public function destroy(Report $report)
    {
        $this->report->destroy($report);

        return redirect()->route('admin.redirect.report.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('redirect::reports.title.reports')]));
    }
}