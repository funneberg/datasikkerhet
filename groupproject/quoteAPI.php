<?php

    include 'connection.php';
	
	function quotes(){
		
		global $dbConn;
		
		$sql = "SELECT quote, author, authorId FROM q_quotes";
				
		$stmt = $dbConn -> prepare ($sql);
		$stmt->execute();
		$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
		//print_r($records);
		//return $records;
		
		echo json_encode($records);
	
	}
	
	quotes();

?>