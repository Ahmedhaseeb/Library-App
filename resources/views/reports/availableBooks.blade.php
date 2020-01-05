@extends('layouts.app')
@section('title','Books Available In Stock')
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
			<h1 align="center">Available Books</h1>
			<div class="spacer"></div>
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Name</th>
						<th>Book Authors</th>
						<!-- <th>Student Name</th> -->
						<th>ISBN</th>
						<th>Quantity</th>
						<th>Stock</th>
						<!-- <th>Action</th> -->
					</tr>
				</thead>

				<tbody>
					@foreach($books as $book)
						<tr>
							<td>{{$book->book_name}}</td>
							<td>{{$book->author_name}}</td>
							<td>{{$book->isbn}}</td>
							<td>{{$book->qty}}</td>
							<td>{{$book->stock}}</td>
							
							<!-- <td><button class="btn btn-md btn-info" onclick="needBook()"><i class="fa fa-exclamation"> </i> Need This Book ?</button></td> -->
						</tr>
					@endforeach
				</tbody>
			</table>

		</div>
	</div>
</div>

@endsection