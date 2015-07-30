<?php
include_once "class.db_connect.php";
//declaration of attributes as private
class new_application{
	private $emp_id;
	private $appli_date;
	private $appli_id;
	private $leave_id;
	private $state_id;
	
	private $leave_starts;
	private $leave_ends;
	private $comments;
	private $num_hours;

	private $leave_type;
	private $state;
	
	//the object is constructed by using the object construct which constrains the application to provide all 
	//attributes for teh object to be sucessfully created
	public function __construct($emp_id,$appli_date,$leave_id,$state_id,$leave_starts,$leave_ends,$comments,$num_hours){
		$this->emp_id=$emp_id;
		$this->appli_date=$appli_date;
		$this->leave_id=$leave_id;
		$this->state_id=$state_id;
		$this->leave_starts=$leave_starts;
		$this->leave_ends=$leave_ends;
		$this->comments=$comments;
		$this->num_hours=$num_hours;
		$values=$this->check_exists($this->emp_id,$this->leave_starts,$this->leave_ends);
		//calls a method to see if the user has already applied for leave on the requested dates
		if ( $values == false){//depending on the result obtained from the method, a message is displayed
			$this->application($this->emp_id,$this->appli_date,$this->leave_id,$this->state_id,$this->leave_starts,$this->leave_ends,$this->comments,$this->num_hours);
			echo "	<div id='overlayDiv2'>
						<div id='confirm2'>
							<h3>Message !</h3>
							<p>Application submitted succesfully</p>
							<div class='okCancel' >
								<div class='button' id='cancelled2'>Ok</div>
							</div>
						</div>
					</div>
					"; 
		}else{
			echo "	<div id='overlayDiv2'>
						<div id='confirm2'>
							<h3>Message !</h3>
							<p>You already have booked leave on those dates</p>
							<div class='okCancel' >
								<div class='button' id='cancelled2'>Ok</div>
							</div>
						</div>
					</div>
					"; 


	}
}

/*public function get_emp_id(){return $this->emp_id;}
public function get_appli_date(){return $this->appli_date;}
public function get_leave_id(){return $this->leave_id;}
public function get_leave_starts(){return $this->leave_starts;}
public function get_leave_ends(){return $this->leave_ends;}
public function get_comments(){return $this->comments;}
public function get_num_hours(){return $this->num_hours;}

public function set_emp_id($new_value){$this->emp_id=$new_value;}
public function set_appli_date($new_value){$this->appli_date=$new_value;}
public function set_leave_id($new_value){$this->leave_id=$new_value;}
public function set_leave_starts($new_value){$this->leave_starts=$new_value;}
public function set_leave_ends($new_value){$this->leave_ends=$new_value;}
public function set_comments($new_value){$this->comments=$new_value;}
public function set_num_hours($new_value){$this->num_hours=$new_value;}

public function set_appli_id($new_value){$this->appli_id=$new_value;}
public function set_leave_type($new_value){$this->leave_type=$new_value;}
public function set_state($new_value){$this->state=$new_value;}
*/
//a method that persists the application into the database
public function application($id,$a_d,$l_i,$s_i,$l_s,$l_e,$c,$n_h){
	$connection = dbconnect();
	$sql=$connection->prepare("INSERT INTO initial_application
		(Emp_Id,Appli_Date,leave_id,state_id,leave_starts,leave_ends,Comments,num_hours)
		VALUES
		('$id','$a_d','$l_i','$s_i','$l_s','$l_e','$c','$n_h');"
		);
	$sql->execute();
	$out=dbout($connection);
}
//the method that checks if the applicant has already booked leave on the requested dates
public function check_exists($id,$l_s,$l_e){
	$connection = dbconnect();
	$sql=$connection->query(   "SELECT Appli_id from initial_application 
		where Emp_id= '$id'
		and state_id not in ('5','4')
		and (leave_starts between '$l_s' AND '$l_e' OR leave_ends between '$l_s' AND '$l_e')
		");
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$row=$sql->fetch();
	if($row['Appli_id']==""){
		return false;
	}else{
		return true;
	}
}    	


}

