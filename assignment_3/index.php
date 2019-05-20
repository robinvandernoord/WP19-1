<?php

/* Header */
$page_title = 'Webprogramming Assignment 3';
$navigation = Array(
	'active' => 'News',
	'items'  => Array(
		'News'          => './index.php',
		'Add news item' => './news_add.php',
		'Leap Year'     => './leapyear.php',
		'Simple Form'   => './simple_form.php'
	)
);

include __DIR__ . '/tpl/head.php';
include __DIR__ . '/tpl/body_start.php';


$usable_posts = get_ledger('status', '!=', 'removed', true);

?>
<div class="row">
    <div class="col col-12">
        <h1>The latest news</h1>
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="toggle_reload" checked>
            <label class="custom-control-label" for="toggle_reload">Toggle auto loading posts</label>
        </div>
    </div>
</div>
<div id="articles">
    <div class="row justify-content-start d-flex flex-wrap">
		<?php foreach($usable_posts as $id => $post): ?>
            <div class="async-loader col col-lg-4 col-md-6 d-flex col-sm-12" id="<?=$id;?>"></div>
		<?php endforeach; ?>
    </div>
</div>


<?php
include __DIR__ . '/tpl/body_end.php';
?>
