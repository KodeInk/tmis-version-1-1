// JavaScript Document


//Process an action to the system message
function processToMessage(actionUrl, elementIdentifier, actionCode, tempDivId, warningMessage)
{
	var proceedToProcess = true;
	
	//Check if the user needs to confirm the action before proceeding
	if(actionCode.charAt(0) == "*")
	{
		proceedToProcess = false;
		if(window.confirm(warningMessage)) {
			//Remove the warning identifier
			actionCode = actionCode.substr(1,actionCode.length);
			proceedToProcess = true;
		}
	}
	
	if(proceedToProcess){
		var elementIds = Array();
		var elementValues = Array();
		//Collect the selected element IDs for further processing
		$(elementIdentifier).each(function(i, elem){
			if($(elem).is(':checked')){
				elementIds.push($(elem).attr('id'));
				elementValues.push($(elem).val());
			}
		});
		
		
		//If action is delete or archive, then remove the table row from view
		var removeActions = Array('delete', 'archive');
		if(inArray(removeActions, actionCode, 'bool'))
		{
			for(var i=0;i<elementIds.length;i++)
			{
				$('#'+elementIds[i]).closest('tr').remove();
			}
		}
		
		
		//Create a form in the tempDivId and then submit it with the hidden items
		//To not show this form, hide it in the view
		if(elementIdentifier.charAt(0) == ".")
		{
			elementIdentifier = elementIdentifier.substr(1,elementIdentifier.length);
		}
		var formId = elementIdentifier+"__form";
		var divHTML = "<form id='"+formId+"' action='"+actionUrl+"' method='post'>";
		for(var i=0;i<elementIds.length;i++)
		{
			divHTML += "<input type='hidden' name='items[]' id='"+elementIds[i]+"' value='"+elementValues[i]+"' />";
		}
		//The asterisk tells the system to display in the system message area
		divHTML += "<input type='hidden' name='"+formId+"_displaylayer' id='"+formId+"_displaylayer' value='*"+tempDivId+"' />"
				   +"</form>";
		//Put the form in the body
		$('#'+tempDivId).html(divHTML);
		//Now process the items as desired 
		submitLayerForm(formId);
	}
}



//Get the popup selected items and pass them on with the url
//This function needs fancybox on the page to work
function getPopUpSelectedItems(listTableId, popUrl)
{
	//First get the selected items
	var selectedItems = Array();
	//Collect the selected element IDs for further processing
	$('#'+listTableId+' input').each(function(i, elem){
		
		if($(elem).is(':checked') && $(elem).val() != 'selectall'){
			selectedItems.push($(elem).val());
		}
	});
	
	
	//Do not proceed if there are no items selected
	if(selectedItems.length > 0)
	{
		var selectedItemsString = selectedItems.join('___');
		
		//If the div does not exist, create it
		if(!$('#'+listTableId+'_popdiv').length)
		{
			$('#'+listTableId).after("<div id='"+listTableId+"_popdiv' style='display:none;'><a href='"+popUrl+'/vals/'+selectedItemsString+"' class='fancybox fancybox.ajax'>Go To Popup</a></div>" );
		}
		else
		{
			$('#'+listTableId+'_popdiv .fancybox').attr('href', popUrl+'/vals/'+selectedItemsString);
		}
		
		$('#'+listTableId+'_popdiv .fancybox').click();
	}
	else
	{
		alert('Please select an item to proceed.');
	}
}
































//Handles search dropdowns
$(function() {
	//The field is clicked 
	$(document).on('click', '.searchlistoptions', function(e){
		//What is this field's ID?
		var fieldId = $(this).attr('id');
			
		//First hide all previously shown divs of this kind
		$(".searchlistoptionsvalues").not('#'+fieldId+'_values').hide('fast');
			
		//The div is visible 
		if(!$('#'+fieldId+'_values').is(':visible'))
		{
			$('#'+fieldId+'_values').show('fast');
			$('#'+fieldId+'_values').css('min-width', $(this).width()+32);
			
		}
		else
		{
			$('#'+fieldId+'_values').hide('fast');
		}
	});
	
	
	//The list is clicked
	$('.searchlistoptionsvalues:not(.disableredirect) tr').click(function(e){
		var checkboxId = $(this).find('input').attr('id');
		$('#'+checkboxId).prop("checked", true);
		var idParts = checkboxId.split('_');
		var checkboxValue = $('#'+checkboxId).val();
		//This is the main menu value
		$('#mainmenuvalue').val(checkboxId);
		
		$('#'+idParts[0]+'options').val(checkboxValue);
		//Now hide the menu div
		$('.searchlistoptionsvalues').hide('fast');
		
		//Show the new list based on selection
		updateFieldLayer($('#listbaseurl').val()+'/t/'+checkboxId,'','',$('#listdiv').val(),'');
	});
	
	//For those that do not allow redirecting
	$('.disableredirect tr').click(function(e){
		var checkboxId = $(this).find('input').attr('id');
		$('#'+checkboxId).prop("checked", true);
	});
	
	
	
	
	
	$(document).mouseup(function (e){
    	//Classes of the divs to hide
		var divsToHide = Array('searchlistoptionsvalues', 'slideoptionslistvalues');
		
		for(var i=0; i<divsToHide.length; i++)
		{
			var fieldListDivs = $('.'+divsToHide[i]);
			//If the target of the click isn't the container... nor a descendant of the container
			//Hide it
   			if (!fieldListDivs.is(e.target) && fieldListDivs.has(e.target).length == 0) 
    		{
       	 		fieldListDivs.hide('fast');
    		}
		}
		
	});
	
	
	//------------------------------------------------------------------------------------
	//Slide menu options
	//------------------------------------------------------------------------------------
	//Has clicked the middle part
	$(document).on('click', '.slideoptionslist td', function(e){
		//What is this field's ID?
		var fieldTableId = $(this).closest('table').attr('id');
		
		//The middle part has been clicked
		if($(this).index() == 1)
		{
			//First hide all previously shown divs
			$(".slideoptionslistvalues").not('#'+fieldTableId+'_values').hide('fast');
			
			//The div is visible 
			if(!$('#'+fieldTableId+'_values').is(':visible'))
			{
				$('#'+fieldTableId+'_values').show('fast');
				$('#'+fieldTableId+'_values').css('min-width', $('#'+fieldTableId).width());
			}
			else
			{
				$('#'+fieldTableId+'_values').hide('fast');
			}
		}
	});
	
	
	//The list item is clicked
	$('.slideoptionslistvalues tr').click(function(e){
		var checkboxId = $(this).find('input').attr('id');
		$('#'+checkboxId).prop("checked", true);
		var idParts = $(this).closest('div').attr('id').split('_');
		var checkboxValue = $('#'+checkboxId).val();
		
		$('#'+idParts[0]+' tr td:nth-child(2)').html(checkboxValue);
		//Now hide the menu div
		$('.slideoptionslistvalues').hide('fast');
		
		//Show the new list based on selection
		updateFieldLayer($('#listbaseurl').val()+'/t/'+$('#mainmenuvalue').val()+'/s/'+checkboxId,'','',$('#listdiv').val(),'');
	});
	
});	







