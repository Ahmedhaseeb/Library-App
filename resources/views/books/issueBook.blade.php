@extends('layouts.app')
@section('title','Issue Books')
@section('body')
<div class="spacer"></div>
<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
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
			<h1 align="center">Issue Books</h1>
			<div class="spacer"></div>
			<form action="{{route('issueBook')}}" method="post">
				<div class="row">
					<div class="col-sm-6">
						{{csrf_field()}}
						<div class="form-group">			
							<label for="book_id">Select Book</label>
							<select name="book_id" id="book_id" onchange="getBookAuthors(this.value)" class="form-control" required="">
								<option value="0">Select Book</option>
								@foreach($books as $book)
									<option value="{{$book->id}}" onclick="getBookAuthors({{$book->id}})">{{$book->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">						
							<label for="student_id">Select Student:</label>
							<select name="student_id" id="student_id" class="form-control" required="">
								<option value="0">Select Student</option>
								@foreach($students as $student)
									<option value="{{$student->id}}">{{$student->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="issuedate">issue date</label>
							<input type="date" id="issuedate" value="{{date('Y-m-d')}}" name="issuedate" class="form-control" />
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="returndate">Return Date</label>
							<input type="date" id="returndate" value="{{date('Y-m-d')}}" name="returndate" class="form-control" />
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<input type="submit" value="Save" class="btn btn-md btn-primary">
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="spacer"></div>
<div class="spacer"></div>
@endsection