@extends('layouts.app')
@section('title','Add New Author')

@section('body')
<div class="spacer"></div>
<div class="container" style="height: 84vh">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			@if(Session()->has('message'))
        <div class="alert alert-success">
            <ul>
                <li>{{ Session::get('message') }}</li>
            </ul>
        </div>
			@endif
			<h1 align="center">Add New Author</h1>
			<div class="spacer"></div>
			<form action="{{route('authors.store')}}" method="post">
				{{csrf_field()}}
				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					<input required="" id="name" class="form-control" value="{{old('name')}}" type="text" name="name" placeholder="Enter Author Name">	
					@if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
				</div>
				<div class="form-group">
					<input class="btn btn-lg btn-primary" type="submit" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	jQuery("#name").focus();
</script>
@endsection