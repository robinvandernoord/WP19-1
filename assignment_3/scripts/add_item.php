<?php
/* enable errors for debug */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'functions.php';

if ($_POST) {
	// $original = get_posts();

	$sumid = uniqid();
	$array = [
		$sumid => [
			"status"     => "new",
			"title"      => $_POST['name'],
			"text"       => $_POST['content'],
			"changetime" => now(),
			"createtime" => now(),
			"id"         => $sumid,
		]
	];
//	$result   = array_merge($original, $array);
//	file_put_contents($file, json_encode($result));

	add_update($array);
	redirect("../news_edit.php?success=new&id=$sumid");
}
redirect('../news_add.php?success=false');