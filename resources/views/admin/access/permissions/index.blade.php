@extends('layouts.app')
@push('title') Permissions List @endpush
@section('content')
<div class="card-box">
   <div class="card-block">
      <div class="row">
         <div class="col-md-5">
            <h4 class="card-title">Permissions</h4>
         </div>
         <div class="col-md-7 page-action text-right">
            <a href="{{ route('admin.access.roles.create') }}" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-plus-sign"></i> Create Users</a>
         </div>
      </div>
      <div class="table-responsive">
         <table class="table">
            <thead>
               <tr>
                  <td>#</td>
                 <td>Name</td>
                 <td>Created At</td>  
               </tr>
            </thead>
            <tbody>

            @foreach($permissionList as $item)
          <tr>
             <td>@include('comman.serialnumber', ['serNo' => $permissionList])</td>
             <td>{{ $item->name }}</td>
             <td>{{ $item->created_at }}</td>
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

