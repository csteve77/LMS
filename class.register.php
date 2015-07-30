<?php
include_once "class.db_connect.php";

//declaration of attributes

class register{
	private $emp_id;
    private $name;
    private $surname;
	private $password;
	private $gender;
	private $level;
//getters and setters
	public function get_emp_id(){return $this->emp_id;}
	public function set_emp_id($new_value){ $this->emp_id=$new_value;}
    public function get_name(){return $this->name;}
    public function set_name($new_value){ $this->name=$new_value;}
    public function get_surname(){return $this->surname;}
    public function set_surname($new_value){ $this->surname=$new_value;}
   	public function get_password(){return $this->password;}
    public function set_password($new_value){ $this->password=$new_value;}
	public function get_gender(){return $this->gender;}
    public function set_gender($new_value){ $this->gender=$new_value;}
	public function get_level(){return $this->gender;}
    public function set_level($new_value){ $this->level=$new_value;}
//a method that queries the database to see if a user with the same ID exists in the database and returns a value accordingly	
	public function checkExists($id,$name,$surname,$pass,$gender,$level){
		$connection = dbconnect();
		$sql=$connection->query("SELECT * FROM EMPLOYEE WHERE Emp_id='$id'");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$row=$sql->fetch();
		
		if (!empty($row)){
			dbout($connection);
			return 1;
		}
		else
		{
			dbout($connection);
			return 0;
		}
	
	}
//a method used to persist a new employee into the database
	public function register_employee($emp_id,$name,$surname,$password,$gender,$level){
		$connection = dbconnect();
		$sql =$connection->prepare("INSERT INTO Employee(Emp_Id,name,surname,Pass,Gender_Id,Emp_Level_Id) values('$emp_id','$name','$surname','$password','$gender','$level')");
		$sql->execute();
		$out=dbout($connection);
	}
}
