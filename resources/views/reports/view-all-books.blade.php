@extends('layouts.app')
@section('title','View All Books')
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
			<h1 align="center">List of All Books</h1>
			<div class="spacer"></div>
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Name</th>
						<th>Book Authors</th>
						<th>ISBN</th>
						<th>Quantity</th>
						<th>Stock</th>
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
							<!-- <td><button class="btn btn-md btn-primary" data-target="#bookEdit" data-toggle="modal" onclick="edit({{$book->id}})"><i class="fa fa-edit"> </i> Edit</button></td> -->
						</tr>
					@endforeach
				</tbody>
			</table>

			<div class="modal fade" id="bookEdit">
	    <div class="modal-dialog">
	        <div class="modal-content">
	        	asd
	        </div> <!-- modal-content -->
	    </div> <!-- modal-dialog -->
	</div> <!-- modal -->
		</div>
	</div>
</div>

@endsection