@extends('layouts.app')

@inject('configContainer','Illuminate\Support\Facades\Config')

@push('title') Users List @endpush

@push('breadCrumb')

   @component('components.breadCrumb',[
         'breadData' =>[
                  'Admin' => ['route' => null ,'icon' => 'fas fa-user-shield'],
                  'User Management' => ['route' => null ,'icon' => 'fas fa-user-lock'],
                  'User List' => ['route' => 'admin.access.users.index' ,'icon' => 'fas fa-users'],
                  ]
         ])
   @endcomponent

@endpush

@section('content')

<div class="card-box">
   <div class="card-block">

      @component('components.title', [
            'titleData' => [
                  'title' => 'Users List',
                  'buttonText' => 'Create User',
                  'route' => 'admin.access.users.create',
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
                 <td>Email</td>
                 <td>Roles</td>
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
                  <td>
                     @foreach($userValue->roles->pluck('name') as $role)
                        <span class="badge badge-info">{{ $role }}</span>
                     @endforeach
                  </td>
                  
                  <td>{{ $userValue->created_at }}</td>
                  <td>{{ $userValue->name }}</td>
                  <td class="text-center">
                  @include('comman.buttons.actionbutton.gateaction', [
                        'modelObject' => $userValue,
                        'buttonsList' => [
                           'EDIT' =>   ['permission' => 'user_edit','route' => 'admin.access.users.edit'],
                           'DELETE' => ['permission' => 'user_delete','route' => 'admin.access.users.destroy'],
                           'SHOW' =>   ['permission' => 'user_show','route' => 'admin.access.users.show'],
                           ]])
                  </td>
               </tr>
            @empty

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

