@extends('master')

@section('title', 'New Log')

@section('content')

    <div class="apps-widgets">
        <section class="widget-wrapper">
            <header>
                <div>

                </div>
            </header>
            <div class="widget cf">
                <div class="content">
                    <table class="widget-table">
                        <tbody>
                        @if(count($logs) > 0)
                            @foreach($logs as $log)
                                <tr title="{!! $log->body !!}">
                                    <td class="left-column">{!! date('j. n. Y', strtotime($log->date)) !!}</td>
                                    <td class="right-column ellipsis">
                                        {!! $log->name !!}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="centered" style="zoom: 1.2">
                                    <b>{!! trans('log.no_logs') !!}</b>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                </div>
                <div>
                </div>
            </div>
        </section>
    </div>

@endsection