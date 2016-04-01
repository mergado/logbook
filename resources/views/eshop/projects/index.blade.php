@extends('master')

@section('title', 'Project Logs')

@section('header')
    @include('includes/header-eshop')
@endsection

@section('content')

    <div style="color: black;">
        <header class="main">

            <h1>{!! trans('eshop.list') !!}</h1>

        </header>

        @if(count($projects) < 1)
            <p>
                {!! trans('eshop.no_projects') !!}
            </p>

        @else
            @foreach($projects as $project)
                <header class="main" style="margin-bottom: 0px;">
                    <div class="faux-row spacing-half e-shop" style="display: inline">
                        <h2>
                            <a href="{!! action('ProjectLogsController@index',['eshop_id' => $eshop->id, 'project_id' => $project->id] ) !!}">{!! $project->name !!}</a>
                            <a href="{!! action('ProjectLogsController@export',['eshop_id' => $eshop->id, 'project_id' => $project->id] ) !!}"
                                class="icon-csv" style="margin-left: 5px;" data-download="href"></a>

                        </h2>
                        <a style="float: right;" class="button" href="{!! action('ProjectLogsController@create', [
            'eshop_id' => $eshop->id,
            'project_id' => $project->id, 'eshop' => true]) !!}">
                            {!! trans('log.new') !!}
                        </a>

                    </div>


                </header>

                @if (count($project->logs) > 0)

                <table class="datagrid element-list dotted fixed" style="margin-bottom: 40px;">
                    <thead>
                    <tr>
                        <th class="w10">{{trans('log.date')}}</th>
                        <th class="w60">{{trans('log.body')}}</th>
                        <th class="w20">{{trans('log.user')}}</th>
                        <th class="w10">{{trans('log.action')}}</th>
                    </tr>
                    </thead>

                    <tbody>


                    @foreach($project->logs as $log)
                        <tr>
                            <td>{!! date('j. n. Y', strtotime($log->date)) !!}</td>
                            <td title="{!! htmlentities($log->body) !!}" class="ellipsis">{!! htmlentities($log->body) !!}</td>
                            <td>{!! $log->name !!}</td>
                            <td>
                                <a href="{!! action('ProjectLogsController@edit', ['eshop_id' => $eshop->id, 'project_id' => $project->id, 'id' => $log->id, 'eshop' => true]) !!}" class="icon-edit">
                                    {!! trans('log.edit') !!}
                                </a>
                                <a href="{!! action('ProjectLogsController@deleteLink', ['eshop_id' => $eshop->id, 'projectId' => $project->id, 'id' => $log->id, 'eshop' => true]) !!}" class="icon-delete confirm" data-confirm-message="{!! trans('log.confirm_delete') !!}}}">
                                    {!! trans('log.delete') !!}
                                </a>
                            </td>
                        </tr>

                    @endforeach

                    </tbody>


                </table>

                @else
                    <br>
                    <hr>
                @endif

            @endforeach
        @endif

    </div>

@endsection