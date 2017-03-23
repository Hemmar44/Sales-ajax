<?php

require_once '/../classes/Sale.php';
require_once '/../classes/Pagination.php';

//sort the get out something is wrong with it

$sales = new Sale($database); 

//print_r($_POST);

$stringColumns = ["name", "product", "institution", "advisor"];
$integerColumns = ["amount", "margin", "commission"];

$column = lcfirst($_POST["column"]);
$value = $_POST["value"];
$completed = $_POST["completed"];
$min = $_POST["min"];
$max = $_POST["max"];

//only yes no or all clicked or search clicked on choose
if(empty($column) || $column === "choose..."){
	$completed = $_POST["completed"];
	if($completed === "All"){
		//"completed === All";
		$tableRow = $sales->database()->selectAll("sales");
	}
	else {
		//"completed not all";
		$tableRow = $sales->database()->selectOr("sales", ["completed" => $completed]);
	}
}

	//string data received
if(in_array($column, $stringColumns)) {
	
	//"completed === All empty value";
	if($completed === "All" && empty($value)) {
		$tableRow = $sales->database()->selectAll("sales");
	
	}
	//"completed not All empty value";
	else if($completed !== "All" && empty($value)) {
		$tableRow = $sales->database()->selectOr("sales", ["completed" => $completed]);
		
	}
	//"completed === All not empty value";
	else if($completed === "All" && !empty($value)) {
		$tableRow = $sales->database()->selectLike("sales", $column, $value);
		
	}
	else {
	//completed on yes or no and some value in string input
		$tableRow = $sales->database()->selectAndLike("sales", "completed", $completed, $column, $value);
		
	}

}

	//some integer data recieved
if(in_array($column, $integerColumns)) {
	//must set min and max to numeric values, don't want empty string to be set as numeric.
		if(!empty($min) && !empty($max)){
		if($column === "margin"){
			$min = floatval($min)/100;
			$max = floatval($max)/100;
		}
		else {
			$min = intval($min);
			$max = intval($max);
		}
	}
	
	if($completed === "All") {
		//"completed === All not numeric min or max";
		if(!is_numeric($min) || !is_numeric($max)) {
		$tableRow = $sales->database()->selectAll("sales");
		}
		//"completed === All numeric min and max";
		else{
		$tableRow = $sales->database()->selectBetween("sales", $column, $min, $max);
		}
	}
	else {

		//"completed not All not numeric min or max";
		if(!is_numeric($min) || !is_numeric($max)) {
		$tableRow = $sales->database()->selectOr("sales", ["completed" => $completed]);
		}
		//"completed not All numeric min and max";
		else{
		$tableRow = $sales->database()->selectAndBetween("sales", "completed", $completed, $column, $min, $max);
		}
	}
		
}

if($column === "date") {
		//if(empty($value)){echo "empty";}
		if($completed === "All" && empty($value)) {
		$tableRow = $sales->database()->selectAll("sales");
		}
		
		else if($completed !== "All" && empty($value)) {
		$tableRow = $sales->database()->selectOr("sales", ["completed" => $completed]);
		
		}
		
		else if($completed === "All" && !empty($value)){
		$value = date("Y-m-d", strtotime($value));
		$tableRow = $sales->database()->selectOr("sales", ["date" => $value]);
		}

		else {
		$value = date("Y-m-d", strtotime($value));
		$tableRow = $sales->database()->selectOrAnd("sales", "AND", ["date" => $value, "completed" => $completed]);

		}
	}

$page =(int)$_POST["get"];
$total_count = count($tableRow);
$per_page = 10;

$data = '';
$links = '';

$pagination = new Pagination($page, $per_page, $total_count);

if($pagination->total_pages() > 1) {
	$tableRows = array_chunk($tableRow, $per_page);
		if(array_key_exists($page - 1 , $tableRows)) {
			foreach ($tableRows[$page - 1] as $tableCell) {
				$data .= "<tr class='rows'>";
				$data .= "<td class='id'>{$tableCell['id']}</td>";
				$data .= "<td class='Name'>{$tableCell['name']}</td>";
				$data .= "<td class='Product'>{$tableCell['product']}</td>";
				$data .= "<td class='Institution'>{$tableCell['institution']}</td>";
				$data .= "<td class='Amount'>{$tableCell['amount']}</td>";
				$data .= "<td class='Advisor'>{$tableCell['advisor']}</td>";
				$data .= "<td class='Margin'>{$tableCell['margin']}</td>";
				$data .= "<td class='Commission'>{$tableCell['commission']}</td>";
				$data .= "<td class='Completed'>{$tableCell['completed']}</td>";
				$data .= "<td class='Date'>". date('F Y', strtotime($tableCell['date'])) ."</td>";
				$data .= "</tr>";
			};

			if ($pagination->has_previous_page()) {
				$links .= "<a href='#' data={$pagination->previous_page()}>previous </a>";
			} 

			for($i=1; $i <= $pagination->total_pages(); $i++) {
				if ($i == $pagination->current_page()) {
		    	$links .= "<span>{$i}</span> ";
		    	}
		    	else {
		    	$links .= "<a href='#' data={$i}>{$i}</a> ";
		    	}
		    
			}

			if ($pagination->has_next_page()) {
				$links .= "<a href='#' data={$pagination->next_page()}> next</a>";
			}
			

		}

}

else {
foreach ($tableRow as $tableCell) {
	$data .= "<tr class='rows'>";
	$data .= "<td class='id'>{$tableCell['id']}</td>";
	$data .= "<td class='Name'>{$tableCell['name']}</td>";
	$data .= "<td class='Product'>{$tableCell['product']}</td>";
	$data .= "<td class='Institution'>{$tableCell['institution']}</td>";
	$data .= "<td class='Amount'>{$tableCell['amount']}</td>";
	$data .= "<td class='Advisor'>{$tableCell['advisor']}</td>";
	$data .= "<td class='Margin'>{$tableCell['margin']}</td>";
	$data .= "<td class='Commission'>{$tableCell['commission']}</td>";
	$data .= "<td class='Completed'>{$tableCell['completed']}</td>";
	$data .= "<td class='Date'>". date('F Y', strtotime($tableCell['date'])) ."</td>";
	$data .= "</tr>";
}
}

echo $data. "||" . $links;





?>