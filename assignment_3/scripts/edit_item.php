<?php
include 'functions.php';

// same as add_item but with an existing ID, redirect to different pages.

if ($_POST) {
	$sumid  = $_POST['id'];
	$ledger = [
		$sumid => [
			"status"     => "active",
			"changetime" => time(),
			"title"      => $_POST['name'],
			"text"       => $_POST['content'],
		]
	];


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

	redirect("../news_edit.php?success=changed&id=$sumid");
}
redirect('../news_add.php?error=true&success=false');