//For scrollable list tables
$(function() {
	var listTable = $(".scrollablelisttable");
	var tableId = listTable.attr('id');
	var tableOffset = listTable.offset().top;
	var header = $(".scrollablelisttable > thead").clone();
	if(listTable.closest(".scrollablelistheader").length == 0)
	{
		listTable.after( '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="scrollablelistheader"></table>' );
	}
	var fixedHeader = $(".scrollablelistheader").append(header);
	
	//Now make the header visible when it scrolls
	$(window).bind("scroll", function() {
   		var offset = $(this).scrollTop();
    
    	if (offset >= tableOffset && fixedHeader.is(":hidden")) 
		{
       		 //Adjust the width of the columns
			 $(".scrollablelisttable").find('thead th').each(function (i) {
				fixedHeader.find('th').eq(i).width($(this).width());
			 });
			 fixedHeader.width($(".scrollablelisttable").width());
			 
			 //Make the height of the scrollable list header
			 var heightOfListTableHeader = $('#'+tableId+'_header').outerHeight();
			 //Move the list header lower to allow for list table header
			 fixedHeader.css({top: heightOfListTableHeader});
			 fixedHeader.show();
			 //Add a class to the header so that it shows a header above the table
			 $('#'+tableId+'_header').addClass('scrollablelisttableheader');
			 $('#'+tableId+'_header').parent('td').innerHeight(heightOfListTableHeader+4);
			 
			 
			 //Make the widths of the table header and first row cells the same
			 headerRowCells = $('.scrollablelisttable thead .tableheaderrow').find('th');
			 $(".scrollablelisttable tbody tr:last").find('td').each(function (i, elem) {
				 $(headerRowCells[i]).width($(elem).width());
			 });
			 
			 //Remove the scrollable list table
			 var selectAllCheck = $('.scrollablelisttable thead #selectallbtn');
			 var selectLabel = selectAllCheck.closest('label');
			 selectLabel.remove();
			 selectAllCheck.replaceWith( "<div style='padding:9.5px;'></div>" );
    	}
	});

	//Automatically reload window everytime  the app window size is changed
	$(window).bind('resize',function(){
     	window.location.href = window.location.href;
	});
	
});




//For sorting tables
$(function() {
    var table = $('.scrollablelisttable');
    
    $('.sortcolumn')
        .wrapInner('<span title="Click to sort by this column"/>')
        .each(function(){
            
            var th = $(this),
                thIndex = th.index(),
                inverse = false;
            
			//Click the table header
            th.click(function(){
                
                table.find('td').filter(function(){
                    
                    return $(this).index() === thIndex;
                }).sortElements(function(a, b){
                    
                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    
                    // parentNode is the element we want to move
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
				
				//First remove all the sorting flags in the other columns
				$(this).parent('tr').children('th').not(this).children('.colspacer').remove();
				
				//Add a spacer div if it is not available yet
				if( $(this).children('div').length == 0 ) 
				{
					$(this).append("<div class='colspacer'></div>");
				}
				
				//Change the background class of the th when clicked
				if($(this).children('.colspacer').hasClass('descendingcolumn'))
				{
					$(this).children('.colspacer').removeClass('descendingcolumn').addClass('ascendingcolumn');
				}
				else if($(this).children('.colspacer').hasClass('ascendingcolumn'))
				{
					$(this).children('.colspacer').removeClass('ascendingcolumn').addClass('descendingcolumn');
				}
				else
				{
					$(this).children('.colspacer').addClass('ascendingcolumn');
				}
                    
            });
                
        });
});

