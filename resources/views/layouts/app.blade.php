<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Laravel 5.8 Boilerplate">
      <meta name="author" content="Manojkiran.A">

      
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>{{ config('app.name', 'Laravel') }} @stack('title')</title>
      <!-- Bootstrap core CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css">
      
   </head>
   <body>
      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
         <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
               <ul class="navbar-nav ml-auto">
                  @can('user_access')
                  <li class="nav-item">
                     <a class="nav-link" href="{{route('admin.access.users.index')}}"> <i class="fas fa-users"></i> Users</a>
                  </li>   
                  @endcan

                  @can('role_access')
                  <li class="nav-item">
                     <a class="nav-link" href="{{route('admin.access.roles.index')}}"><i class="fas fa-user-shield"></i> Roles</a>
                  </li>   
                  @endcan
                  
                  @can('permission_access')
                  <li class="nav-item">
                     <a class="nav-link" href="{{route('admin.access.permissions.index')}}"> <i class="fas fa-key"></i> Permissions</a>
                  </li>   
                  @endcan
               </ul>
            </div>
         </div>
      </nav>
      <!-- Page Content -->
      <div class="container">

         @stack('breadCrumb')
         @include('comman.flashmessage')
         @yield('content')
      </div>
      <!-- Bootstrap core JavaScript -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <script>
          $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
      </script>
   </body>
</html>