@extends('layouts.app')

@push('title') Create Permissions @endpush

@push('breadCrumb')

   @component('components.breadCrumb',[
         'breadData' =>[
                  'Admin' => ['route' => null ,'icon' => 'fas fa-user-shield'],
                  'User Management' => ['route' => null ,'icon' => 'fas fa-user-lock'],
                  'Permission List' => ['route' => 'admin.access.permissions.index' ,'icon' => 'fas fa-key'],
                  'Create Permissions' => ['route' => 'admin.access.permissions.index' ,'icon' => 'fas fa-plus'],
                  ]
         ])
   @endcomponent

@endpush

@section('content')

@component('components.title', [
            'titleData' => [
                  'title' => 'Create Permission',
                  'buttonText' => 'Back',
                  'route' => 'admin.access.permissions.index',
                  'icon' => 'fas fa-arrow-left',
                  'class' => 'btn btn-primary btn-sm'
                  ]
         ])
          
      @endcomponent

{!! Form::open(['route' => ['admin.access.permissions.store'],'autocomplete' => 'off','files' => 'true']) !!}
    @include('admin.access.permissions._permission_form')
@stop

