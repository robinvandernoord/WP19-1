<?php

// file with helper functions

/* enable errors for debug */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function get_path($target) {
	$path = explode('/', dirname(__FILE__));
	array_pop($path);
	$parent = implode('/', $path);

	return "$parent/$target";
}
// path to the 'data' folder, working from both the 'scripts' folder as a real page.
$datapath = get_path('data');


// operators (used for querying post ids):

$operators = [
	">"  => function($a, $b) {
		return $a > $b;
	},
	"<"  => function($a, $b) {
		return $a < $b;
	},
	"="  =>
		function($a, $b) {
			return $a == $b;
		},
	"!=" =>
		function($a, $b) {
			return $a != $b;
		},
];

function get_ledger($filter = null, $operator = '=', $condition = null, $reverse = false) {
	// get all or specific posts
	global $datapath;

	$result = json_decode(file_get_contents("$datapath/articles.json"), true);

	if ($filter and $condition) {
		global $operators;
		$operator_func = $operators[$operator];
		$result        = array_filter($result,
			function($var) use ($operator_func, $filter, $condition) {
				return $operator_func($var[$filter], $condition);
			}
		);
	}

	if ($reverse) {
		$result = array_reverse($result);
	}

	return $result;
}

function get_content($id) {
	// get a specific post by ID
	return get_ledger()[$id];

}


function update_ledger($change) {
	/// change a post
	global $datapath;

	$old = get_ledger();

	$result = array_merge($old, $change);

	file_put_contents("$datapath/articles.json", json_encode($result));
}

function remove_entry($id) {
	// remove a post
	global $datapath;
	$imagefile = "$datapath/$id.png";
	unlink($imagefile);
}


function overwrite($new) {
	// overwrite the data file (used to purge old posts for example)
	global $datapath;
	file_put_contents("$datapath/articles.json", json_encode($new));
}

function redirect($to_where) {
	// shortcut for PHP redirection
	header("Location: $to_where");
	die();
}

function validate_file($file) {
	// for file upload, check if a file is alright to use as image
	$target_file = basename($file["name"]);
	$extension   = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	$check      = getimagesize($file["tmp_name"]);
	$dimensions = getimagesize($file["tmp_name"]);
	$ratio      = $dimensions[1] / $dimensions[0];
	// image should be valid, not too big and not too wide/tallh
	if ($check === false) {
		return ['success' => 0, 'error' => 'This image seems to be invalid.'];

	}
	if ($file["size"] > 1000000) {
		return ['success' => 0, 'error' => 'This image is too big (max 1MB).'];

	}
	if (!($ratio < 0.75 and $ratio > 0.25)) {
		return ['success' => 0, 'error' => 'This image does not have the right dimensions to be a banner.'];

	}
	if (!(in_array($extension, ['jpg', 'jpeg', 'png']))) {
		return ['success' => 0, 'error' => 'This file has a wrong extension. Please use only png or jpg'];

	}

	return ['success' => 1];
}