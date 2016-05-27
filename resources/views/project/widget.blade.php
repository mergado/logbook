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

    <style type="text/css">
        ::-webkit-scrollbar {
            display: none;
        }

        body {
            background-color: #faf6ea;
            margin-top: 0;
            font-family: Arial, Helvetica, Verdana, Sans-serif;
            font-size: 10pt;
        }

        .widget {
            display: block;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .widget-left, .widget-right {
            color: #333;
            float: left;
            padding-top: 5px;
            word-break: break-all;
        }

        .widget-right {
            width: 50%;
            text-align: right;
        }

        .widget-left {
            width: 50%;
            text-align: left;
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

        .center {
            text-align: center;
            margin-top: 10px;
        }
    </style>


</head>

<body>

<div class="widget">
    @if(count($logs) > 0)
        @foreach($logs as $log)
            <div title="{!! htmlentities($log->body) !!}">
                <div class="widget-left">
                    {!! date('j. n. Y', strtotime($log->date)) !!}
                </div>
                <div class="widget-right">
                    {!! $log->name !!}
                </div>
            </div>

        @endforeach
    @else
        <div class="center">
            <b>{!! trans('log.no') !!}</b>
            <br>
            <b>{!! trans('log.write_first') !!}</b>
        </div>
    @endif
</div>

</body>
</html>
