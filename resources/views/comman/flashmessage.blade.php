@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">X</button>	
        <strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('error'))

<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">X</button>	
        <strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
	<button type="button" class="close" data-dismiss="alert">X</button>	
	<strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
	<button type="button" class="close" data-dismiss="alert">X</button>	
	<strong>{{ $message }}</strong>
</div>
@endif




@if ($errors->any())

<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">X</button>	
	Please check the form below for errors
</div>
@endif

@if ($errors->any())
	<div class="alert alert-warning alert-dismissable fade show">
		<button class="close" data-dismiss="alert" aria-label="Close"><i class='fa fa-window-close'></i></button>
		<ol>
		@foreach ($errors->all(':message') as $eachError)
		<li><strong>Warning! </strong>{{$eachError}}<br></li>
		@endforeach
		</ol>
	</div>
@endif