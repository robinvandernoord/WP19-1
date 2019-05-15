<?php

/* Header */
$page_title = 'Webprogramming Assignment 3';
$navigation = Array(
	'active' => 'Simple Form',
	'items'  => Array(
		'News'          => './index.php',
		'Add news item' => './news_add.php',
		'Leap Year'     => './leapyear.php',
		'Simple Form'   => './simple_form.php'
	)
);

include __DIR__ . '/tpl/head.php';
include __DIR__ . '/tpl/body_start.php';


$title = $place_residence = '';
if($_GET){
    if(isset($_GET['name'])) {
        $username = $_GET['name'];
	    $title = "<h1>Welcome, $username</h1>";
    }
	if(isset($_GET['place'])) {
		$userplace = $_GET['place'];
		if(strtolower($userplace) == 'amsterdam'){
		    $userplace = 'the capital of the Netherlands';
        }
		$place_residence = "<p>You're from $userplace!</p>";
	}
}



?>

    <div class="row">
        <div class="col col-12">
            <br>
            <?=$title;?>
	        <?=$place_residence;?>
            <form action="simple_form.php" method="get">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name"
                           required>
                </div>
                <div class="form-group">
                    <label for="place">Place</label>
                    <input type="text" class="form-control" id="place" name="place"
                           placeholder="Enter your place of residence" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
<?php
include __DIR__ . '/tpl/body_end.php';
?>