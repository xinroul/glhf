//On every keystroke in the search field
$("#ticket_search").keyup(function(){
	//Get the search text
	let search_text = this.value;
	
	//For each ticket row
	$("#ticket_table tr:not(:first)").each(function(){
		//Set initial bool
		show_ticket = false;
		
		//Get array of each cell of the ticket row
		ticket_row = $(this).children("td");
		
		//For each field selected as per the checkboxes
		$(".search_checkbox").each(function(){			
			//Check if string exists for selected fields
			if($(this).is(":checked")){
				//If the string is found in a field
				if(new RegExp(search_text, "i").test(ticket_row[this.value].innerHTML)){
					show_ticket = true;
				}
			}
		});
		
		//Show/Hide accordingly
		if(show_ticket){
			$(this).show();
		}else{
			$(this).hide();
		}
	});
});