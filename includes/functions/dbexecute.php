<?
// the parametes are table, fields, temps, values
function insert($table,$fields,$temps,$values){
	
	$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
	
	$sql = "INSERT INTO $table (";
	foreach($fields as $field){
		$sql = $sql . $field . ",";
	}
	$sql = substr($sql, 0, -1);  // delete last ","
	$sql = $sql . ") VALUES (";
	foreach($temps as $temp){
		$sql = $sql . $temp . ",";
	}
	$sql = substr($sql, 0, -1);  // delete last ","
	$sql = $sql . ")";
	
	$db->query($sql);
	
	foreach (array_combine($temps, $values) as $temp => $value) {
		$db->bind("$temp",$value,PDO::PARAM_STR);
	}
	
	$db->execute();
}


function update($table,$fields,$temps,$values,$conditionField,$conditionTemp,$conditionValue){

	$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
	
	$sql = "UPDATE $table SET ";
	foreach (array_combine($fields, $temps) as $field => $temp) {
		$sql = $sql . $field . "=" . $temp . ",";
	}
	$sql = substr($sql, 0, -1);  // delete last ","
	$sql = $sql . " WHERE " . $conditionField . "=" . $conditionTemp;
	
	$db->query($sql);
	echo $sql;
	$db->bind($conditionTemp,$conditionValue,PDO::PARAM_STR);
	foreach (array_combine($temps, $values) as $temp => $value) {
		$db->bind("$temp",$value,PDO::PARAM_STR);
	}
	
	$db->execute();
	
}

function delete($table,$field,$temp,$value){
	$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
	
	$sql = "Delete FROM $table WHERE $field=$temp";
	
	$db->query($sql);
	
	$db->bind($temp, $value, PDO::PARAM_STR);
	
	$db->execute();
}


?>