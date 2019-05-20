<?php

include 'functions.php';

if ($_GET and isset($_GET['id'])) {
	$id = $_GET['id'];


	$posts = get_ledger();

	if (isset($posts[$id]) and $posts[$id]['status'] != 'removed') {

		$change = [
			$id => [
				"status"     => "removed",
				"changetime" => now(),
			]
		];

		update_ledger($change);
		remove_entry($id);

		echo 1;
	} else {
		remove_entry($id);
		echo 0;
	}
}