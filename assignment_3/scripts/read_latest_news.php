<?php

include 'functions.php';

$news_items = get_posts();

if ($_GET and isset($_GET['timestamp'])) {
	$ts         = $_GET['timestamp'];
	$news_items = array_filter($news_items, function($var) use ($ts) {
		return $var['changetime'] > $ts;
	});
}

$results = [
	"items"          => $news_items,
	"last_timestamp" => now(),
	"length"         => count($news_items),
];

header('Content-type: application/json');
echo json_encode($results);

