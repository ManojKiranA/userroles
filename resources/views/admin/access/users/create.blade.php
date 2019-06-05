@extends('layouts.app')

@push('title') Create User @endpush

@section('content')

{!! Form::open(['route' => ['admin.access.users.store'],'autocomplete' => 'off','files' => 'true']) !!}
    @include('admin.access.users._user_form')
@stop

