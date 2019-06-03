@extends('layouts.app')
@push('title') Roles List @endpush
@section('content')
<div class="card-box">
   <div class="card-block">
      <div class="row">
         <div class="col-md-5">
            <h4 class="card-title">Roles</h4>
         </div>
         <div class="col-md-7 page-action text-right">
            <a href="{{ route('admin.access.roles.create') }}" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-plus-sign"></i> Create Roles</a>
         </div>
      </div>
      <div class="table-responsive">
         <table class="table">
            <thead>
               <tr>
                  <td>#</td>
                  <td>Name</td>
                  <td>Desc</td>
                  <td>Permisisons</td>
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
                  <td>
                     @foreach($roleListValue->permissions->pluck('name') as $permisison)
                        <span class="badge badge-info">{{ $permisison }}</span>
                     @endforeach
                  </td>
                  <td>{{ $roleListValue->created_at }}</td>
                  <td>{{ $roleListValue->created_by_name }}</td>
                  <td class="text-center">
                     @include('comman.gateactionbuttons', ['modelObject' => $roleListValue,'buttonsList' => ['EDIT' => 'role_edit','DELETE' => 'role_delete','SHOW' => 'role_show']])
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