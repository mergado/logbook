<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>@yield('title')</title>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/bootstrap.css') !!}">

    <script src="{!! asset('js/jquery-2.1.3.min.js') !!}"></script>
    <script src="{!! asset('js/Iconizator.js') !!}"></script>

    <script type="text/javascript" src="{!! asset('js/date_picker/moment-min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/datetime-picker.js') !!}"></script>
    @if (App::environment('production'))
        <script src="https://app.mergado.com/static/js/apps/MessageApi.min.js"></script>
    @else
        <script src="http://dev.mergado.com/static/js/apps/MessageApi.min.js"></script>
    @endif

    <script type="text/javascript" src="{!! asset('js/autosize.js') !!}"></script>

    <style type="text/css">
        ::-webkit-scrollbar {
            display: none;
        }
        .paginator a,.paginator a:visited {
             color: #009ba9;
             text-decoration: none;
         }
    </style>

    <script>
        $(document).ready(function() {

            var iconizatorIcons = new Iconizator('{{ asset('/img/icons.png') }}');

            iconizatorIcons.iconize($('[class^="icon-"]')); // Common icon

            var textAreaCounter = function($txtArea) {
                var count = (1001 - $txtArea.val().length - $txtArea.val().split("\n").length);
                if(count < 0) count = 0;
                $("#counter").html(count);
            };

            var $textarea = $("textarea#body");

            $textarea.each(function(){
                autosize(this);
            }).on('autosize:resized', function(){
                Mergado.tellHeight();
            });

            textAreaCounter($textarea);

            $textarea.keyup(function(){
                textAreaCounter($textarea);
            });
        });
    </script>

</head>

<body>
<div class="document-style">
    <section id="content">
        @yield('header')

        @if (count($errors) > 0)
            <div style="text-align: center; color: red;">

                    @foreach ($errors->all() as $error)
                        <p class="red">{{ $error }}</p>
                    @endforeach

            </div>
        @endif


        @yield('content')
    </section>

</div>


</body>
</html>