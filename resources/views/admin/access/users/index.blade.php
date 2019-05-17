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
               </tr>
            </thead>
            <tbody>

            @foreach($usersList as $userKey =>  $userValue)
          <tr>
          
             <td>@include('comman.serialnumber', ['serNo' => $usersList])</td>
             <td>{{ $userValue->name }}</td>
             <td>{{ $userValue->email }}</td>
             <td>{{ $userValue->created_at }}</td>
             <td>{{ $userValue->name }}</td>
             <td>{{ $userValue->editButton(['buttonText' => 'Edit']) }}</td>
             <td>{{ $userValue->deleteButton(['buttonText' => 'Delete']) }}</td>
          </tr>
          @endforeach

              


               
            </tbody>
         </table>
      </div>
      <div class="text-center">
         {{ $usersList->links() }}
      </div>
   </div>
</div>
@endsection

