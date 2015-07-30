<?php
include_once "class.db_connect.php";
//declaration of attributes
class login {
	private $emp_id;
	private $password;
	private $level_id;
//getters and setters
	public function get_emp_id(){return $this->emp_id;}
	public function set_emp_id($new_value){$this->emp_id=$new_value;}
	public function get_password(){return $this->password;}
	public function set_password($new_value){$this->password=$new_value;}
	public function get_level_id(){return $this->level_id;}
	public function set_level_id($new_value){$this->level_id=$new_value;}
//a method that checks whether a user is actually registered or not	
	public function verify_login($emp_id,$password){
		$connection = dbconnect();
		$sql=$connection->query("SELECT * FROM EMPLOYEE WHERE Emp_id='$emp_id' AND pass='$password'");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$row=$sql->fetch();
//if a user, with the supplied credentials is not found the session is destroyed and the login screen is shown again
		if (empty($row)){
			session_unset();
			session_destroy();
			return;
			
//else the user level for this object is set			
		}else if($emp_id==$row['Emp_Id'] and $password==$row['Pass']){
			$this->set_level_id($row["Emp_Level_Id"]);
			
		}
	}
}

