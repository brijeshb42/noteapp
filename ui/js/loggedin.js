noteapp = {
	selectedNoteText: ""
}

keys = {
	enter: 13,
	esc: 27,
	backspace: 8
}

function notify(type,text){
	if($('.notification').size()>0)
		$('.notification').remove();
	var node = $('<div class="notification alert alert-block alert-'+type+'">'+text+'<button type="button" class="close" data-dismiss="alert">×</button></div>');
	$('body').append(node);
	node.fadeIn(500).fadeOut(5000);
}

function createNewNote(id,text){
	text = $('<div></div>').text(text).html()
	var note = '<div class="list-item" id="item-'+id+'"><p data-val="'+id+'">'+text+'</p><div class="btn-toolbar controls"><div class="btn-group"><button data-val="'+id+'" data-url="'+location.href+'note/edit/'+id+'" class="item-edit btn" title="Edit"><i class="icon icon-edit"></i></button><button data-val="'+id+'" data-url="'+location.href+'note/delete/'+id+'" class="item-delete btn btn-warning" title="Delete"><i class="icon icon-remove"></i></button><button data-val="'+id+'" data-url="'+location.href+'note/changecolor/'+id+'" class="item-move btn" title="Reorder"><i class="icon icon-move"></i></button></div></div></div>';
	$(".note-list").prepend(note);
}

function createTextArea(id){
	var uid= $("#user_id").val();
	$("#item-"+id).prepend('<form action="'+baseUrl+'note/edit/'+id+'" data-val="'+id+'" class="tmp-form" id="temp-edit-'+id+'" method="POST"><input class="tmp-text" type="text" name="newnote" id="edittext-'+id+'" /><input name="user_id" value="'+uid+'" type="hidden" /><input name="item_id" value="'+id+'" type="hidden" /><button title="Update" type="submit" name="submit" class="btn save-btn"><i class="icon icon-folder-close"></i></button></form>');
	$('#edittext-'+id).focus();
	var p = $("#item-"+id+">p");
	$('#edittext-'+id).val(p.html());
	noteapp.selectedNoteText = p.html();
	p.hide();
}

function restoreLists(){
	noteapp.selectedNoteText="";
	$(".tmp-form").remove();
	$(".list-item p").show();
}

$(document).ready(function(){
	$("#submit").attr("disabled","true");
	$("#newnote").focus();

	$(document).on("dblclick",'.list-item>p',function(){
		restoreLists();
		id = $(this).data('val');
		createTextArea(id);
	});

	$(document).on("click","button.item-edit",function(){
		var id = $(this).data("val");
		if($(".tmp-form").size()==0){
			restoreLists();
			createTextArea(id);
		}
		else
			restoreLists();
	});

	$(document).on("submit",".tmp-form",function(e){
		var uid = $("#user_id").val();
		if($(".tmp-text").val()==""){
			notify("error","Something is needed in the note.");
		}
		else{
			var id = $(this).data("val");
			var note = $(".tmp-text").val();
			if(note==noteapp.selectedNoteText){
				notify("info","Please update the note.");
				return false;
			}
			$.ajax({
				url: $(this).attr('action'),
				type: "post",
				dataType: "json",
				data: $(this).serialize(),
				success: function(json){
					if(json.type=="success"){
						$("#item-"+id+" p").html(note);
						noteapp.selectedNoteText="";
						
					}
					restoreLists();
					notify(json.type,json.message);
				},
				error: function(e){
					notify("error","Error connecting to server.");
				}
			});
		}
		return false;
	});

	$(document).on("click","button.item-delete",function(){
		var id = $(this).data("val");
		if(confirm("Delete note?")){
			$.ajax({
			url: $(this).data("url"),
			type: "post",
			dataType: "json",
			cache: false,
			success: function(json){
				if(json.type=="success"){
					$("#item-"+id).remove();
					notify(json.type,json.message);
				}
				else if(json.type=="error"){
					notify(json.type,json.message);
				}
			},
			error: function(){
				notify("error","Error connecting to server.");
			}
			});
		}
	});

	$("#note-form").submit(function(){
		var text = $("#newnote").val();
		if(text==""){
			notify("error","Something is needed in the note.");
			return false;
		}
		$.ajax({
			url: $(this).attr('action'),
			type: $(this).attr('method'),
			data: $('#note-form :input').serialize(),
			dataType: "json",
			success: function(json){
				if(json.type=="success"){
					createNewNote(json.message,text);
					$("#newnote").val("");
					notify(json.type,"Note added / update.");
				}else{
					notify(json.type,json.message);
				}
			},
			error: function(){
				notify("error","Error connecting to server.");
			}
		});
		return false;
	});

	$("#newnote").on("focus",function(){
		if($(this).val()==""){
			$("#submit").attr("disabled","true");
		}else{
			$("#submit").removeAttr("disabled");
		}
	});
	$("#newnote").on("keypress",function(e){
		//console.log(e.keyCode);
		if(($(this).val().length+1)<0){
			$("#submit").attr("disabled","true");
		}else{
			$("#submit").removeAttr("disabled");
		}
	});

	$(document).keydown(function(e){
		if(e.keyCode==keys.esc){
			restoreLists();
		}
		else if(e.keyCode==keys.backspace){
			if(($("#newnote").val().length-1)==0){
				$("#submit").attr("disabled","true");
			}
		}
	});
});