<?php
include_once "class.db_connect.php";
//declaration of attributes
class application{
	private $emp_id;
	private $name;
	private $surname;
	private $appli_date;
	private $appli_id;
	private $leave_id;
	private $state_id;
	private $scd;
	private $leave_starts;
	private $leave_ends;
	private $comments;
	private $num_hours;
	private $leave_type;
	private $state;
	private $approver;
//getters and setters
	public function set_emp_id($new_value){$this->emp_id=$new_value;}
	public function set_appli_date($new_value){$this->appli_date=$new_value;}
	public function set_scd($new_value){$this->scd=$new_value;}
	public function set_leave_starts($new_value){$this->leave_starts=$new_value;}
	public function set_leave_ends($new_value){$this->leave_ends=$new_value;}
	public function set_comments($new_value){$this->comments=$new_value;}
	public function set_num_hours($new_value){$this->num_hours=$new_value;}
	public function set_approver($new_value){$this->approver=$new_value;}

	public function set_appli_id($new_value){$this->appli_id=$new_value;}
	public function set_leave_type($new_value){$this->leave_type=$new_value;}
	public function set_leave_id($new_value){$this->leave_id=$new_value;}
	public function set_state($new_value){$this->state=$new_value;}


//a method that uses a query to get the list of approved applications for the current user
		public function get_state_appli($id, $state){
		$connection = dbconnect();
		$sql=$connection->query("	SELECT i_a.Emp_Id, i_a.Appli_id, i_a.Appli_Date,i_a.leave_id,l_t.leave_type,i_a.state_id,a_s.state,i_a.leave_starts,i_a.leave_ends,i_a.num_hours,i_a.comments    
										FROM initial_application i_a
										left join leave_type l_t on 
										i_a.leave_id = l_t.leave_id
										left join appli_state a_s on
										i_a.state_id = a_s.state_id
										WHERE i_a.Emp_Id='$id' 
										AND i_a.state_id='$state'
										ORDER BY  i_a.Appli_id
									");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
			while($row=$sql->fetch()){
		       	$this->set_emp_id($row['Emp_Id']);
	        	$this->set_appli_id($row['Appli_id']);
	        	$this->set_appli_date($row['Appli_Date']);
	        	$this->set_leave_type($row['leave_type']);
	        	$this->set_state($row['state']);
	        	$this->set_leave_starts($row['leave_starts']);
	        	$this->set_leave_ends($row['leave_ends']);
	        	$this->set_comments($row['comments']);
	        	$this->set_num_hours($row['num_hours']);
	        	$new_array[] = $row;
			}
		return $new_array;
	}


//this method is used to return the list of applications depending on the parameters passed. 
	//this is used to populate the denied, approved lists in the admin screen
	public function get_all_states($id,$state){
		$connection = dbconnect();
		$sql=$connection->query("	SELECT i_a.Emp_Id,e.name,e.surname, i_a.Appli_id, i_a.Appli_Date,i_a.leave_id,l_t.leave_type,i_a.state_id,a_s.state,i_a.leave_starts,i_a.leave_ends,i_a.num_hours,i_a.comments,a_h.Approved_by    
										from initial_application i_a 
										left join employee e on (i_a.Emp_id = e.Emp_Id)
										left join leave_type l_t on(i_a.leave_ID=l_t.leave_id)
										left join appli_state a_s on (i_a.state_id=a_s.state_id)
										left join application_history a_h on (i_a.Appli_id = a_h.Appli_id)
										where i_a.state_id='$state'
										and i_a.Emp_id !='$id'
										and i_a.leave_ends>CURDATE()
										order by i_a.Appli_Id
									");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		    while($row=$sql->fetch()){
		       	$this->set_emp_id($row['Emp_Id']);
		       	$this->set_emp_id($row['name']);
		       	$this->set_emp_id($row['surname']);
	        	$this->set_appli_id($row['Appli_id']);
	        	$this->set_appli_date($row['Appli_Date']);
	        	$this->set_leave_type($row['leave_type']);
	        	$this->set_leave_id($row['leave_id']);
	        	$this->set_state($row['state']);
	        	$this->set_leave_starts($row['leave_starts']);
	        	$this->set_leave_ends($row['leave_ends']);
	        	$this->set_comments($row['comments']);
	        	$this->set_num_hours($row['num_hours']);
	        	$this->set_approver($row['Approved_by']);
	        	$new_array[] = $row;
			}
		return	$new_array;
	}


//when called this method, changes the state of an application from pending to approved
	public function approve_app( $Appli_id,$approver_id){
		$connection = dbconnect();
		$sql=$connection->query("SELECT leave_id, Emp_id
								 FROM initial_application
								 WHERE Appli_id=$Appli_id");
		$row=$sql->fetch();
		$leaveID=$row['leave_id'];
		$Emp_id=$row['Emp_id'];

		$sql2=$connection->query("CALL approve_application('$leaveID','$Appli_id','$approver_id','$Emp_id')");
		$sql2->exec();
		echo "successfully approved";
	}
//when called this method changes the state of an application from pending to denied
	public function deny_app($Appli_id,$approver_id){
		$connection = dbconnect();
		$sql=$connection->query("CALL deny_application('$Appli_id','$approver_id')");
		$sql->execute();
		echo "successfully denied";
	}
//when called this method changes the state of an application from pending to cancelled
	public function cancel_app($Appli_id){
		$connection = dbconnect();
		$sql=$connection->query("SELECT leave_id, Emp_id
								 FROM initial_application
								 WHERE Appli_Id=$Appli_id");
		$row=$sql->fetch();
		$leaveID=$row['leave_id'];
		$Emp_id=$row['Emp_id'];

		$sql2=$connection->query("CALL cancel_application('$Appli_id','$Emp_id','$leaveID')");
		$sql2->execute();
		echo $leaveID." ".$Emp_id;

	}
//this method gets the list of application states to populate a drop down box
	public function states(){
		$connection = dbconnect();
		$sql=$connection->query(   "SELECT state from appli_state");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
	   	while($row=$sql->fetchall()) {
	    	$new_array = $row;
	    }
	    return $new_array;
	}
//this method gets the list of sexes to populate a drop down box

	public function gender(){
		$connection = dbconnect();
		$sql=$connection->query(   "SELECT Gender from gender");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
	   	while($row=$sql->fetchall()) {
	    	$new_array = $row;
	    }
	    return $new_array;
	}
//this method gets the list of applications to populate a drop down box

	public function appli(){
		$connection = dbconnect();
		$sql=$connection->query(   "SELECT Appli_Id from initial_application order by Appli_Id asc");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
	   	while($row=$sql->fetchall()) {
	    	$new_array = $row;
	    }
	    return $new_array;
	}
}



	

