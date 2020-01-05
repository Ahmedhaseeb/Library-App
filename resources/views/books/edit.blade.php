<style>
  .modal-body{
      overflow-y: scroll; 
  }
  .modal-dialog{
      /*width:80%;*/
  }
</style>
<script>
  $(document).ready(function(){
    // $('.modal-body').css({'height' : $(window).height() - 100 });
  });
</script>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4 class="modal-title" id="myModalLabel"><i class="fa fa-envelope"></i> Update Book  <span style="float:right;margin-right: 20px"><button type="button" onclick="x = confirm('Are you sure?');if(x){ document.deletionForm.submit(); }" class="btn btn-md btn-danger">Delete</button></span> </h4>
</div> <!-- modal-header -->
<div class="spacer"></div>
<form action="/books/{{ $book->id }}" method="POST" id="bookDelete" name="deletionForm">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
</form>
<div class="modal-body">
  <form action="/books/{{ $book->id }}" id="bookUpdateForm" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
    {{method_field('PUT')}}
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
      <label for="name">Name:</label>
      <input required="" class="form-control" id="name" value="{{$book->name}}" type="text" name="name" placeholder="Enter Book Name">  
      @if ($errors->has('name'))
          <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
          </span>
      @endif
    </div>

    <div class="form-group {{ $errors->has('isbn') ? ' has-error' : '' }}">
      <label for="isbn">Isbn:</label>
      <input required="" id="isbn" class="form-control" type="text" value="{{$book->isbn}}" name="isbn" placeholder="Enter Book ISBN">
      @if ($errors->has('isbn'))
          <span class="help-block">
              <strong>{{ $errors->first('isbn') }}</strong>
          </span>
      @endif  
    </div>

    <div class="form-group {{ $errors->has('qty') ? ' has-error' : '' }}">
      <label for="qty">Quantity:</label>
      <input required="" class="form-control" id="qty" type="number" value="{{$book->qty}}" name="qty" placeholder="Enter Book Quantity">  
      @if ($errors->has('qty'))
          <span class="help-block">
              <strong>{{ $errors->first('qty') }}</strong>
          </span>
      @endif
    </div>

    <div class="form-group {{ $errors->has('stock') ? ' has-error' : '' }}">
      <label for="stock">Stock:</label>
      <input required="" class="form-control" id="stock" type="number" value="{{$book->stock}}" name="stock" placeholder="Enter Book in Stock">
      @if ($errors->has('stock'))
          <span class="help-block">
              <strong>{{ $errors->first('stock') }}</strong>
          </span>
      @endif  
    </div>

    <div class="form-group">
      <input class="btn btn-lg btn-primary" type="submit" value="Update">
    </div>
  </form>
</div> <!-- modal-body -->