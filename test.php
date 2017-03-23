<?php

require_once 'classes/Sale.php';
require_once 'classes/Pagination.php';

$sale = new Sale($database);

$page = null;

if(empty($_GET['page'])) {
	$page = 1;
}
else {
	$page = (int)$_GET["page"];
}

$per_page = 2;


$total_count = $sale->database()->count("sales");

$pagination = new Pagination($page, $per_page, $total_count["count"]);

$customers = $sale->database()->selectAll("sales", "LIMIT {$per_page}", "OFFSET {$pagination->offset()}");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Pagnination</title>
</head>
<body>
<?php foreach ($customers as $customer): ?>
<div><?= $customer["name"]; ?></div>
<div><?= $customer["amount"]; ?></div>
<hr/>
<?php endforeach; ?>
<?php if ($pagination->has_previous_page()): ?>
	<a href="test.php?page=<?= $pagination->previous_page() ?>">previous</a>
<?php endif; ?>
<?php for($i=1; $i <= $pagination->total_pages(); $i++): ?>
	<?php
		if ($i == $pagination->current_page()):
		    echo "<span>{$i}</span>";
		    
		else:
		    echo "<a href='test.php?page=" . $i. "'>{$i}</a>";
		endif;
	?>
<?php endfor; ?>

<?php if ($pagination->has_next_page()): ?>
	<a href="test.php?page=<?= $pagination->next_page() ?>">next</a>
<?php endif; ?>

</body>
</html>