$(document).ready(function(){
	$('#menu a').each(function(index) {
		if(this.href.trim() == window.location)
			$(this).addClass("current_pos");
	});
	
	//calls the controller that gets list of pending applications from the database for the current employee
	$.getJSON("../controllers/pending_all.php", function(pending){
		for (var i=0; i<pending.length; i++){
			var divId=pending[i]['Appli_id'];
			var leaveId=pending[i]['leave_id'];
			var empId=pending[i]['Emp_Id'];
			var tr='<tr>';
			tr +='<td>' + pending[i]['Appli_id'] +'</td>';
			tr +='<td>' + pending[i]['Appli_Date'] +'</td>';
			tr +='<td>' + pending[i]['name'] +'</td>';
			tr +='<td class="employee_id" id="'+empId+'">' + pending[i]['surname'] +'</td>';
			tr +='<td class="leave_id" id="'+leaveId+'">' + pending[i]['leave_type'] +'</td>';
			tr +='<td>' + pending[i]['leave_starts'] +'</td>';
			tr +='<td>' + pending[i]['leave_ends'] +'</td>';
			tr +='<td>' + pending[i]['num_hours']/8 +'</td>';
			tr +='<td>' + pending[i]['comments'] +'</td>';
			tr +='<td><div class="grant" title="Approve this application" id="' + divId +'">Approve</div></td>';
			tr +='<td><div class="deny" title="Deny this application" id="' + divId +'">Deny</div></td>';
			tr +='</tr>';
			$('#pending_applications').append(tr);
		}
	});

//calls the controller that gets list of denied applications from the database for the current employee
$.getJSON("../controllers/denied_all.php", function(denied){
	for (var i=0; i<denied.length; i++){
		var divId=denied[i]['Appli_id'];
		var leaveId=denied[i]['leave_id'];
		var empId=denied[i]['Emp_Id'];
		var tr='<tr>';
		tr +='<td>' + denied[i]['Appli_id'] +'</td>';
		tr +='<td>' + denied[i]['Appli_Date'] +'</td>';
		tr +='<td>' + denied[i]['name'] +'</td>';
		tr +='<td class="employee_id" id="'+empId+'">' + denied[i]['surname'] +'</td>';
		tr +='<td class="leave_id" id="'+leaveId+'">' + denied[i]['leave_type'] +'</td>';
		tr +='<td>' + denied[i]['leave_starts'] +'</td>';
		tr +='<td>' + denied[i]['leave_ends'] +'</td>';
		tr +='<td>' + denied[i]['num_hours']/8 +'</td>';
		tr +='<td>' + denied[i]['comments'] +'</td>';
		tr +='<td>' + denied[i]['Approved_by'] +'</td>';
		tr +='</tr>';
		$('#denied_applications').append(tr);
	}
});

//calls the controller that gets list of approved applications from the database for the current employee
$.getJSON("../controllers/approved_all.php", function(approved){
	for (var i=0; i<approved.length; i++){
		var divId=approved[i]['Appli_id'];
		var leaveId=approved[i]['leave_id'];
		var empId=approved[i]['Emp_Id'];
		var appli_id=approved[i]['Appli_id'];
		var tr='<tr>';
		tr +='<td class="appliId" id="' + appli_id + '">' + approved[i]['Appli_id'] +'</td>';
		tr +='<td>' + approved[i]['Appli_Date'] +'</td>';
		tr +='<td>' + approved[i]['name'] +'</td>';
		tr +='<td class="employee_id" id="'+empId+'">' + approved[i]['surname'] +'</td>';
		tr +='<td class="leave_id" id="'+leaveId+'">' + approved[i]['leave_type'] +'</td>';
		tr +='<td>' + approved[i]['leave_starts'] +'</td>';
		tr +='<td>' + approved[i]['leave_ends'] +'</td>';
		tr +='<td>' + approved[i]['num_hours']/8 +'</td>';
		tr +='<td>' + approved[i]['comments'] +'</td>';
		tr +='<td>' + approved[i]['Approved_by'] +'</td>';
		tr +='</tr>';
		$('#approved_applications').append(tr);
	}
});

$.getJSON("../controllers/nextweek.php",function(ppl){
	$('#nextWeekVal').html(ppl['people'])
});//calls a controller to get the count of people on leave next week

$.getJSON("../controllers/today.php",function(ppl){
	$('#todayVal').html(ppl['People'])
});//calls a controller to get the count of people on leave today

$.getJSON("../controllers/tomorrow.php",function(ppl){
	$('#tomorrowVal').html(ppl['People'])
});//calls a controller to get the count of people on leave tomorrow

$.getJSON("../controllers/employee_list.php",function(id){
	for (var i=0; i<id.length; i++){
		$('#id').append($('<option>').html(id[i]['Emp_Id']));
	}//calls a controller to get the list of employees for the query builder
});

$.getJSON("../controllers/l_types.php",function(type){
	for (var i=0; i<type.length; i++){
		$('#types').append($('<option>').html(type[i]['leave_type']));
	}//calls a controller to get the list of leave_types for the query builder
});
$.getJSON("../controllers/a_states.php",function(state){
	for (var i=0; i<state.length; i++){
		$('#states').append($('<option>').html(state[i]['state']));
	}//calls a controller to get the list of application states for the query builder
});
$.getJSON("../controllers/genders.php",function(gender){
	for (var i=0; i<gender.length; i++){
		$('#gender').append($('<option>').html(gender[i]['Gender']));
	}//calls a controller to get the list of sexes for the query builder
});
$.getJSON("../controllers/application_list.php",function(application){
	for (var i=0; i<application.length; i++){
		$('#Appli_id').append($('<option>').html(application[i]['Appli_Id']));
	}//calls a controller to get the list of applications for the query builder
});
});

$(".grant").live("click",function(event){
	$.post("../controllers/grant_controller.php",{'Appli_id' : event.target.id, 'Approver_id' : $('#user_id').html()}, function(){
		location.href = location.pathname;
		//calls the controller that grants a particular application
	})
});

$(".deny").live("click",function(event){
	$.post("../controllers/deny_controller.php",{'Appli_id' : event.target.id, 'Approver_id' : $('#user_id').html() }, function(){
		location.href = location.pathname;
		//calls the controller that denies a particular application

	})
});

$(function() {
	$( ".datepicker" ).datepicker({dateFormat: 'yy/m/d'});
	//create a datepicker for the query builder
});

