@extends('layouts.app')

@section('content')
{!! Form::model($user, ['method' => 'PUT', 'route' => ['admin.access.users.update',  $user ] ,'enctype'=>'multipart/form-data' ]) !!}
    @include('admin.access.users._user_form')
@stop
