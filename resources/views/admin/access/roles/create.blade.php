@extends('layouts.app')

@push('title') Create Role @endpush

@push('breadCrumb')

   @component('components.breadCrumb',[
         'breadData' =>[
                  'Admin' => ['route' => null ,'icon' => 'fas fa-user-shield'],
                  'User Management' => ['route' => null ,'icon' => 'fas fa-user-lock'],
                  'Role List' => ['route' => 'admin.access.users.index' ,'icon' => 'fas fa-user-shield'],
                  'Create Role' => ['route' => 'admin.access.users.index' ,'icon' => 'fas fa-plus'],
                  ]
         ])
   @endcomponent

@endpush

@section('content')

@component('components.title', [
            'titleData' => [
                  'title' => 'Create Role',
                  'buttonText' => 'Back',
                  'route' => 'admin.access.roles.index',
                  'icon' => 'fas fa-arrow-left',
                  'class' => 'btn btn-primary btn-sm'
                  ]
         ])
          
      @endcomponent

{!! Form::open(['route' => ['admin.access.roles.store'],'autocomplete' => 'off','files' => 'true']) !!}
    @include('admin.access.roles._role_form')
@stop

