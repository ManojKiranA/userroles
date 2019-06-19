@extends('layouts.app')
@push('title') Deleted Roles List @endpush
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
                 @include('comman.buttons.actionbutton.softgateaction', [
                        'modelObject' => $roleListValue,
                        'buttonsList' => [
                           'FORCE_DELETE' =>   ['permission' => 'role_force_delete','route' => 'admin.access.roles.forcedelete'],
                           'RESTORE' => ['permission' => 'role_restore','route' => 'admin.access.roles.restore'],
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

