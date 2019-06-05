@extends('layouts.app')

@push('title') Create Permissions @endpush

@section('content')

{!! Form::open(['route' => ['admin.access.permissions.store'],'autocomplete' => 'off','files' => 'true']) !!}
    @include('admin.access.permissions._permission_form')
@stop

