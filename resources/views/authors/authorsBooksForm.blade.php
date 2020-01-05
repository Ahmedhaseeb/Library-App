@extends('layouts.app')
@section('title','Assign Authors To Books')
@section('body')
<div class="spacer"></div>
<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			@foreach($errors->all() as $error)
				<span class="alert alert-danger">
          <strong>{{ $error }}</strong>
        </span>
			@endforeach
			@if(Session()->has('customErrors'))	
				@foreach(Session::get('customErrors') as $error)
					<div class="alert alert-info">
	          <strong>{{ $error }}</strong>
	        </div>
				@endforeach
			@endif
			@if(Session()->has('message'))
        <div class="alert alert-success">
          <ul>
            <li>{{ Session::get('message') }}</li>
          </ul>
        </div>
			@endif
			@if(Session()->has('error'))
        <div class="alert alert-danger">
          <ul>
            <li>{{ Session::get('error') }}</li>
          </ul>
        </div>
			@endif
			<h1 align="center">Assign Authors To Book</h1>
			<div class="spacer"></div>
			<form action="{{route('storeBookAuthors')}}" method="post">
				<div class="row">
					<div class="col-sm-6">
						{{csrf_field()}}
						<div class="form-group">			
							<label for="book">Select Book</label>
							<select name="book" id="book" onchange="getBookAuthors(this.value)" class="form-control">
								<option value="0">Select Book</option>
								@foreach($books as $book)
									<option value="{{$book->id}}">{{$book->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<label for="authors">Select Authors:</label>
						<select name="authors[]" id="authors" multiple="" class="form-control" style="min-height: 200px">
							@foreach($authors as $author)
								<option value="{{$author->id}}">{{$author->name}}</option>
							@endforeach
						</select>
					</div>
					<input type="submit" value="Save" class="btn btn-md btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>
<div class="spacer"></div>
<div class="spacer"></div>
@endsection