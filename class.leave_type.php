<?php
include_once "class.db_connect.php";
//decalration of attributes
class leave_type{
	private $id;
	private $leave_type;
	private $entitled;
	private $balance;
//getters and setters
	public function get_id(){return $this->id;}
	public function set_id($new_value){$this->id=$new_value;}
	public function get_leave_type(){return $this->leave_type;}
	public function set_leave_type($new_value){$this->leave_type=$new_value;}
	public function get_entitled(){return $this->entitled;}
	public function set_entitled($new_value){$this->entitled=$new_value;}
	public function get_balance(){return $this->balance;}
	public function set_balance($new_value){$this->balance=$new_value;}
//a method that gets the list of leave types from the database
//used to populate dropdowns in the query builder	
	public function get_leave_types(){
		$connection = dbconnect();
		$sql = $connection->query( "SELECT leave_type from leave_type");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		while($row=$sql->fetch()) {
			$new_array[] = $row;
		}
		return $new_array;
	}
//a method used to get the leave type of a particular employee.
// male and female employees get different leave types and so 
	//the selection is done by supplying the applicant id	
	public function get_leave_info($id){
		$connection = dbconnect();
		$sql = $connection->query( "SELECT e.Emp_id,lt.leave_id,lt.leave_type,lt.entitled,lb.balance from l_balance lb 
									left join leave_type lt on
									lb.leave_id=lt.leave_id
									left join employee e on
									e.Emp_Id=lb.Emp_Id
									Where e.Emp_Id='$id'
									");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		while($row=$sql->fetch()) {
			$this->set_id($row['leave_id']);
			$this->set_leave_type($row['leave_type']);
			$this->set_entitled($row['entitled']);
			$this->set_balance($row['balance']);

			$new_array[] = $row;
		}
		return $new_array;
	}    	
}
