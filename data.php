<?php

require_once 'classes/Sale.php';

$sale = new Sale($database);

$sales = [];

$sales = $sale->database()->selectAll("sales");

$date = "DATE_FORMAT(date,'%M %Y') as month";

$months = $sale->database()->selectDistinct("sales", $date);



include("layouts/header.php");
?>		
		<div class=col-md-12>
		

		<?php 

		include("content/searchAjax.php");

		include("content/table.php");

		?>

				
		</div>

<?php
include("layouts/footer.php");
?>