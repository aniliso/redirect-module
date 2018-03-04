@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('redirect::reports.title.reports') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('redirect::reports.title.reports') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a id="clear-reports" href="#" class="btn btn-primary btn-flat" style="padding: 4px 10px; margin-right: 10px;">
                        <i class="fa fa-pencil"></i> Geçersiz URL'leri Temizle
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr><th>{{ trans('redirect::reports.form.ip') }}</th>
                            <th>{{ trans('redirect::reports.form.url') }}</th>
                            <th>{{ trans('redirect::redirects.form.to') }}</th>
                            <th>{{ trans('core::core.table.created at') }}</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                    </table>
                    <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('redirect::reports.title.create report') }}</dd>
    </dl>
@stop

@push('js-stack')
{!! Theme::style('vendor/sweetalert/dist/sweetalert.css') !!}
{!! Theme::script('vendor/sweetalert/dist/sweetalert.min.js') !!}
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.redirect.report.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
                }
            });
            var table = $('.data-table').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('admin.redirect.report.index') }}',
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                columns: [
                    {data: 'ip', name: 'ip'},
                    {data: 'url', name: 'url'},
                    {data: 'to', name:'to'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: true}
                ],
                stateSave: true,
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                },
                "drawCallback": function (settings, json) {
                    $('.editable').editable({
                        mode: 'inline',
                        container: 'body',
                        error: function(response) {
                            var data = jQuery.parseJSON(response.responseText);
                            swal("{{ trans('global.error') }}", data.message, "error");
                        },
                        success: function(response) {
                            swal("Başarılı", response.message, "success");
                        }
                    });
                    $('.jsDeleteItem').on('click', function (e) {
                        var self = $(this), reportId = self.data('item-id');
                        swal({
                                    title: "{{ trans('core::core.modal.confirmation-message') }}",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: '#DD6B55',
                                    confirmButtonText: '{{ trans('core::core.button.delete') }}',
                                    cancelButtonText: '{{ trans('core::core.button.cancel') }}',
                                    closeOnConfirm: true
                                },
                                function () {
                                    $.ajax({
                                        type : 'POST',
                                        url  : '{{ route('api.redirect.reports.destroy') }}',
                                        data : {
                                            reportId: reportId
                                        },
                                        success: function (response) {
                                            table.api().ajax.reload();
                                            swal("Başarılı", response.message, "success");
                                        },
                                        error: function (xhr, status, response) {
                                            var error = jQuery.parseJSON(xhr.responseText);
                                            var errorMessages = '';
                                            $.each(error.messages, function(key, value) {
                                                errorMessages += value+"\n";
                                            });
                                            swal("{{ trans('global.error') }}", errorMessages, "error");
                                        }
                                    })
                                });
                    });
                }
            });
            $('#clear-reports').on('click', function(){
               $.ajax({
                   method: "GET",
                   url   : "{{ route('api.redirect.reports.clear') }}"
               }).done(function(response){
                   table.api().ajax.reload();
                   swal("Başarılı", response.message, "success");
               });
            });
        });
    </script>
@endpush
