
<div class="cf">
    <section class="app-presenter logbook">
        <div>
            <header class="cf">
                <div class="app cf">
                    <div class="logo" style="background-color: #e6e885">
                        <a href="javascript:history.back()"><img src="{!! asset('logbook-logo-space.png') !!}" alt="Logbook"></a>
                    </div>
                    <div class="logotype spacing">
                        <h1>Logbook</h1>
                    </div>
                </div>
                @if (isset($eshop))
                <div class="info faux-table">
                    <div class="faux-row spacing-half e-shop">
                        <h2 style="font-size: 17pt;">
                            {!! $eshop->name !!}
                        </h2>
                        {{--<a href="{!! action('ProjectLogsController@export',['eshop_id' => $eshopId, 'project_id' => $project->id] ) !!}"--}}
                           {{--class="icon-csv" style="margin-left: 10px;"></a>--}}

                    </div>
                </div>
                @endif
            </header>

        </div>
    </section>
</div>
