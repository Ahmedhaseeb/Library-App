$(function(){
	//cache the windows object
	var $window = $(window);
	$('section[data-type="background"]').each(function(){
		var $bgobj = $(this);
		$(window).scroll(function() {

			// scroll the background at var speed
			// the yPos is a negative value because we're scrolling UP!
			var yPos = -($window.scrollTop() / $bgobj.data('speed'));
			// Put together our final background postion
			var coords = '50%' + yPos + 'px';

			// Move the background
			$bgobj.css({ backgroundPosition: coords});
		});
	});
});

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function pd(e){
	e.preventDefault();
}

function edit(id){
	$('#bookEdit .modal-body').html('Loading');
	$.ajax({
		type:'GET',
		dataType:'html',
		url:'/books/'+id+'/edit',
		success:function(data){
			$('#bookEdit .modal-content').html(data);
		},
		error:function(data){
			bootbox.alert('something is wrong');
		}

	});
}


function editAuthor(id){
	$('#authorEdit .modal-body').html('Loading');
	$.ajax({
		type:'GET',
		dataType:'html',
		url:'/authors/'+id+'/edit',
		success:function(data){
			$('#authorEdit .modal-content').html(data);
		},
		error:function(data){
			bootbox.alert('something is wrong');
		}

	});
}

function getBookAuthors(id){
	$.ajax({
		type:'POST',
		headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  	},
		dataType:'json',
		url:'/get-authors',
		data: {
			action: "get-authors",
			id: id
		},
		success:function(data){
			console.log(data);
			var len = data.length;
			$("#authors option").each(function(){
				jQuery(this).prop("selected", false)
			});
			jQuery("#authors option").removeAttr(false);	
			for(var i = 0; i< len;i++){
				z = "#authors option[value="+data[i].author_id+"]";
				$(z).prop("selected", true);
			}
		},
		error:function(data){
			bootbox.alert('something is wrong');
		}

	});
}
function needBook(){
	bootbox.alert({
		message: "Note down the <b>ISBN</b> number and ask librarian to issue you this book",
    centerVertical: true
	});
}
function issueBook(id){
	var dialog = bootbox.dialog({
    message: '<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i> Please wait while we are assigning...</p>',
    closeButton: false
	});
	$.ajax({
		type:'POST',
		headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  	},
		dataType:'json',
		url:'/issue-book',
		data: {
			action: "issue-book",
			id: id
		},
		success:function(data){
			if(data.success == true){
				dialog.modal('hide');
				bootbox.alert("Book Assigned. Check Your Email");

			}
		},
		error:function(data){
			dialog.modal('hide');
			bootbox.alert("Something is wrong");
			// alert('something is wrong');
		}

	});
}
$( document ).ready(function() {
    $(".tile").height("150px");
    $(".carousel").height("150px");
     $(".item").height("150px");
     
    $(window).resize(function() {
    if(this.resizeTO) clearTimeout(this.resizeTO);
	this.resizeTO = setTimeout(function() {
		$(this).trigger('resizeEnd');
	}, 10);
    });
    
    $(window).bind('resizeEnd', function() {
    	$(".tile").height("150px");
        $(".carousel").height("150px");
        $(".item").height("150px");
    });

});