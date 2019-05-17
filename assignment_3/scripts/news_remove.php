<?php

include 'functions.php';

if ($_GET and isset($_GET['id'])) {
	$id = $_GET['id'];


	$posts = get_posts();

	if (isset($posts[$id]) and $posts[$id]['status'] != 'removed') {

		$change = [
			$id => [
				"status"     => "removed",
				"changetime" => now(),
				"id"         => $id,
			]
		];

		add_update($change);

		echo 1;
	} else {
		echo 0;
	}
}