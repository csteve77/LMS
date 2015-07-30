<?php
include_once "class.db_connect.php";

class employee{
	//declaration of attributes
	private $emp_Id;
	private $name;
	private $surname;
	private $gender;
	private $pass;
	private $emp_level_id;
	private $user_level;

	//getters and setters. Since all attributes are declared as private
	//we need to make use of setters to change the values of the attributes
	//thus limiting access from the application layer
	public function set_emp_id($new_value){$this->emp_Id=$new_value;}
	public function get_emp_id(){return $this->emp_Id;}
	public function get_name(){return $this->name;}
	public function set_name($new_value){$this->name=$new_value;}
	public function get_surname(){return $this->surname;}
	public function set_surname($new_value){$this->surname=$new_value;}
	public function set_gender($new_value){$this->gender=$new_value;}
	public function get_gender(){return $this->gender;}
	public function set_pass($new_value){$this->pass=$new_value;}
	public function get_pass(){return $this->pass;}
	public function get_emp_level_id(){return $this->emp_level_id;}
	public function set_emp_level_id($new_value){$this->emp_level_id=$new_value;}
	public function get_user_level(){return $this->emp_level;}
	public function set_user_level($new_value){$this->emp_level=$new_value;}
	
	//gets employee details from the database and stores them in the object
	public function get_employee($id){
		$connection = dbconnect();
		$sql =$connection->query("  SELECT e.*, e_l.Emp_Level FROM employee e
									LEFT JOIN emp_level e_l
									ON e.Emp_Level_Id = e_l.Emp_Level_Id
									WHERE Emp_Id = '$id'");
		
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		while($row=$sql->fetch()){
			$this->set_name($row['name']);
			$this->set_surname($row['surname']);
			$this->set_gender($row['Gender_Id']);
			$this->set_emp_id($row['Emp_Id']);
			$this->set_emp_level_id($row['Emp_Level_Id']);
			$this->set_user_level($row['Emp_Level']);
		}    
	}
	
	//this method gets the list of employees. used to populate the employee drop down in the query builder
	public function all_employees(){
		$connection = dbconnect();
		$sql=$connection->query(   "SELECT Emp_Id from employee");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		while($row=$sql->fetchall()) {
			$new_array = $row;
		}
		return $new_array;
		
	}
}


