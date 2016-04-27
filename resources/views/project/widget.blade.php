<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Widget</title>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}">

    <style type="text/css">
        ::-webkit-scrollbar {
            display: none;
        }
        .paginator a,.paginator a:visited {
            color: #009ba9;
            text-decoration: none;
        }
    </style>

</head>

<body>
<div class="document-style">
    <section id="content">
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
                                    <tr title="{!! htmlentities($log->body) !!}">
                                        <td class="left-column">{!! date('j. n. Y', strtotime($log->date)) !!}</td>
                                        <td class="right-column ellipsis">
                                            {!! $log->name !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="centered">
                                        <b>{!! trans('log.no') !!}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="centered" style="padding-top: 10px;">
                                        <b>{!! trans('log.write_first') !!}</b>
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
    </section>

</div>

</body>
</html>
