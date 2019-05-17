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

$is_subfolder = false;
include 'scripts/functions.php';

$existing_posts = get_posts();

// reverse so newest are on top;      filter so removed posts don't show up
$usable_posts = array_reverse(array_filter($existing_posts, function($var){
	return $var['status'] != 'removed';
}));

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
            <?php foreach($usable_posts as $post):?>
                <div class="col col-4 bubble d-flex" id="newsitem-<?=$post['id'];?>">
                    <div class="card d-flex flex-grow-1">
                        <div class="card-body">
                            <h5 class="card-title"><?=$post['title'];?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?=$post['changetime'];?></h6>
                            <p class="card-text"><?=nl2br($post['text']);?></p>
                            <a href="news_edit.php?id=<?=$post['id'];?>" class="card-link">edit news</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>



<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="success">
    <div class="toast-header">
        <img src="..." class="rounded mr-2" alt="...">
        <strong class="mr-auto">Bootstrap</strong>
        <small>11 mins ago</small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        Hello, world! This is a toast message.
    </div>
</div>

<?php
include __DIR__ . '/tpl/body_end.php';
?>
