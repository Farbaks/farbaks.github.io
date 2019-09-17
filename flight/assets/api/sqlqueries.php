<?php

/**
 * 
 */
class sqlqueries 
{
	
	// function to insert into a table in the database
	function insert($dbconnection, $table, $field) {
		$insert1 = '';
		$insert2 = '';
		foreach ($field as $key => $value) {
			if ($value == end($field)) {
				$insert1 .= $key;

				if (is_int($value)) {
					$insert2 .= $value ;
				}
				else {
					$insert2 .= "'".$value."'";
				}
			}
			else {
				$insert1 .= $key.",";

				if (is_int($value)) {
					$insert2 .= $value.",";
				}
				else {
					$insert2 .= "'".$value."',";
				}
			}

		}
		
		$query = "INSERT INTO $table ($insert1) VALUES($insert2)";
		$result = mysqli_query($dbconnection, $query);

		if ($result) {
			$message = "Query successful";	
		}
		else {
			$message = "Query unsuccessful";
		}
		return $message;
	}


	// Function to update the records in a table
	function update($dbconnection, $table, $set, $where) {
		$insert1 = '';
		$insert2 = '';
		foreach ($set as $key => $value) {
			if ($value == end($set)) {
				if (is_int($value)) {
					$insert1 .= $key." = ".$value;
				}
				else {
					$insert1 .= $key." = "."'".$value."'";
				}
			}
			else {
				if (is_int($value)) {
					$insert1 .= $key." = ".$value." , ";
				}
				else {
					$insert1 .= $key." = "."'".$value."', ";
				}
			}
		}
		foreach ($where as $key => $value) {
			if ($value == end($where)) {
				if (is_int($value)) {
					$insert2 .= $key." = ".$value;
				} 
				else {
					$insert2 .= $key." = "."'".$value."'";
				}
			}
			else {
				if (is_int($value)) {
					$insert2 .= $key." = ".$value.",";
				}
				else {
					$insert2 .= $key." = "."'".$value."' AND ";
				}
			}
		}
		$query = "UPDATE $table SET $insert1 WHERE $insert2";

		$result = mysqli_query($dbconnection, $query);
		if ($result) {
			$message = "Query successful";	
		}
		else {
			$message = "Query unsuccessful";
		}
		return $message;
	}

	// Function to update the records in a table
	function delete($dbconnection, $table, $where) {
		$insert2 = '';
		foreach ($where as $key => $value) {
			if ($value == end($where)) {
				if (is_int($value)) {
					$insert2 .= $key."=".$value;
				}
				else {
					$insert2 .= $key."="."'".$value."'";
				}
			}
			else {
				if (is_int($value)) {
					$insert2 .= $key."=".$value.",";
				}
				else {
					$insert2 .= $key."="."'".$value."' AND";
				}
			}
		}
		$query = "DELETE FROM $table WHERE $insert2";

		$result = mysqli_query($dbconnection, $query);
		if ($result) {
			$message = "Query successful";	
		}
		else {
			$message = "Query unsuccessful";
		}
		return $message;
	}
}
	
?>