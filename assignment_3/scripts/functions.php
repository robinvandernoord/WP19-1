<?php
/* enable errors for debug */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!isset($is_subfolder)) {
	$is_subfolder = true;
}

$file = 'data/articles.json';
if ($is_subfolder) {
	$file = '../' . $file; // todo: auto
}


function get_posts() {
	global $file;
	// todo: filtering here
	return json_decode(file_get_contents($file), true);
}

function add_update($change) {
	global $file;

	$old = get_posts();

	$result = array_merge($old, $change);

	file_put_contents($file, json_encode($result));
}

function overwrite($new){
	global $file;
	file_put_contents($file, json_encode($new));
}

function redirect($to_where) {
	header("Location: $to_where");
	die();
}

function now() {
	return date('Y-m-d H:i:s', time());
}