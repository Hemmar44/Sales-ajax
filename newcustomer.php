<?php

require_once 'classes/Sale.php';

$sale = new Sale($database);

//var_dump($_POST);
//$submit = '';
$messageTrue = "New customer has been added";
$messageFalse = "Something was wrong";

if($sale->database()->submitted()) {

	$submit = $sale->database()->insert('sales', [
	"name" => $_POST["name"],
	"product" => $_POST["product"],
	"institution" => $_POST["institution"],
	"amount" => intval($_POST["amount"]),
	"advisor" => $_POST["advisor"],
	"margin" => floatval($_POST["margin"]),
	"completed" => $sale->database()->checkCompleted(),
	"commission" => floatval($_POST["commission"])
	]);
	
}



					

					
				





include("layouts/header.php");
?>
			
			<div class="message">
			<?php
			if(isset($submit)){
				$sale->properMessage($submit, $messageTrue, $messageFalse);
				}
			?>
			</div>

			<div class=col-md-12>
				<div class="text-right">
					<a href="data.php">Browse data</a>
				</div>
				<h2>Enter sale data</h2>
				<form method="post" action="#">
				  <div class="form-group">
				    <label for="name">Customer name</label>
				    <input type="text" class="form-control" id="name" name="name" required>
				  </div>
				  <div class="form-group">
				    <label for="product">Product</label>
				    <select class="form-control" id="product" name="product">
				      <option>Mortgage</option>
				      <option>Loan</option>
				      <option>Insurance</option>
				    </select>
				  </div>
				  <div class="form-group">
				    <label for="institution">Institution</label>
				    <input type="text" class="form-control" id="institution" name="institution" required>
				  </div>
				  <div class="form-group">
				    <label for="amount">Amount</label>
				    <input type="text" class="form-control" id="amount" name="amount" required>
				  </div>
				  <div class="form-group">
				    <label for="advisor">Advisor</label>
				    <select class="form-control" id="advisor" name="advisor">
				      <option>Marcin</option>
				      <option>Magda</option>
				    </select>
				  </div>
				  <div class="form-group">
				    <label for="margin">Margin</label>
				    <input type="text" class="form-control" id="margin" name="margin" required>
				  </div>
				  <div class="form-group">
				    <label for="commission">Commission</label>
				    <input type="text" class="form-control" id="commission" name="commission" readonly>
				  </div>
				  <div class="form-check">
      				<label class="form-check-label">
       				<input type="checkbox" class="form-check-input" name="completed" id="completed"> Completed?
        			</label>
    		      </div>
				  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
				</form>
			</div>
		
<?php
include("layouts/footer.php");
?>

