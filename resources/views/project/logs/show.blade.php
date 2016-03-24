@extends('master')

@section('title', 'Log')

@section('header')
    {{--@include('includes/header')--}}
@endsection

@section('content')

    {{--@include('project.breadcrumbs', ['project' => $project])--}}

    {{--<div class="container">--}}
        {{--<div class="row">--}}

            {{--<div class="valign-wrapper col s6">--}}
                {{--<i class="material-icons">today</i>--}}

                {{--<p class="valign">--}}
                    {{--{!! date_create_from_format('Y-m-d H:i:s', $log->date)->format('d.m.Y') !!}--}}
                {{--</p>--}}
            {{--</div>--}}
            {{--<h5 class="col s6">--}}
                {{--{!! $user->name !!}--}}
            {{--</h5>--}}

            {{--<div>--}}
                {{--<h6 class="col s12">--}}
                    {{--{!! trans('log.body') !!}:--}}
                {{--</h6>--}}

                {{--<div class="col s12">--}}
                    {{--<div class="card-panel white">--}}
                    {{--<span>{!! $log->body !!}</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}
    {{--</div>--}}

    {{--@if($user->id == session('oauth')->getResourceOwnerId())--}}
    {{--<div class="fixed-action-btn horizontal" style="bottom: 45px; right: 24px;">--}}
        {{--<a class="btn-floating btn-large green"--}}
           {{--href="{!! action('ProjectLogsController@edit', ['eshop_id' => $eshopId, 'projectId' => $project->id, 'id' => $log->id]) !!}">--}}
            {{--<i class="large material-icons">mode_edit</i>--}}
        {{--</a>--}}
        {{--<ul>--}}
            {{--<li>--}}
                {{--<form action="{!! action('ProjectLogsController@destroy', ['projectId' => $project->id, 'id' => $log->id]) !!}" method="POST">--}}

                    {{--<input name="_method" type="hidden" value="DELETE">--}}
                    {{--<input name="_token" type="hidden" value="{!! csrf_token() !!}">--}}

                    {{--<button class="btn-flat" type="submit" style="color: red;">--}}
                        {{--<i class="material-icons right">delete_sweep</i></label>--}}
                    {{--</button>--}}

                {{--</form>--}}
                {{--<a class="btn-floating red"><i class="material-icons">insert_chart</i></a>--}}
            {{--</li>--}}
        {{--</ul>--}}
    {{--</div>--}}
    {{--@endif--}}

    <div class="cf">
        <section class="app-presenter logbook">
            <div>
                <header class="cf">
                    <div class="app cf">
                        <div class="logo" style="background-color: #e6e885">
                            <img src="{!! asset('logbook-logo-space.png') !!}" alt="Repairman">
                        </div>
                        <div class="logotype spacing">
                            <h1>Logbook</h1>
                        </div>
                    </div>
                    <div class="info faux-table">
                        <div class="faux-row spacing-half e-shop">
                            <h2>1Dplakaty.cz</h2>
                        </div>
                    </div>
                </header>

            </div>
        </section>
    </div>

    <script>
        console.log(document.cookie);
        console.log(window.parent.getElementById('bla'));
    </script>

@endsection