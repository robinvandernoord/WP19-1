<?php

include 'functions.php';

// get news posts

if ($_GET and isset($_GET['id'])) {
    // generate one news card if the id is set:
	$id      = $_GET['id'];
	$content = get_content($id);

	$time = date('d-m-Y H:i:s', $content['changetime']);


	// timestamp in image is to force browser to get image again (overwrite cache)
    if(file_exists("$datapath/$id.png")){
	    $image_path = "data/$id.png?timestamp=" . time();
    }
    else {
        // if no image, search a random one
        $image_path = "https://source.unsplash.com/600x300/?journalism&timestamp=" . time();
    }
	?>
    <div class="card d-flex flex-grow-1 bubble">
        <img class="card-img-top"
             src="<?=$image_path;?>"
             alt="<?=$content['title'];?>">
        <div class="card-body">
            <h5 class="card-title"><?=htmlspecialchars($content['title']);?></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?=$time;?></h6>
            <p class="card-text"><?=nl2br(htmlspecialchars($content['text']));?></p>
            <a href="news_edit.php?id=<?=$id;?>" class="card-link">edit news</a>
        </div>
    </div>
	<?php
} else {
    // show all news (or since a timestamp)
	if ($_GET and isset($_GET['timestamp'])) {
		$ts         = $_GET['timestamp'];
		$news_items = get_ledger('changetime', '>', $ts);
	} else {
		$news_items = get_ledger();
	}

	$results = [
		"items"          => $news_items,
		"last_timestamp" => time(),
		"length"         => count($news_items),
	];

	header('Content-type: application/json');
	echo json_encode($results);
}