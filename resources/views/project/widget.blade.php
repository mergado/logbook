<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Widget</title>

    <!-- Compiled and minified CSS -->
    {{--<link rel="stylesheet" href="{!! asset('css/app.css') !!}">--}}
    {{--<link rel="stylesheet" href="{!! asset("css/simplegrid.css") !!}">--}}

    {{--<style type="text/css">--}}
        {{--::-webkit-scrollbar {--}}
            {{--display: none;--}}
        {{--}--}}

        {{--body {--}}
            {{--background-color: rgba(255,255,255,0.5);--}}
            {{--margin-top: 0;--}}
            {{--font-family: Arial, Helvetica, Verdana, Sans-serif;--}}
            {{--font-size: 10pt;--}}
        {{--}--}}

        {{--.grid {--}}
            {{--padding: 10px 10px;--}}
        {{--}--}}

        {{--div.center {--}}
            {{--text-align: center;--}}
        {{--}--}}
    {{--</style>--}}

    <style type="text/css">
        ::-webkit-scrollbar {
            display: none;
        }

        body {
            background-color: hsla(0, 0%, 100%, .5);
            margin-top: 0;
            font-family: Arial, Helvetica, Verdana, Sans-serif;
        }

        .widget {
            display: block;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .widget-left, .widget-right {
            height: 30px;
            text-align: center;
            color: #333;
            float: left;
        }

        .widget-right {
            padding-top: 5px;
            width: 60%;
        }

        .widget-left {
            width: 40%;
        }

        .widget-image {
            height: 100%;
            width: auto;
            float: left;
        }

        .widget-right b, .widget-right p {
            text-align: center;
        }

        .widget-right b {
            font-size: 25pt;
        }

        .widget-right p {
            font-size: 11pt;
            margin-top: 2px;
        }
    </style>


</head>

<body>

{{--<div class="main">--}}
    {{--<div class="grid">--}}
        {{--@if(count($logs) > 0)--}}
            {{--@foreach($logs as $log)--}}
                {{--<div class="col-6-12" title="{!! htmlentities($log->body) !!}">--}}
                    {{--{!! $log->name !!}--}}
                {{--</div>--}}
                {{--<div class="col-6-12" style="text-align: right">--}}
                    {{--{!! date('j. n. Y', strtotime($log->date)) !!}--}}
                {{--</div>--}}
            {{--@endforeach--}}
        {{--@else--}}
            {{--<div class="col-1-1 center">--}}
                {{--<b>{!! trans('log.no') !!}</b>--}}
            {{--</div>--}}
            {{--<div class="col-1-1 center">--}}
                {{--<b>{!! trans('log.write_first') !!}</b>--}}
            {{--</div>--}}
        {{--@endif--}}

    {{--</div>--}}
{{--</div>--}}

<div class="widget">
    @if(count($logs) > 0)
        @foreach($logs as $log)
            <div class="widget-left" title="{!! htmlentities($log->body) !!}">
                {!! $log->name !!}
            </div>
            <div class="widget-right">
                {!! date('j. n. Y', strtotime($log->date)) !!}
            </div>
        @endforeach
    @else
        <div class="widget-left">
        </div>
        <div class="widget-right">
            <b>Inactive</b>
            <p><span style="color: indianred">0</span> active templates</p>
        </div>
    @endif
</div>

</body>
</html>
