@extends('layouts.app')
@push('title') Users List @endpush
@section('content')
<div class="card-box">
   <div class="card-block">
      <div class="row">
         <div class="col-md-5">
            <h4 class="card-title">Users</h4>
         </div>
         <div class="col-md-7 page-action text-right">
            <a href="{{ route('admin.access.users.create') }}" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-plus-sign"></i> Create Users</a>
         </div>
      </div>

      <div class="table-responsive">
         <table class="table">
            <thead>
               <tr>
                  <td>#</td>
                 <td>Name</td>
                 <td>Email</td>
                 <td>Created At</td>  
                 <td>Created By</td> 
                 @include('comman.gateactionheader',['permissionList' => ['user_edit','user_delete','user_show']])
               </tr>
            </thead>
            <tbody>

            @forelse ($usersList as $userKey =>  $userValue)
               <tr>
                  <td>@include('comman.serialnumber', ['serNo' => $usersList])</td>
                  <td>{{ $userValue->name }}</td>
                  <td>{{ $userValue->email }}</td>
                  <td>{{ $userValue->created_at }}</td>
                  <td>{{ $userValue->name }}</td>
                  <td class="text-center">
                  @include('comman.gateactionbuttons', ['modelObject' => $userValue,'buttonsList' => ['EDIT' => 'user_edit','DELETE' => 'user_delete','SHOW' => 'user_show']])
                  </td>
               </tr>
            @empty

                  {{-- <tr class="text-center">
                     <td>
                  <p>No replies</p>
                     </td>
                  </tr> --}}
                  <tr>
                     <td valign="top" colspan="3">
                        No data available in table
                     </td>
                  </tr>
            @endforelse             
            </tbody>
         </table>
      </div>
      <div class="text-center">
         {{ $usersList->appends(request()->input())->links() }}
         
      </div>
   </div>
</div>
@endsection

