<?php


require_once '/../classes/Sale.php';



$sale = new Sale($database); 

$messageTrue = "Database has been successfully updated";
$messageFalse = "Nothing to update";

$id = $_POST["id"];
$key = lcfirst($_POST["column"]);
$value = $_POST["value"];

if($key === "date"){
	$value = date("Y-m-d H:i:s", strtotime($value));
}

if(isset($_POST["commission"])) {
$commission = $_POST["commission"];
}
if($key === "completed") {
	
	$sale->properMessage($sale->database()->update("sales", $id, [
						$key => $value
						]), $messageTrue, $messageFalse);
	/*

	if($sale->database()->update("sales", $id, [
		$key => $value
		
	])) {
		$sale->success("Database has been successfully updated");
	}
	else {


		$sale->failure("Nothing to update");

	}
	*/
}
else {

	$sale->properMessage($sale->database()->update("sales", $id, [
						$key => $value,
						"commission" => $commission
						]),$messageTrue, $messageFalse);
	/*
	if($sale->database()->update("sales", $id, [
			$key => $value,
			"commission" => $commission
		])) {

		$sale->success("Database has been successfully updated");
	}
	else {

		$sale->failure("Nothing to update");
	}
	*/
}






?>