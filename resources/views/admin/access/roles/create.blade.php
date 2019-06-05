@extends('layouts.app')

@push('title') Create Role @endpush

@section('content')

{!! Form::open(['route' => ['admin.access.roles.store'],'autocomplete' => 'off','files' => 'true']) !!}
    @include('admin.access.roles._role_form')
@stop

