@extends('layouts.app')

@inject('connfigObject','Illuminate\Support\Facades\Config')

@push('title') Permissions List @endpush

@push('breadCrumb')

   @component('components.breadCrumb',[
         'breadData' =>[
                  'Admin' => ['route' => null ,'icon' => 'fas fa-user-shield'],
                  'User Management' => ['route' => null ,'icon' => 'fas fa-user-lock'],
                  'Permission List' => ['route' => 'admin.access.permissions.index' ,'icon' => 'fas fa-key'],
                  ]
         ])
   @endcomponent

@endpush


@section('content')
<div class="card-box">
   <div class="card-block">
      @component('components.title', [
            'titleData' => [
                  'title' => 'Permissions List',
                  'buttonText' => 'Create Permisison',
                  'route' => 'admin.access.permissions.create',
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
                  <td>Description</td>
                  <td>Created At</td>
                  <td>Created By</td>
                  <td class="text-center">Actions</td>
               </tr>
            </thead>
            <tbody>
               @foreach($permissionList as $permissionKey => $permissionValue)
               <tr>
                  <td>@include('comman.serialnumber', ['serNo' => $permissionList])</td>
                  <td>{{ $permissionValue->name }}</td>
                  <td>{{ $permissionValue->description }}</td>
                  <td>{{ $permissionValue->created_at }}</td>
                  <td>{{ $permissionValue->created_by_name }}</td>
                  <td class="text-center">
                     @include('comman.gateactionbuttons', ['modelObject' => $permissionValue,'buttonsList' => ['EDIT' => 'permission_edit','DELETE' => 'permission_delete','SHOW' => 'permission_show']])
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
      <div class="text-center">
         {{ $permissionList->links() }}
      </div>
   </div>
</div>
@endsection
