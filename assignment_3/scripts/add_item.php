<?php
include 'functions.php';

if ($_POST) {
	$sumid  = uniqid();
	$now    = now();
	$ledger = [
		$sumid => [
			"status"     => "active",
			"changetime" => $now,
		]
	];

	$entry = [
		"title"      => $_POST['name'],
		"text"       => $_POST['content'],
		"changetime" => $now,
	];


	update_ledger($ledger);
	update_entry($sumid, $entry);


	// file upload
	if ($_FILES and isset($_FILES["bannerimg"]) and $_FILES["bannerimg"]['size']) {
		$file = $_FILES["bannerimg"];
		$validation = validate_file($file);
		if($validation['success']){
			$target_file = $datapath . '/' . $sumid . '.png';
			move_uploaded_file($file["tmp_name"], $target_file);
		}
		else {
			$error = $validation['error'];
			redirect("../news_edit.php?error=$error&id=$sumid");
		}
	}


	redirect("../news_edit.php?success=new&id=$sumid");
}
redirect('../news_add.php?success=false');