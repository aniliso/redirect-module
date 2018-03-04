@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('redirect::redirects.title.create redirect') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.redirect.redirect.index') }}">{{ trans('redirect::redirects.title.redirects') }}</a></li>
        <li class="active">{{ trans('redirect::redirects.title.create redirect') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.redirect.redirect.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-10">
            <div class="box">
                <div class="box-body">
                    {!! Form::normalInput('from', trans('redirect::redirects.form.from'), $errors) !!}

                    {!! Form::normalInput('to', trans('redirect::redirects.form.to'), $errors) !!}
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                    <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.redirect.redirect.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box">
                <div class="box-body">
                    {!! Form::normalInput('status', trans('redirect::redirects.form.status'), $errors) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.redirect.redirect.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
@endpush
