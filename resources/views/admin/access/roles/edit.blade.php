@extends('layouts.app')

@section('content')
{!! Form::model($role, ['method' => 'PUT', 'route' => ['admin.access.roles.update',  $role ] ,'enctype'=>'multipart/form-data' ]) !!}
    @include('admin.access.roles._role_form')
@stop

