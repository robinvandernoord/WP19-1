<?php
include 'functions.php';

if ($_POST) {
	$sumid    = $_POST['id'];
	$original = get_posts()[$sumid];
	//$original[$sumid] = [
	$change = [
		$sumid => [
			"status"     => "edited",
			"title"      => $_POST['name'],
			"text"       => $_POST['content'],
			"changetime" => now(),
			"createtime" => $original['createtime'],
			"id"         => $original['id'],
		]
	];
	add_update($change);
	// file_put_contents($file, json_encode($original));
	redirect("../news_edit.php?success=changed&id=$sumid");
}
redirect('../news_add.php?success=false');