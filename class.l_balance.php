<?php
include_once "class.db_connect.php";
//declaration of attributes
class balance{
	private $emp_id;
	private $gender;
	
//object is created using a construct
	public function __construct($emp_id,$gender){
		$this->emp_id=$emp_id;
		if ($gender==1){
			$this->provide_balanceM($this->emp_id);
		}else{
			$this->provide_balanceF($this->emp_id);
		}

	}
	
	public function provide_balanceM($emp_id){
	//a method to provide a new employee with the leave balance for each leave type
	//this is done by calling a stored procedure in the database. 
	//Different stored procedures are called for male employees and female employees	
		$connection = dbconnect();
		$sql=$connection->prepare("call provide_balance('$emp_id');");
		$sql->execute();
		$out=dbout($connection);
	}

	public function provide_balanceF($emp_id){
		$connection = dbconnect();
		$sql=$connection->prepare("call provide_balance2('$emp_id');");
		$sql->execute();
		$out=dbout($connection);
	}
}

