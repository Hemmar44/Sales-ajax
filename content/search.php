		<div class="text-right">
		<a href="newcustomer.php">Add a customer</a>
		</div>
		<div id="yesno" class="form-inline">
			<span>Completed? &nbsp</span>
			<div class="form-check mb-2 mr-sm-2 mb-sm-0">
	    		<label class="form-check-label">
	      		<input class="form-check-input yesorno" type="radio" name=yesno value="Yes"> Yes
	    		</label>
	  		</div>
	  		<div class="form-check mb-2 mr-sm-2 mb-sm-0">
	    		<label class="form-check-label">
	      		<input class="form-check-input yesorno" type="radio" name=yesno value="No"> No
	    		</label>
	  		</div>
	  		<div class="form-check mb-2 mr-sm-2 mb-sm-0">
	    		<label class="form-check-label">
	      		<input class="form-check-input yesorno" type="radio" name=yesno value="All" checked="checked"> All
	    		</label>
	  		</div>
	  	</div>
	  	<div class="right">
	  		<span>sum of Commisions: </span> <p id="sum"></p>
	  	</div>
		<div id="sorters">
			<div class="form-inline">
					<label class="mr-sm-2" for="dataSelector">Search by</label>
  					<select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="dataSelector">
    					<option selected>Choose...</option>
    					<option value="Name">Name</option>
    					<option value="Product">Product</option>
    					<option value="Institution">Institution</option>
    					<option value="Advisor">Advisor</option>
    					<option value="Amount">Amount</option>
    					<option value="Margin">Margin</option>
    					<option value="Commission">Commission</option>
    					<option value="Date">Date</option>
  					</select>
					<div id="byName" class="search">
			  			<label class="sr-only" for="searchByName"></label>
			  			<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="searchByName" name="searchByName" placeholder="Search by name">
			  		</div>
					
					<div id="byProduct" class="search">
			  			
			  			<select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="searchByProduct">
	    					<option selected value="">Choose...</option>

	    					<?php foreach($sale->database()->selectDistinct("sales", "product") as $product): ?>

	    					<option value="<?= $product['product']; ?>"><?= $product['product']; ?></option>
	    					
	    					<?php endforeach; ?>
	    				</select>	
			  		</div>

					<div id="byInstitution" class="search">
			  			<label class="sr-only" for="searchByInstitution"></label>
			  			<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="searchByInstitution" name="searchByInstitution" placeholder="Search by institution">
			  		</div>
			  			
			  		<div id="byAdvisor" class="search">
	  					<select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="searchByAdvisor">
	    					<option selected value="">Choose...</option>
	    					<?php foreach($sale->database()->selectDistinct("sales", "advisor") as $sale): ?>

	    					<option value="<?= $sale['advisor']; ?>"><?= $sale['advisor']; ?></option>
	    					
	    					<?php endforeach; ?>
	    				</select>	
    				</div>

    				<div id="byAmount" class="search">
			  			<label class="sr-only" for="minAmount"></label>
			  			<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="minAmount" name="minAmount" placeholder="min" value="0">
			  			<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="maxAmount" name="maxAmount" placeholder="max" value="2000000">
			  		</div>

			  		<div id="byMargin" class="search">
			  			<label class="sr-only" for="minMargin"></label>
			  			<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="minMargin" name="minMargin" placeholder="min" value="0">
			  			<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="maxMargin" name="maxMargin" placeholder="max" value="100">
			  		</div>

			  		<div id="byCommission" class="search">
			  			<label class="sr-only" for="minCommission"></label>
			  			<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="minCommission" name="minCommission" placeholder="min" value="0">
			  			<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="maxCommission" name="maxCommission" placeholder="max" value="20000">
			  		</div>

			  		<div id="byDate" class="search">
	  					<select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="searchByDate">
	    					<option value="" selected>Choose...</option>
	    					<?php foreach($months as $month): ?>

	    					<option value="<?= $month['month']; ?>"><?= $month['month']; ?></option>
	    					
	    					<?php endforeach; ?>
	    				</select>	
    				</div>




  					
			</div>
		</div>

		