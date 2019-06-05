@extends('layouts.app')

@push('title') Create User @endpush

@push('breadCrumb')

   @component('components.breadCrumb',[
         'breadData' =>[
                  'Admin' => ['route' => null ,'icon' => 'fas fa-user-shield'],
                  'User Management' => ['route' => null ,'icon' => 'fas fa-user-lock'],
                  'User List' => ['route' => 'admin.access.users.index' ,'icon' => 'fas fa-users'],
                  'Create User' => ['route' => 'admin.access.users.index' ,'icon' => 'fas fa-plus'],
                  ]
         ])
   @endcomponent

@endpush


@section('content')

@component('components.title', [
            'titleData' => [
                  'title' => 'Create New User',
                  'buttonText' => 'Back',
                  'route' => 'admin.access.users.index',
                  'icon' => 'fas fa-arrow-left',
                  'class' => 'btn btn-primary btn-sm'
                  ]
         ])
          
      @endcomponent

{!! Form::open(['route' => ['admin.access.users.store'],'autocomplete' => 'off','files' => 'true']) !!}
    @include('admin.access.users._user_form')
@stop

