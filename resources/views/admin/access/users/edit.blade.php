@extends('layouts.app')

@push('title') Edit User @endpush

@push('breadCrumb')

   @component('components.breadCrumb',[
         'breadData' =>[
                  'Admin' => ['route' => null ,'icon' => 'fas fa-user-shield'],
                  'User Management' => ['route' => null ,'icon' => 'fas fa-user-lock'],
                  'User List' => ['route' => 'admin.access.users.index' ,'icon' => 'fas fa-users'],
                  'Edit User' => ['route' => 'admin.access.users.index' ,'icon' => 'fas fa-pen'],
                  ]
         ])
   @endcomponent

@endpush


@section('content')

@component('components.title', [
            'titleData' => [
                  'title' => 'Edit User -'.$user->name,
                  'buttonText' => 'Back',
                  'route' => 'admin.access.users.index',
                  'icon' => 'fas fa-arrow-left',
                  'class' => 'btn btn-primary btn-sm'
                  ]
         ])
          
      @endcomponent

{!! Form::model($user, ['method' => 'PUT', 'route' => ['admin.access.users.update',  $user ] ,'enctype'=>'multipart/form-data' ]) !!}
    @include('admin.access.users._user_form')
@stop

