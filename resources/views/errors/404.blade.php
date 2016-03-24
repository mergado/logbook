@extends('master')

@section('title', 'Error page')

@section('header')
    @include('includes/header-default')
@endsection

@section('content')
    <div class="container">
        <header class="main">
                <h2>{!! trans('error.not-found') !!}</h2>
        </header>

    </div>

@endsection
