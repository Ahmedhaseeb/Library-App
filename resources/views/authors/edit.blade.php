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
  <h4 class="modal-title" id="myModalLabel"><i class="fa fa-envelope"></i> Update Author  <span style="float:right;margin-right: 20px"><button type="button" onclick="x = confirm('Are you sure?');if(x){ document.deletionForm.submit(); }" class="btn btn-md btn-danger">Delete</button></span> </h4>
</div> <!-- modal-header -->
<div class="spacer"></div>
<form action="/authors/{{ $author->id }}" method="POST" id="authorDelete" name="deletionForm">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
</form>
<div class="modal-body">
  <form action="/authors/{{ $author->id }}" id="authorUpdateForm" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
    {{method_field('PUT')}}
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
      <label for="name">Name:</label>
      <input required="" class="form-control" id="name" value="{{$author->name}}" type="text" name="name" placeholder="Enter Author Name">  
      @if ($errors->has('name'))
          <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
          </span>
      @endif
    </div>
    <div class="form-group">
      <input class="btn btn-lg btn-primary" type="submit" value="Update">
    </div>
  </form>
</div> <!-- modal-body -->