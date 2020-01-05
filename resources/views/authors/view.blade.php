@extends('layouts.app')
@section('title','Edit / Update Authors')
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
			<div class="spacer"></div>
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Name</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					@foreach($authors as $author)
						<tr>
							<td>{{$author->name}}</td>
							<td><button class="btn btn-md btn-primary" data-target="#authorEdit" data-toggle="modal" onclick="editAuthor({{$author->id}})"><i class="fa fa-edit"> </i> Edit</button></td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<div class="modal fade" id="authorEdit">
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