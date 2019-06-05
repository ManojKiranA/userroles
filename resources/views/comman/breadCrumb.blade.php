<nav aria-label="breadcrumb">
   <ol class="breadcrumb">
      @foreach ($breadData as $breadTitle => $breadData)
        @if (!$loop->last)
            @php
                if (array_key_exists('route',$breadData) && !is_null($breadData['route'])){
                    $routeName = $breadData['route'];
                    $route = route($routeName);
                }elseif(array_key_exists('url',$breadData) && !is_null($breadData['url'])){
                    $urlName = $breadData['url'];
                    $route = url($urlName);
                }else{
                    $route = '#';
                }

                if (array_key_exists('icon',$breadData) && !is_null($breadData['icon'])){
                    $icon = $breadData['icon'];
                }else {
                    $icon = '';
                }

            @endphp

        <li class="breadcrumb-item">
            <i class="{{$icon}}"></i>
            <a href="{{$route}}">{{$breadTitle}}</a>
        </li>
        @endif
        @if ($loop->last)
@php
        if (array_key_exists('icon',$breadData) && !is_null($breadData['icon'])){
                    $icon = $breadData['icon'];
                }else {
                    $icon = '';
                }
@endphp
        <li class="breadcrumb-item active" aria-current="page"><i class="{{$icon}}"></i> {{$breadTitle}}</li>
        @endif
      @endforeach
   </ol>
</nav>