<table id="dataTable" class="table table-sm table-bordered">
			  <thead>
			    <tr>
			      <th>Delete</th>
			      <th class="name">Name</th>
			      <th class="product">Product</th>
			      <th class="institution">Institution</th>
			      <th class="amount">Amount</th>
			      <th class="advisor">Advisor</th>
			      <th class="margin">Margin</th>
			      <th class="commission">Commission</th>
			      <th class="completed">Completed</th>
			      <th class="date">Date</th>
			    </tr>
			  </thead>
			  <tbody>
			  	
			  	<?php foreach($sales as $sale): ?>
			  		<tr class="rows">
			  		<td class="id"><?= $sale['id']; ?></td>
			  		<td class="Name"><?= $sale['name']; ?></td>
			  		<td class="Product"><?= $sale['product']; ?></td>
			  		<td class="Institution"><?= $sale['institution']; ?></td>
			  		<td class="Amount"><?= $sale['amount']; ?></td>
			  		<td class="Advisor"><?= $sale['advisor']; ?></td>
			  		<td class="Margin"><?= $sale['margin']; ?></td>
			  		<td class="Commission"><?= $sale['commission']; ?></td>
			  		<td class="Completed"><?= $sale['completed']; ?></td>
			  		<td class="Date"><?= date('F Y', strtotime($sale['date'])); ?></td>
			  		</tr>
				<?php endforeach; ?>
			   
			  </tbody>
			</table>
<div id='fixed'></div>
