
$(document).ready(function(){

	$('.tooltip').hover(function(){
	// Hover over code
	var title = $(this).attr('title');//gets the text from the title attribute of each element
	$(this).data('tipText', title).removeAttr('title');//removes the title attribute from the element
	$('<p class="tooltips"></p>')//assigns the class attribute to the p tag element
	.text(title)//and adds the text to this attribute
	.appendTo('body')//appends it to the body element
	.fadeIn('slow');//effect
	}, function() {
	// Hover out code
	$(this).attr('title', $(this).data('tipText'));
	$('.tooltips').remove();//hides the tooltip
	}).mousemove(function(e) {//
	var posx = e.pageX - 250; //Get X coordinates
	var posy = e.pageY + 30; //Get Y coordinates
	$('.tooltips').css({ top: posy, left: posx })//animate the tooltip
	});

	$('#error').hide();//ensure that no error message are visible
	$('#days').hide();//the number of days should eb hidden as well on page load

	$.getJSON("../controllers/leave_types.php",function(type){
		for (var i=0; i<type.length; i++){
			$('#type').append($('<option>').html(type[i]['leave_id']+ " "+type[i]['leave_type']));
		}//calls the controller to populate the dropdown for leave types
		$('#entitled').html((type[0]['entitled']/8));//sets the value of the first option with first value from database
		$('#balance').html((type[0]['balance']/8));//same for entitled

	});

	//calls the controller that gets list of pending applications from the database for the current employee
	$.getJSON("../controllers/pending_applications.php", function(pending){//the result is stored in the array called pending
		for (var i=0; i<pending.length; i++){//data from the array is read and used to populate the table in the accordion
			var divId=pending[i]['Appli_id'];//a button is created near each application so that an employee can cancel the application
			var tr='<tr>';
			tr +='<td><div class="del" title="Delete this application" id="' + divId +'">-</div></td>';
			tr +='<td>' + pending[i]['Appli_id'] +'</td>';
			tr +='<td>' + pending[i]['Appli_Date'] +'</td>';
			tr +='<td>' + pending[i]['leave_type'] +'</td>';
			tr +='<td>' + pending[i]['state'] +'</td>';
			tr +='<td>' + pending[i]['leave_starts'] +'</td>';
			tr +='<td>' + pending[i]['leave_ends'] +'</td>';
			tr +='<td>' + pending[i]['num_hours']/8 +'</td>';
			tr +='<td>' + pending[i]['comments'] +'</td>';
			tr +='</tr>';
			$('#pending').append(tr);
		}
	});	

	//calls the controller that gets list of denied applications from the database for the current employee
	$.getJSON("../controllers/denied_applications.php", function(denied){//the result is stored in the array called denied
		for (var i=0; i<denied.length; i++){
			var tr='<tr>';//data from the array is read and used to populate the table in the accordion
			tr +='<td>' + denied[i]['Appli_id'] +'</td>';
			tr +='<td>' + denied[i]['Appli_Date'] +'</td>';
			tr +='<td>' + denied[i]['leave_type'] +'</td>';
			tr +='<td>' + denied[i]['state'] +'</td>';
			tr +='<td>' + denied[i]['leave_starts'] +'</td>';
			tr +='<td>' + denied[i]['leave_ends'] +'</td>';
			tr +='<td>' + denied[i]['num_hours']/8 +'</td>';
			tr +='<td>' + denied[i]['comments'] +'</td>';
			tr +='</tr>';
			$('#denied').append(tr);
		}
	});	

	//calls the controller that gets list of approved applications from the database for the current employee
	$.getJSON("../controllers/approved_applications.php", function(approved){
		for (var i=0; i<approved.length; i++){
			var divId=approved[i]['Appli_id'];
			var tr='<tr>';
			tr +='<td><div class="del" title="Cancel this application" id="' + divId +'">-</div></td>';
			tr +='<td>' + approved[i]['Appli_id'] +'</td>';
			tr +='<td>' + approved[i]['Appli_Date'] +'</td>';
			tr +='<td>' + approved[i]['leave_type'] +'</td>';
			tr +='<td>' + approved[i]['state'] +'</td>';
			tr +='<td>' + approved[i]['leave_starts'] +'</td>';
			tr +='<td>' + approved[i]['leave_ends'] +'</td>';
			tr +='<td>' + approved[i]['num_hours']/8 +'</td>';
			tr +='<td>' + approved[i]['comments'] +'</td>';
			tr +='</tr>';
			$('#approved').append(tr);
		}
	});

	//calls the controller that gets list of cancelled applications from the database for the current employee
	$.getJSON("../controllers/cancelled_applications.php", function(cancelled){
		for (var i=0; i<cancelled.length; i++){
			var tr='<tr>';
			tr +='<td>' + cancelled[i]['Appli_id'] +'</td>';
			tr +='<td>' + cancelled[i]['Appli_Date'] +'</td>';
			tr +='<td>' + cancelled[i]['leave_type'] +'</td>';
			tr +='<td>' + cancelled[i]['state'] +'</td>';
			tr +='<td>' + cancelled[i]['leave_starts'] +'</td>';
			tr +='<td>' + cancelled[i]['leave_ends'] +'</td>';
			tr +='<td>' + cancelled[i]['num_hours']/8 +'</td>';
			tr +='<td>' + cancelled[i]['comments'] +'</td>';
			tr +='</tr>';
			$('#cancelled').append(tr);
		}
	});

	//creates the start_date datepicker on pageload
	$(function() {
		$( "#start_date" ).datepicker({
			//sets the date format and disables weekends
			beforeShowDay: $.datepicker.noWeekends, dateFormat: 'yy/m/d',
		});
	});

	//creates the end_date datepicker on pageload
	$(function() {
		$( "#end_date" ).datepicker({//sets the date format and disables weekends
			beforeShowDay: $.datepicker.noWeekends, dateFormat: 'yy/m/d',
		});
	});

	//create the accordion on pageload
	$(function() {
		$( "#info" ).accordion({collapsible: true, active:false});
	});

	
	/*when the leave type dropdown changes value, it calls the controller again to get the 
	required information for the selected leave type and populates the entitled and balance 
	labels with the new information*/
	$("#type").change(function(){
		var selected = $('#type option:selected').val();
		selected=selected.substr(2,50);
		$.getJSON("../controllers/leave_types.php",function(result){
			for(var i=0;i<result.length;i++){
				var value=result[i]['leave_type'];
				if (value==selected){
					$('#entitled').html((result[i]['entitled']/8));
					$('#balance').html((result[i]['balance']/8));
				}
			}
		});
		$('#start_date').val('');//resets the start and end date and number of days
		$('#end_date').val('');
		$('#days').html('');	
	});

	//this function is triggered when a start date is selected
	$('#start_date').change(function(){
		var start="#start_date";//assigns a datepicker object to a variable called start
		var date1=$(this).datepicker('getDate');//get the date selected from this datepicker
		var month=$(this).datepicker('getDate').getMonth();//get the month of the selected date
		var year= $(this).datepicker('getDate').getFullYear();//get the year of teh selected date
		var endDate=new Date(year,month,01);//use the obtained values to set the second datepicker to the same month and year
		var date2=$('#end_date').datepicker('option','defaultDate', endDate);
		checkfuture(date1,start);//call a function to ensure that date selected is not in the past
		var startVal=$('#start_date').val();
		var endVal=$('#end_date').val();
		if(startVal !=="" && endVal !==""){//check to see that the next function is not called with empty dates
			var notBigger=checkbigger(date1,date2,startVal);//calls a function to see that that date 2 comes after 
			//date 1 and assign the returned value to a variable notBigger
			if(notBigger){//if notbigger= true
				remove_Weekends(date1,date2);//call a function to check if weekends occur in the selected date range and 
				//if they do subtract the number of days that fall on weekends	
			}
		}
	});
	//this function is triggered when end date is selected
	$('#end_date').change(function(){
		var end="#end_date";
		var date1=$("#start_date").datepicker('getDate');//get the selected date
		var date2=$(this).datepicker('getDate');
		var check=checkfuture(date2,end);//check that the date selected is not in the past
		var startVal=$('#start_date').val();//get the selected start date value
		var endVal=$('#end_date').val();//get the selected end date value
		if(startVal !=="" && endVal !==""){//ensure that neither date is empty
			var notBigger=checkbigger(date1,date2,endVal);//calls a function to see that that date 2 comes after 
			//date 1 and assign the returned value to a variable notBigger
			if(notBigger){//if notbigger= true
				remove_Weekends(date1,date2);	//call a function to check if weekends occur in the selected date range and 
				//if they do subtract the number of days that fall on weekends	
			}
		}


	});
	//This function is triggered when the apply button is clicked
	$('#apply').click(function(){
		var start=$('#start_date').val();//get values of start date and end date
		var end=$('#end_date').val();
		if(start!=="" && end!==""){//if both dates are selected display a message to confirm
			var titles="Please Confirm !"
			var message="Your application is pending approval. Details about this application will be shown on the right under Pending Applications. Press Ok to submit or Cancel to review your information";
			$('#overlayDiv').show();
			$('#Titles').html(titles);
			$('#message').text(message);
			$('#cancelled span').text("Cancel");
			$('#ok').show();
			$('#cancelled span').show();
			$('#confirm').fadeIn("slow");

		}else{
			var titles="Error!"//else if not both dates are selected, display an error message
			var message="Please ensure that both dates are selected";
			$('#overlayDiv').show();
			$('#Titles').html(titles);
			$('#message').text(message);
			$("#ok").hide();
			$('#cancelled span').text('Ok');
			$('#confirm').fadeIn("slow");

		}


	})//when the cancel button is clicked, the idv and the message are hidden
	$('#cancelled span').click(function(){
		$('#confirm').hide();
		$('#overlayDiv').hide();
	})

	$('#cancelled2').click(function(){
		$('#confirm2').remove();
		$('#overlayDiv2').hide();
	})
	//when the ok button is clicked the request form is submitted
	$("#ok").click(function(){
		$('#request').submit();
	})
//when a cancel button is clicked, a controller is called to cancel the selected application
	$(".del").live("click",function(event){
		$.post("../controllers/cancel_application.php",{'Appli_id' : event.target.id }, function(data){
	//create message screen are you sure you want to cancel?
		})
	location.href = location.pathname;//this line refreshes the page so that the data is repopulated after the ajax call	
	});
});

