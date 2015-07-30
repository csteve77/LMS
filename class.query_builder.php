<?php
include_once "class.db_connect.php";
//declaration of variables
class query{
	private $operator;
	private $term;
	private $value;
	private $query;
	private $statement;
	private $sql="SELECT Appli_Id,state,Emp_Id,name as Name, surname as Surname,leave_type as Type, leave_starts as Starts,leave_ends as Ends, num_hours as Hours, balance as Balance, Approved_by FROM `full_view` ";
//getters and setters
	public function get_term(){return $this->term;}
	public function set_term($new_value){$this->term=$new_value;}
	public function get_operator(){return $this->operator;}
	public function set_operator($new_value){$this->operator=$new_value;}
	public function get_query(){return $this->query;}
	public function set_query($new_value){$this->query=$new_value;}
	public function get_statement(){return $this->statement;}
	public function set_statement($new_value){$this->statement=$new_value;}
	public function get_value(){return $this->value;}
	public function set_value($new_value){$this->value=$new_value;}
	public function get_sql(){return $this->sql;}
	public function set_sql($new_value){$this->sql=$new_value;}


//a method that gets the result of the query from the database and stores them in an array	
	public function get_results($query){
		$connection = dbconnect();
		$sql=$connection->query($query);
		$sql->setFetchMode(PDO::FETCH_ASSOC);
			while($row=$sql->fetch()){
	        	$new_array[] = $row;
			}

		if(isset($new_array)){	
			return $new_array;//return the array
		}else{
			 
			return false;//this means that no values where found for the query
		}
	}
	//a method that builds the statement for the query using the passed parameters
	public function build_statement($term,$operator,$value){
		$statement=$this->get_statement();//gets the statement from the current object
		if(!isset($statement)){//if no object was set previously, create a statement with the passed parameters
			$statement=" WHERE"." ".$term." ".$operator." "."'$value'";
			$this->set_statement($statement);
		}else{//else append teh new values to the existing statement 
			$statement=$statement." AND"." ".$term." ".$operator." "."'$value'";
			$this->set_statement($statement);
			//return $this->get_statement();
		}
	}
	//this method gets all the attributes that are required to build a correct query and 
	//collates them to form a complete query
	public function build_query($statement){
		$sql=$this->get_sql();
		$sql=$sql.$statement;
		$this->set_sql($sql);
		$this->set_query($sql);
		
	}
//this method uses a query to retrieve the number of people on leave today
	public function get_todays_leave(){
		$connection = dbconnect();
		$sql=$connection->query("	SELECT  count(*) as People from full_view
									where curdate() between leave_starts and leave_ends
									and state_id =3");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
			$row=$sql->fetch();
	        return $row;	
		}

//this method uses a query to retrieve the number of people on leave tomorrow

	public function get_tomorrow_leave(){
		$connection = dbconnect();
		$sql=$connection->query("	SELECT  count(*) as People from full_view
									where Date_Add(curdate(),Interval 1 day) between leave_starts and leave_ends
									and state_id =3");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
			$row=$sql->fetch();
	        return $row;	
		}
//this method calls a stored procedure that calculates the number of people on leave next week
	public function get_nextWeek_leave(){
		$connection = dbconnect();
		$sql=$connection->query(" CALL `next_week`()");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
			$row=$sql->fetch();
	        return $row;	
	}
}

