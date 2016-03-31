@extends('master')

@section('title', 'Edit Log')

@section('header')
    @include('includes/header')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <form action="{!! action('ProjectLogsController@update', ['eshop_id' => $eshopId, 'projectId' => $project->id, 'id' => $log->id] ) !!}"
                  method="POST">

                <input name="_method" type="hidden" value="PUT">
                <input name="_token" type="hidden" value="{!! csrf_token() !!}">
                <input name="fromEshop" type="hidden" value="{!! $fromEshop !!}">

                <label for="date">{!! trans('log.date') !!}</label>
                <input name="date" type='text' id='datetimepicker1' style="max-width: 150px;"/>

                <label for="body">{!! trans('log.body') !!} <span style="color: grey">({!! trans('general.max_length') !!})</span></label>
                @if(Request::old('body'))
                    <textarea rows="5" maxlength="1000"  cols="80" name="body" id="body" class="materialize-textarea">{!! Request::old('body') !!}</textarea>
                @else
                    <textarea rows="5" maxlength="1000"  cols="80" name="body" id="body" class="materialize-textarea">{!! $log->body !!}</textarea>
                @endif
                <span style="float: right;">{!! trans('general.chars_left') !!}: <span id="counter">1000</span></span>

                <button class="button" type="submit" name="action">
                    {!! trans('log.submit') !!}
                </button>

                @if ($fromEshop)
                    <a href="{!! action('EshopLogsController@index', ['eshop_id' => $eshopId]) !!}"
                       class="button grey" style="margin-top: 30px;">
                @else
                    <a href="{!! action('ProjectLogsController@index', ['eshop_id' => $eshopId, 'project_id' => $project->id ]) !!}"
                       class="button grey" style="margin-top: 30px;">
                @endif
                    {!! trans('log.back') !!}
                    </a>

            </form>

        </div>
    </div>

    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                locale: "cs",
                @if(Request::old('date'))
                defaultDate: "{!! date_create_from_format(trans('time.format'), Request::old('date'))->format('Y-m-d H:i:s') !!}",
                @else
                defaultDate: '{!! $log->date !!}',
                @endif
                tooltips: {!! trans('time.tooltips') !!}
            });
        });
    </script>

@endsection