function checkfuture(date,picker){//the function that checks if dates are in the future
	var now = new Date();//gets todays date
	if (date < now) {//if selected date is smaller than now
		$(picker).val('');//reset the calendar
		$('#error').html("Dates in the past are not allowed");//displays an error
		$('#error').fadeIn("slow");
		return false;//return false as result of the function call
	}else if (date > now) {
		$('#error').hide();//once corrected the function is called again and the error disappears
		return true;//return true as result of teh function call
	}
}

function checkbigger(date1,date2,picker){//function that checks that start date is bigger than end_date
	var diff= (date2-date1);//calculate the difference between both dates
	var days= parseInt(diff/1000/60/60/24);//calculate the difference as number of days
	//(date difference was in miliseconds before conversion)
	if (days < 0){//a negative value indicates that an end date earlier than start date was selected
		$(picker).val('');//resets the calendar
		$('#error').html("End date should be after start date");//show an error
		$('#end_date').val('');
		$('#error').fadeIn("slow");
		$('#days').hide();
		return false;//return false a s reult of teh function call
	}else if(days==0){//if difference between start date and end date is equal to 0, 
		//it means that the same day was selected. This means that the user applied for one day leave
		$('#error').hide();//if corrected, the error disappears
		$('#days').html((days +1));//we correct the display to show 1 instead of 0
		$('input:hidden').val(days+1);//we pass the value to a hidden element to be saved in the database
		$('#days').show();
		return true;
	}else{
		$('#error').hide();//if diff is greater than 0 we still have to add 1 because dates should be inclusive of selected dates
		$('#days').html((days +1));
		// var numdays=$('#days').html();
		return true;	
	}
}

