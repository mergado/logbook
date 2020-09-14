@extends('master')

@section('title', 'Log')

@section('header')
    {{--@include('includes/header')--}}
@endsection

@section('content')

    <div class="cf">
        <section class="app-presenter logbook">
            <div>
                <header class="cf">
                    <div class="app cf">
                        <div class="logo" style="background-color: #e6e885">
                            <img src="{!! asset('logbook-logo-space.png') !!}" alt="Repairman">
                        </div>
                        <div class="logotype spacing">
                            <h1>Logbook</h1>
                        </div>
                    </div>
                    <div class="info faux-table">
                        <div class="faux-row spacing-half e-shop">
                            <h2>1Dplakaty.cz</h2>
                        </div>
                    </div>
                </header>

            </div>
        </section>
    </div>

    <script>
        console.log(document.cookie);
        console.log(window.parent.getElementById('bla'));
    </script>

@endsection