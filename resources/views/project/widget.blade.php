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
                        @foreach($logs as $log)
                            <tr title="{!! $log->body !!}">
                                <td class="left-column">{!! date('j. n. Y', strtotime($log->date)) !!}</td>
                                <td class="right-column ellipsis">
                                    {!! $log->name !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                </div>
            </div>
        </section>
    </div>

@endsection