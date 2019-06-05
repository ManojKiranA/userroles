@extends('layouts.app')

@push('title') Edit Permission @endpush

@section('content')
{!! Form::model($permission, ['method' => 'PUT', 'route' => ['admin.access.permissions.update',  $permission ] ,'enctype'=>'multipart/form-data' ]) !!}
    @include('admin.access.permissions._permission_form')
@stop

