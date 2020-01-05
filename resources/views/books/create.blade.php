@extends('layouts.app')
@section('title','Add New Book')

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
			<h1 align="center">Add New Book</h1>
			<div class="spacer"></div>
			<form action="{{route('books.store')}}" method="post">
				{{csrf_field()}}
				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					<input required="" class="form-control" value="{{old('name')}}" type="text" name="name" placeholder="Enter Book Name">	
					@if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
				</div>
				<div class="form-group {{ $errors->has('isbn') ? ' has-error' : '' }}">
					<input required="" class="form-control" type="text" value="{{old('isbn')}}" name="isbn" placeholder="Enter Book ISBN">
					@if ($errors->has('isbn'))
              <span class="help-block">
                  <strong>{{ $errors->first('isbn') }}</strong>
              </span>
          @endif	
				</div>
				<div class="form-group {{ $errors->has('qty') ? ' has-error' : '' }}">
					<input required="" class="form-control" type="number" value="{{old('qty')}}" name="qty" placeholder="Enter Book Quantity">	
					@if ($errors->has('qty'))
              <span class="help-block">
                  <strong>{{ $errors->first('qty') }}</strong>
              </span>
          @endif
				</div>
				<div class="form-group {{ $errors->has('stock') ? ' has-error' : '' }}">
					<input required="" class="form-control" type="number" value="{{old('stock')}}" name="stock" placeholder="Enter Book in Stock">
					@if ($errors->has('stock'))
              <span class="help-block">
                  <strong>{{ $errors->first('stock') }}</strong>
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

@endsection