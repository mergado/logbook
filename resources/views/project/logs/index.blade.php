@extends('master')

@section('title', 'Project Logs')

@section('header')
    @include('includes/header')
@endsection

@section('content')

    <section>

        <a class="button control-button" href="{!! action('ProjectLogsController@create', [
            'eshop_id' => $eshopId,
            'project_id' => $project->id]) !!}">
            {!! trans('log.new') !!}
        </a>

        @if (count($logs) < 1)
            <h3 class="text-center">{!! trans('log.no_logs') !!}</h3>
        @else

        <table class="datagrid element-list dotted fixed">
            <thead>
            <tr>
                <th class="w10">{{trans('log.date')}}</th>
                <th class="w60">{{trans('log.body')}}</th>
                <th class="w20">{{trans('log.user')}}</th>
                <th class="w10">{{trans('log.action')}}</th>
            </tr>
            </thead>

            <tbody>


            @foreach($logs as $log)
            <tr>
                <td>{!! date('j. n. Y', strtotime($log->date)) !!}</td>
                <td title="{!! $log->body !!}" class="ellipsis">{!! $log->body !!}</td>
                <td>{!! $log->name !!}</td>
                <td>
                    <a href="{!! action('ProjectLogsController@edit', ['eshop_id' => $eshopId, 'project_id' => $project->id, 'id' => $log->id]) !!}" class="icon-edit">
                        {!! trans('log.edit') !!}
                    </a>
                    <a href="{!! action('ProjectLogsController@deleteLink', ['eshop_id' => $eshopId, 'projectId' => $project->id, 'id' => $log->id]) !!}" class="icon-delete confirm" data-confirm-message="{!! trans('log.confirm_delete') !!}}}">
                        {!! trans('log.delete') !!}
                    </a>
                </td>
            </tr>

            @endforeach

            </tbody>

        </table>

        @endif
        </section>

        @include('pagination.mergado', ['paginator' => $logs])



@endsection