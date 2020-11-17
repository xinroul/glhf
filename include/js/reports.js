$("#generate_report").click(function(){
	let staff_id = $("#staff_select :selected").val();
	let start_date = $("#start_date").val();
	let end_date = $("#end_date").val();
	
	generate_report(staff_id, start_date, end_date);
});

/*
	Generates the report

	@param string	(Staff ID)
	@param string	(Start Date)
	@param string	(End Date)
*/
function generate_report(staff_id, start_date = null, end_date = null){	
	$.ajax({
		url: "generate_report.php",
		type: "POST",
		datatype: "JSON",
		data: {
			"staff_id": staff_id,
			"start_date": start_date,
			"end_date": end_date,
		},
		success: function(data){
			data = JSON.parse(data);
			console.log(data);
			//Update if the field does not exist
			if(!("unassigned" in data)){
				data['unassigned'] = 0;
			}
			
			if(!("assigned" in data)){
				data['assigned'] = 0;
			}
			
			if(!("pending" in data)){
				data['pending'] = 0;
			}
			
			if(!("resolved" in data)){
				data['resolved'] = 0;
			}
			
			if(!("closed" in data)){
				data['closed'] = 0;
			}
			
			if(!("invalid" in data)){
				data['invalid'] = 0;
			}
			
			//Update the report area
			$("#staff_report").html(
				"<table class='basic_table' style='border-collapse:collapse;'>" +
					"<tr>" +
						"<td colspan='2'>" + ((staff_id == 0) ? "Total" : staff_map[staff_id]) + "</td>" +
					"</tr>" +
					"<tr>" +
						"<td style='text-align:left;'>Total unassigned</td>" +
						"<td style='text-align:center;'>" + data['unassigned'] + "</td>" +
					"</tr>" +
					"<tr>" +
						"<td style='text-align:left;'>Total active</td>" +
						"<td style='text-align:center;'>" + data['assigned'] + "</td>" +
					"</tr>" +
					"<tr>" +
						"<td style='text-align:left;'>Total pending</td>" +
						"<td style='text-align:center;'>" + data['pending'] + "</td>" +
					"</tr>" +
					"<tr>" +
						"<td style='text-align:left;'>Total resolved</td>" +
						"<td style='text-align:center;'>" + data['resolved'] + "</td>" +
					"</tr>" +
					"<tr>" +
						"<td style='text-align:left;'>Total duplicates</td>" +
						"<td style='text-align:center;'>" + data['closed'] + "</td>" +
					"</tr>" +
					"<tr>" +
						"<td style='text-align:left;'>Total invalid</td>" +
						"<td style='text-align:center;'>" + data['invalid'] + "</td>" +
					"</tr>" +
					"<tr>" +
						"<td style='text-align:left;'>Total tickets</td>" +
						"<td style='text-align:center;'>" + data['total'] + "</td>" +
					"</tr>" +
				"</table>"
			);
			
			if("developers" in data && "reviewers" in data){
				let dev_table = 
					"<br />" +
					"<br />" +
					"<table class='basic_table' style='border-collapse:collapse;'>" +
						"<tr>" +
							"<td style='text-align:center;'>Developer</td>" +
							"<td style='text-align:center;'>Assigned</td>" +
							"<td style='text-align:center;'>Pending</td>" +
							"<td style='text-align:center;'>Resolved</td>" +
						"</tr>";
				
				//For each developer
				$.each(data['developers'], function(dev, details){
					if(!("assigned" in data['developers'][dev])){
						data['developers'][dev]['assigned'] = 0;
					}
					
					if(!("pending" in data['developers'][dev])){
						data['developers'][dev]['pending'] = 0;
					}
					
					if(!("resolved" in data['developers'][dev])){
						data['developers'][dev]['resolved'] = 0;
					}
					
					dev_table += 
						"<tr>" +
							"<td style='text-align:center;'>" + staff_map[dev] + "</td>" +
							"<td style='text-align:center;'>" + data['developers'][dev]['assigned'] + "</td>" +
							"<td style='text-align:center;'>" + data['developers'][dev]['pending'] + "</td>" +
							"<td style='text-align:center;'>" + data['developers'][dev]['resolved'] + "</td>" +
						"</tr>";
				});
				
				dev_table += "</table>";
				
				$("#staff_report").append(dev_table);
				
				let rev_table = 
					"<br />" +
					"<br />" +
					"<table class='basic_table' style='border-collapse:collapse;'>" +
						"<tr>" +
							"<td style='text-align:center;'>Reviewer</td>" +
							"<td style='text-align:center;'>Pending</td>" +
							"<td style='text-align:center;'>Resolved</td>" +
						"</tr>";
				
				//For each developer
				$.each(data['reviewers'], function(rev, details){
					
					if(!("pending" in data['reviewers'][rev])){
						data['reviewers'][rev]['pending'] = 0;
					}
					
					if(!("resolved" in data['reviewers'][rev])){
						data['reviewers'][rev]['resolved'] = 0;
					}
					
					rev_table += 
						"<tr>" +
							"<td style='text-align:center;'>" + staff_map[rev] + "</td>" +
							"<td style='text-align:center;'>" + data['reviewers'][rev]['pending'] + "</td>" +
							"<td style='text-align:center;'>" + data['reviewers'][rev]['resolved'] + "</td>" +
						"</tr>";
				});
				
				rev_table += "</table>";
				
				$("#staff_report").append(rev_table);
				
				
			}
		}
	});
}