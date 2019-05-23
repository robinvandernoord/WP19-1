<?php
include 'functions.php';

// add a new news item

if ($_POST) {
	$sumid  = uniqid();  // create unique id
	$ledger = [
		$sumid => [
			"status"     => "active",
			"changetime" => time(),
			"title"      => $_POST['name'],
			"text"       => $_POST['content'],
		]
	];

	// insert to 'database'
	update_ledger($ledger);


	// file upload
	if ($_FILES and isset($_FILES["bannerimg"]) and $_FILES["bannerimg"]['size']) {
		$file       = $_FILES["bannerimg"];
		$validation = validate_file($file);
		if ($validation['success']) {
			$target_file = $datapath . '/' . $sumid . '.png';
			move_uploaded_file($file["tmp_name"], $target_file);
		} else {
			$error = $validation['error'];
			redirect("../news_edit.php?error=$error&id=$sumid");
		}
	}

	redirect("../news_edit.php?success=new&id=$sumid");
}
redirect('../news_add.php?success=false');