<?php
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
	global $datapath;

	$result = json_decode(file_get_contents("$datapath/ledger.json"), true);

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
	global $datapath;
	$file = "$datapath/$id.json";

	return json_decode(file_get_contents($file), true);

}


function update_ledger($change) {
	global $datapath;

	$old = get_ledger();

	$result = array_merge($old, $change);

	file_put_contents("$datapath/ledger.json", json_encode($result));
}

function update_entry($id, $content) {
	global $datapath;
	$file = "$datapath/$id.json";
	file_put_contents($file, json_encode($content));
}


function remove_entry($id) {
	global $datapath;
	$file = "$datapath/$id.json";
	unlink($file);
	$imagefile = "$datapath/$id.png";
	unlink($imagefile);
}


function overwrite($new) {
	global $datapath;
	file_put_contents("$datapath/ledger.json", json_encode($new));
}

function redirect($to_where) {
	header("Location: $to_where");
	die();
}

function now() {
	return date('Y-m-d H:i:s', time());
}

function validate_file($file) {
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