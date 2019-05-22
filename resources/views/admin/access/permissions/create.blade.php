@extends('layouts.app')

@section('content')

{!! Form::open(['route' => ['admin.access.permissions.store'],'autocomplete' => 'off','files' => 'true']) !!}
    @include('admin.access.permissions._permission_form')
@stop

