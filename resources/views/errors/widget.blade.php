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

        .paginator a, .paginator a:visited {
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
                            <tr>
                                <td style="padding: 5px" class="centered">
                                    <b style="font-size: 12pt;">{!! trans("error.default") !!}</b>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </section>

</div>


</body>
</html>