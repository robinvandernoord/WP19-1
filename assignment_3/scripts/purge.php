<?php
include 'functions.php';

$existing_posts = get_posts();

// reverse so newest are on top;      filter so removed posts don't show up
$left = array_filter($existing_posts, function($var) {
	return $var['status'] != 'removed';
});

overwrite($left);
