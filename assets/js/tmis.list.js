// JavaScript Document


// Handle clicking on list buttons
$(function(){
	$(document).on('click', '.addcontenticon, .downloadcontenticon, .printcontenticon', function(e){
		var url = getBaseURL()+$(this).data('url');
		if($(this).hasClass('newwindow')){
			 window.open(url,'_blank');
		} else if($(this).hasClass('newwindowfromiframe')){
			window.parent.location.href= url;
		} else {
		   window.location.href = url;
		}
	});
});




//Handles list actions 
$(function() {
	$(document).on('click', '.approverow, .rejectrow, .publishrow, .archiverow, .restorerow, .blockrow, .saverow', function(e){
		
		// Find all action siblings and remove the active class
		$(this).parents('.listtable').first().find('.approverow, .rejectrow, .publishrow, .archiverow, .restorerow, .blockrow, .saverow').each(function(){
			$(this).removeClass('active');
		});
		
		var listType = $(this).data('type');
		var rowValues = $(this).data('val').split('__');
		
		if($(this).hasClass('confirm'))
		{
			if(window.confirm("Are you sure you want to "+rowValues[0].split('_')[0]+" this "+listType+"?")) {
				// Post this for processing archive or restore
				var fieldsToPost = { id: rowValues[1], listtype: listType, action: rowValues[0] };
				
				$.ajax({
        			type: "POST",
       				url: getBaseURL()+listType+'/verify',
      				data: fieldsToPost,
      				beforeSend: function() {
           				//Do nothing
					},
					error: function(xhr, status, error) {
  						console.log(xhr.responseText);
					},
      	 			success: function(data) {
		   				//console.log(data);
						updateFieldLayer(document.URL,'','','','');
					}
   				});
			}
		}
		else 
		{
			var url = getBaseURL()+listType+'/verify/action/'+rowValues[0]+'/id/'+rowValues[1];
			if($('#action__'+rowValues[1]).length > 0) updateFieldLayer(url,'','','action__'+rowValues[1],'');
		}
		// Show action as active
		$(this).addClass('active');
	});
	
	
	// Cancel list action
	$(document).on('click', '.cancellistbtn', function(e){
		$(this).parents('.listrow').first().find('.approverow, .rejectrow, .archiverow, .publishrow').each(function(){
			$(this).removeClass('active');
		});
		
		var parentDiv = $(this).parents('.actionrowdiv').first();
		parentDiv.fadeOut('fast');
		parentDiv.html('');
	});
	
	
	
	// Confirm list action
	$(document).on('click', '.confirmlistbtn', function(e){
		
		var btnId = $(this).attr('id');
		var idStub = btnId.substring(btnId.indexOf("_")+1, btnId.length );
		var id = btnId.split('_').pop();
		var listType = $('#hidden_'+idStub).val();
		var clearToPost = true;
		
		// Check if there are other custom field values
		var otherValues = "";
		$(this).parents('table').first().find('.otherfield').each(function(){
			if($(this).val() != ''){
				otherValues += '|'+$(this).attr('id').replace('_'+idStub, '')+'='+replaceBadChars($(this).val());
			} else if(!$(this).hasClass('optional')){
				clearToPost = false;
			}
		});
		
		
		
		if(clearToPost)
		{
			var fieldsToPost = { reason: $('#reason_'+idStub).val(), id: id, listtype: listType, action: idStub.replace('_'+id, ''), other:otherValues.replace(/^|/, '') };
		
			$.ajax({
        		type: "POST",
       			url: getBaseURL()+listType+"/verify",
      			data: fieldsToPost,
      			beforeSend: function() {
           			//Do nothing
				},
				error: function(xhr, status, error) {
  					console.log(xhr.responseText);
				},
      	 		success: function(data) {
		   			//console.log(data);
					updateFieldLayer(document.URL,'','','','');
				}
   			});
		}
		else
		{
			showServerSideFadingMessage('Enter all required fields to continue.');
		}
	});
	
});


