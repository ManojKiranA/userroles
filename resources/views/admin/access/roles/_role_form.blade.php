<div class="box-body">
   {{-- Row  One Starts --}}
   <div class="row">
      {{--  Field Name Starts  --}}
      <div class="col-sm-4">
         <div class="form-group @error('name') has-error @enderror">
            {!! Form::label('name','Name') !!}
            {!! Form::text('name',old('name'),['placeholder'=>'Name of the Role','class' =>'form-control rounded','id' =>'name']) !!}
            @error('name') 
            <p class="help-block">{{ $message }}</p>
            @enderror
         </div>
      </div>
      {{--  Field Name Ends  --}}
      {{--  Field description Starts  --}}
      <div class="col-sm-4">
         <div class="form-group @error('description') has-error @enderror">
            {!! Form::label('description','Description') !!}
            {!! Form::text('description',old('description'),['placeholder'=>'Description of the Role','class' =>'form-control rounded','id' =>'description']) !!}
            @error('description') 
            <p class="help-block">{{ $message }}</p>
            @enderror
         </div>
      </div>
      {{--  Field description Ends  --}}
   </div>
   {{-- Row One Ends --}}
</div>
@include('comman.formbuttons')