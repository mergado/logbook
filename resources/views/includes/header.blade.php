
    <div class="cf">
        <section class="app-presenter logbook">
            <div>
                <header class="cf">
                    <div class="app cf">
                        <div class="logo" style="background-color: #e6e885">
                            <a href="{!! $logoLink !!}"><img src="{!! asset('logbook-logo-space.png') !!}" alt="Repairman"></a>
                        </div>
                        <div class="logotype spacing">
                            <h1>Logbook</h1>
                        </div>
                    </div>
                    <div class="info faux-table">
                        <div class="faux-row spacing-half e-shop">
                            <h2 style="font-size: 17pt;">
                                {!! $project->name !!}
                            </h2>
                            <a href="{!! action('ProjectLogsController@export',['eshop_id' => $eshopId, 'project_id' => $project->id] ) !!}"
                               class="icon-csv" style="margin-left: 10px;" data-download="href"></a>

                        </div>

                        <h3 style="float: right;">
                            <a href="{!! action('EshopLogsController@index', ['eshop_id' => $eshopId]) !!}">{!! trans('eshop.list_all') !!}</a>
                        </h3>
                    </div>

                </header>

            </div>
        </section>
    </div>
