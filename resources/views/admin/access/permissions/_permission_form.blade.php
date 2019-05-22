<div class="box-body">
   {{-- Row  One Starts --}}
   <div class="row">
      {{--  Field Name Starts  --}}
      <div class="col-sm-4">
         <div class="form-group @error('name') has-error @enderror">
            {!! Form::label('name','Name') !!}
            {!! Form::text('name',old('name'),['placeholder'=>'Name of the Permission','class' =>'form-control rounded','id' =>'name']) !!}
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
            {!! Form::text('description',old('description'),['placeholder'=>'Description of the Permission','class' =>'form-control rounded','id' =>'description']) !!}
            @error('description') 
            <p class="help-block">{{ $message }}</p>
            @enderror
         </div>
      </div>
      {{--  Field description Ends  --}}

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
   {{-- Row One Ends --}}
</div>
@include('comman.formbuttons')