function remove_Weekends(date1, date2){
	var diff= (date2-date1);//calculate the difference between start and end dates
	var days= parseInt(diff/1000/60/60/24);//calculate the number of days
	var weDays = 0;
	while(date1 < date2){//a loop that runs while date1 is smaller than date2
		date1.setDate(date1.getDate() + 1);//add 1 day to date1 with each iteration
		if(date1.getDay() === 0 || date1.getDay() === 6){//after incrementing date1, check that the date 
			//obtained is either a saturday or a sunday
			++weDays ;//if date1 is a sturday or a sunday, wedays is incremented by 1
		}
	}
	$('#days').html((days-weDays)+1);//the value of days is calculated by subtracting the number of weekends from the 
	//initial difference and add 1 to include both start date and end date
var numdays=parseInt($('#days').html());//converts the object to string
check_balance(numdays);//call a new function to check that the user has enough balance for the required 
//application with the number of days requested

}

function check_balance(numdays){
	var balance= parseInt($('#balance').html());//get the value of balance from the label which was populated from teh database
	numdays= parseInt(numdays);

	//console.log("numdays= " +numdays); checks to see if calculations are correct
	//console.log("balance= " +balance);
	if(balance < numdays){//if balance is smaller than the number of days requested an error is shown
		$('#end_date').val('');
		$('#error').html("You are asking for more than you have !!");
		$('#error').fadeIn('slow');
		$('#days').html('');
		numdays=null;
	}else{//else the error is hidden
		$('#error').hide();
		$('input:hidden').val(numdays);
		$('#days').show();
	}
}
