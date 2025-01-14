@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1></h1>
@stop

@section('content')
    @livewire('admin.home-index')
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop