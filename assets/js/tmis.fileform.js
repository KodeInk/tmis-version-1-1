// JavaScript Document

$(document).ready(function(event) {
    $('.layerform').ajaxForm({
    beforeSend: function() {
        
		$('#'+$('#'+$('#layerid').val()+'_displaylayer').val()).empty();
        if($('#'+$('#layerid').val()+'_bar').length)
		{
			var percentVal = '0%';
        	$('#'+$('#layerid').val()+'_bar').width('0')
        	$('#'+$('#layerid').val()+'_percent').html(percentVal);
		}
		else
		{
			$('#'+$('#'+$('#layerid').val()+'_displaylayer').val()).html("<img src='"+getBaseURL()+"assets/images/loading.gif'>");
		}
    },
    uploadProgress: function(event, position, total, percentComplete) {
       	if($('#'+$('#layerid').val()+'_bar').length)
		{
	    	var percentVal = percentComplete + '%';
			$('#'+$('#layerid').val()+'_bar').width(percentVal)
        	$('#'+$('#layerid').val()+'_percent').html(percentVal);
		}
		else
		{
			$('#'+$('#'+$('#layerid').val()+'_displaylayer').val()).html("<img src='"+getBaseURL()+"assets/images/loading.gif'>");
		}
    },
    success: function() {
        if($('#'+$('#layerid').val()+'_bar').length)
		{
			var percentVal = '100%';
       	 	$('#'+$('#layerid').val()+'_bar').width(percentVal)
        	$('#'+$('#layerid').val()+'_percent').html(percentVal);
		}
		else
		{
			$('#'+$('#'+$('#layerid').val()+'_displaylayer').val()).html("<img src='"+getBaseURL()+"assets/images/loading.gif'>");
		}
    },
	complete: function(xhr) {
		$('#'+$('#'+$('#layerid').val()+'_displaylayer').val()).html(xhr.responseText);
	}
	}); 


});

