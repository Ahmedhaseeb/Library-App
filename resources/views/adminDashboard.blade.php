@extends('layouts.app')
@section('title','Admin Panel')


@section('body')
<style>
	body{
		height: 100vh;
	}
</style>
<div class="spacer"></div>
<div class="spacer"></div>
<div class="container">
	<div class="dynamicTile">

		<div class="row form-group">
			<div class="col-sm-4">
				<div id="tile3" class="tile" onclick="window.open('{{$domain}}/books','_self');">
	        <h3 class="tilecaption"><i class="fa fa-book fa-4x"></i></h3> 
				</div>
				<h3 align="center"><label for="">View-Edit-Delete Books</label></h3>
			</div>
			<div class="col-sm-4">
				<div id="tile4" class="tile" onclick="window.open('{{$domain}}/books/create','_self');">
	        <h3 class="tilecaption"><i class="fa fa-book fa-4x"></i></h3>         
				</div>
				<h3 align="center"><label for="">Add New Book</label></h3>
			</div>
			<div class="col-sm-4">
				<div id="tile1" class="tile" onclick="window.open('{{$domain}}/authors','_self');">       	  
		          	<h3 class="tilecaption"><i class="fa fa-group fa-4x"></i></h3>
					
				</div>
				<h3 align="center"><label for="">View-Edit-Delete Authors</label></h3>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-sm-4">
				<div id="tile2" class="tile" onclick="window.open('{{$domain}}/authors/create','_self');">
          <h3 class="tilecaption"><i class="fa fa-user fa-4x"></i></h3>			
				</div>
				<h3 align="center"><label for="">Add New Author</label></h3>
			</div>
			<div class="col-sm-4">
				<div id="tile6" class="tile" onclick="window.open('{{$domain}}/authors-books','_self');">
		              <h3 class="tilecaption">
		              	<i class="fa fa-user fa-4x"></i>
		              	&nbsp;<i class="fa fa-arrows-h fa-4x"></i>&nbsp; 
		              	<i class="fa fa-book fa-4x"></i> 
		              </h3>         
				</div>
				<h3 align="center"><label for="">Assign Authors To Books</label></h3>
			</div>
			<div class="col-sm-4">
				<div id="tile10" class="tile" onclick="window.open('{{$domain}}/issue-book','_self');">
            <h3 class="tilecaption"><i class="fa fa-book fa-4x"></i> <i class="fa fa-arrows-h fa-4x"></i> <i class="fa fa-graduation-cap fa-4x"></i></h3>         
				</div>
				<h3 align="center"><label for="">Issue Book</label></h3>
			</div>

		</div>
		<div class="row form-group">
			<div class="col-sm-4">
				<div id="tile5" class="tile" onclick="window.open('{{$domain}}/reports/all-books','_self');">
            <h3 class="tilecaption"><i class="fa fa-file fa-4x"></i></h3>         
				</div>
				<h3 align="center"><label for="">List Of All Books</label></h3>
			</div>
			
			<div class="col-sm-4">
				<div id="tile8" class="tile" onclick="window.open('{{$domain}}/reports/avail-books','_self');">
          <h3 class="tilecaption"><i class="fa fa-book fa-4x"></i></h3>
				</div>
				<h3 align="center"><label for="">Available Books</label></h3>
			</div>
			<div class="col-sm-4">
				<div id="tile9" class="tile" onclick="window.open('{{$domain}}/reports/books-issued','_self');">
          <h3 class="tilecaption"><i class="fa fa-book fa-4x"></i></h3>         
				</div>
				<h3 align="center"><label for="">Issued Books</label></h3>
			</div>
		</div>
	</div>
</div>
@endsection