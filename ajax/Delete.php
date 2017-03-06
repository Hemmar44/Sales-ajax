<?php
	
	require_once '/../classes/Database.php';

	$database = new Database; 

	$id = $_POST["id"];

	
	if($row = $database->delete("sales", "id", $id)){

		echo '<div class="alert alert-success">Database has been successfully updated</div>';
	}
	else {
		
		echo '<div class="alert alert-warning">Nothing to update</div>';
	
	}

	







?>