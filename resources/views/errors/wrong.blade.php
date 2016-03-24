@extends('master')

@section('title', 'Error')

@section('header')
    @include('includes/header-default')
@endsection

@section('content')

    <div class="container">
        <header class="main">
            <h2>{!! $message !!}</h2>
        </header>

    </div>


@endsection