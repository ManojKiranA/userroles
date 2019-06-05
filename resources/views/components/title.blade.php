@php
function checkAndSet($data,$key,$default)
{
   if(array_key_exists($key,$data))
    {
        $result = ($data[$key]);
    }else 
    {
        $result = $default ?? null;
    } 
    return $result;
}
    
    $title = checkAndSet($titleData,'title','');
    $icon = checkAndSet($titleData,'icon','');
    $class = checkAndSet($titleData,'class','');
    $buttonText = checkAndSet($titleData,'buttonText','');

    if(array_key_exists('route',$titleData))
    {
        $actionUrl = route($titleData['route']);
    }elseif (array_key_exists('url',$titleData)) 
    {
        $actionUrl = url($titleData['url']);
    }else {
        $actionUrl = '#';
    }

@endphp
<div class="row">
         <div class="col-md-5">
            <h4 class="card-title">{{$title}}</h4>
         </div>
         <div class="col-md-7 page-action text-right">
         <a href="{{ $actionUrl }}" class="{{$class}}"> <i class="{{$icon}}"></i>  {{$buttonText}}</a>
         </div>
      </div>