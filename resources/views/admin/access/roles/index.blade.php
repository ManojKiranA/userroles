@extends('layouts.app')

@push('title') Roles List @endpush

@push('breadCrumb')

   @component('components.breadCrumb',[
         'breadData' =>[
                  'Admin' => ['route' => null ,'icon' => 'fas fa-user-shield'],
                  'User Management' => ['route' => null ,'icon' => 'fas fa-user-lock'],
                  'Role List' => ['route' => 'admin.access.users.index' ,'icon' => 'fas fa-users'],
                  ]
         ])
   @endcomponent

@endpush

@section('content')
<div class="card-box">
   <div class="card-block">
      @component('components.title', [
            'titleData' => [
                  'title' => 'Roles List',
                  'buttonText' => 'Create Role',
                  'route' => 'admin.access.roles.create',
                  'icon' => 'fas fa-plus',
                  'class' => 'btn btn-primary btn-sm'
                  ]
         ])
          
      @endcomponent
      <div class="table-responsive">
         <table class="table">
            <thead>
               <tr>
                  <td>#</td>
                  <td>Name</td>
                  <td>Desc</td>
                  <td>Created At</td>
                  <td>Created By</td>
                  @include('comman.gateactionheader',['permissionList' => ['role_edit','role_delete','role_show']])
               </tr>
            </thead>
            <tbody>
               @foreach($rolesList as $roleListKey =>  $roleListValue)
               <tr>
                  <td>@include('comman.serialnumber', ['serNo' => $rolesList])</td>
                  <td>{{ $roleListValue->name }}</td>
                  <td>{{ $roleListValue->description }}</td>
                  <td>{{ $roleListValue->created_at }}</td>
                  <td>{{ $roleListValue->created_by_name }}</td>
                  <td class="text-center">
                     @include('comman.buttons.actionbutton.gateaction', [
                        'modelObject' => $roleListValue,
                        'buttonsList' => [
                           'EDIT' =>   ['permission' => 'role_edit','route' => 'admin.access.roles.edit'],
                           'DELETE' => ['permission' => 'role_delete','route' => 'admin.access.roles.destroy'],
                           'SHOW' =>   ['permission' => 'role_show','route' => 'admin.access.roles.show'],
                           ]])
                  </td>
               </tr>
               @endforeach             
            </tbody>
         </table>
      </div>
      <div class="text-center">
         {{ $rolesList->links() }}
      </div>
   </div>
</div>
@endsection