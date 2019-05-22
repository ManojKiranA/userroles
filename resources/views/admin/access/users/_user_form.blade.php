<div class="box-body">
   {{-- Row  One Starts --}}
   <div class="row">
      {{--  Field Name Starts  --}}
      <div class="col-sm-4">
         <div class="form-group @error('name') has-error @enderror">
            {!! Form::label('name','Name') !!}
            {!! Form::text('name',old('name'),['placeholder'=>'Name of the User','class' =>'form-control rounded','id' =>'name']) !!}
            @error('name') 
            <p class="help-block">{{ $message }}</p>
            @enderror
         </div>
      </div>
      {{--  Field Name Ends  --}}
      {{--  Field email Starts  --}}
      <div class="col-sm-4">
         <div class="form-group @error('email') has-error @enderror">
            {!! Form::label('email','Email Id') !!}
            {!! Form::email('email',old('email'),['placeholder'=>'Enter Employee Email','class' =>'form-control rounded','id' =>'email']) !!}
            @error('email') 
            <p class="help-block">{{ $message }}</p>
            @enderror
         </div>
      </div>
      {{--  Field email Ends  --}}
      {{--  Field Password Starts  --}}
      <div class="col-sm-4">
         <div class="form-group @error('password') has-error @enderror">
            {!! Form::label('password','Password') !!}
            {!! Form::password('password', ['placeholder'=>'Enter Password','class' =>'form-control rounded','id' =>'password']) !!}
            @error('password') 
            <p class="help-block">{{ $message }}</p>
            @enderror
         </div>
      </div>
      {{--  Field Password Ends  --}}
   </div>
   {{-- Row One Ends --}}

   {{-- Row  Two Starts --}}
   <div class="row">
      {{--  Field roles Starts  --}}
      <div class="col-sm-4">
         <div class="form-group @error('roles') has-error @enderror">
            {!! Form::label('roles','Roles') !!}
            {!! Form::select('roles[]',$roleList,old('roles'), ['class' =>'form-control rounded','id' =>'roles','multiple' => 'multiple']) !!}
            @error('roles') 
            <p class="help-block">{{ $message }}</p>
            @enderror
         </div>
      </div>
      {{--  Field roles Ends  --}}
   </div>
   {{-- Row Two Ends --}}

   
</div>
@include('comman.formbuttons')