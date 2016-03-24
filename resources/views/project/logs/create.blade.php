@extends('master')

@section('title', 'New Log')

@section('header')
    @include('includes/header')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <form action="{!! action('ProjectLogsController@store', ['eshop_id' => $eshopId, 'project_id' => $project->id]) !!}"
                  method="POST">

                <input name="_token" type="hidden" value="{!! csrf_token() !!}">
                <input name="fromEshop" type="hidden" value="{!! $fromEshop !!}">

                <label for="date">{!! trans('log.date') !!}</label>
                <input name="date" type='text' id='datetimepicker1' style="max-width: 150px;"/>

                <label for="body">{!! trans('log.body') !!} <span style="color: grey">({!! trans('general.max_length') !!})</span></label>

                <textarea rows="5" maxlength="1000" name="body" id="body" class="materialize-textarea">{!! Request::old('body') !!}</textarea>

                <button class="button right" type="submit" name="action">
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
        $(function() {
            $('#datetimepicker1').datetimepicker({
                locale: "cs",
                @if(Request::old('date'))
                defaultDate: "{!! date_create_from_format(trans('time.format'), Request::old('date'))->format('Y-m-d H:i:s') !!}",
                @else
                defaultDate: new Date(),
                @endif

            });

        });
    </script>


@endsection