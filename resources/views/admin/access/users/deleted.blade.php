@extends('layouts.app')
@push('title') Deleted Users List @endpush
@section('content')
<div class="card-box">
   <div class="card-block">
      <div class="row">
         <div class="col-md-5">
            <h4 class="card-title">Deleted Users</h4>
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
                 <td class="text-center">
                 Actions
                 </td>
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
                      {{$userValue->forceDeleteButton()}}
                      {{$userValue->restoreButton()}}
                  @include('comman.actionbuttons', ['modelObject' => $userValue,'buttonsList' => ['DELETE']])
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

