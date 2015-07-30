<?php
include_once"../model/class/class.query_builder.php";
/*this controller is used to get the reults of a query after
a query was performed using the query builder*/
$query=new query();
$a=$query->get_results();
echo json_encode($a);
