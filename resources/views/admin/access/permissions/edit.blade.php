@extends('layouts.app')

@push('title') Edit Permission @endpush

@push('breadCrumb')

   @component('components.breadCrumb',[
         'breadData' =>[
                  'Admin' => ['route' => null ,'icon' => 'fas fa-user-shield'],
                  'User Management' => ['route' => null ,'icon' => 'fas fa-user-lock'],
                  'Permission List' => ['route' => 'admin.access.permissions.index' ,'icon' => 'fas fa-key'],
                  'Edit Permission' => ['icon' => 'fas fa-pen'],
                  ]
         ])
   @endcomponent

@endpush

@section('content')

@component('components.title', [
            'titleData' => [
                  'title' => 'Edit Permission '.'<code>'.$permission->name.'</code>',
                  'buttonText' => 'Back',
                  'route' => 'admin.access.permissions.index',
                  'icon' => 'fas fa-arrow-left',
                  'class' => 'btn btn-primary btn-sm'
                  ]
         ])
          
      @endcomponent

{!! Form::model($permission, ['method' => 'PUT', 'route' => ['admin.access.permissions.update',  $permission ] ,'enctype'=>'multipart/form-data' ]) !!}
    @include('admin.access.permissions._permission_form')
@stop

