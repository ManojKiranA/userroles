@extends('layouts.app')

@push('title') Edit Role @endpush

@push('breadCrumb')

   @component('components.breadCrumb',[
         'breadData' =>[
                  'Admin' => ['route' => null ,'icon' => 'fas fa-user-shield'],
                  'User Management' => ['route' => null ,'icon' => 'fas fa-user-lock'],
                  'Role List' => ['route' => 'admin.access.users.index' ,'icon' => 'fas fa-user-shield'],
                  'Edit Role' => ['route' => 'admin.access.users.index' ,'icon' => 'fas fa-pen'],
                  ]
         ])
   @endcomponent

@endpush

@section('content')

@component('components.title', [
            'titleData' => [
                  'title' => 'Edit Role -'.$role->name,
                  'buttonText' => 'Back',
                  'route' => 'admin.access.roles.index',
                  'icon' => 'fas fa-arrow-left',
                  'class' => 'btn btn-primary btn-sm'
                  ]
         ])
          
      @endcomponent

{!! Form::model($role, ['method' => 'PUT', 'route' => ['admin.access.roles.update',  $role ] ,'enctype'=>'multipart/form-data' ]) !!}
    @include('admin.access.roles._role_form')
@stop

