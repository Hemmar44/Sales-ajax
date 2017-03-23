<?php

//we need try variables from outside 
//current_page (from GET)
//$per_page (how many elements we want on a page)
//$total_count (how many elements we have in a database table)

class Pagination {

	public $current_page;
	public $per_page;
	public $total_count;

	public function __construct($page=1, $per_page = 20, $total_count = 0) {

		$this->current_page = (int)$page;
		$this->per_page = (int)$per_page;
		$this->total_count = (int)$total_count;

	}

	public function current_page() {

		return $this->current_page;

	}

	public function offset() {
		//how many elements we need to skip in our database table
		return ($this->current_page -1) * $this->per_page;

	}

	public function total_pages() {
		//how many pages we have
		return ceil($this->total_count/$this->per_page);

	}

	public function previous_page() {

		return $this->current_page - 1;

	}

	public function next_page() {

		return $this->current_page + 1;

	}

	public function has_previous_page() {
		if($this->previous_page() >= 1) {
			return true;
		}
		else {
			return false;
		}
	}

	public function has_next_page() {
		if($this->next_page() <= $this->total_pages()) {
			return true;
		}
		else {
			return false;
		}
	}



}

/*
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

*/