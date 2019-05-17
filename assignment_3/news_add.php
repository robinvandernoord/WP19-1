<?php
/* enable errors for debug */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/* Header */
$page_title = 'Webprogramming Assignment 3';
$navigation = Array(
	'active' => 'Add news item',
	'items'  => Array(
		'News'          => './index.php',
		'Add news item' => './news_add.php',
		'Leap Year'     => './leapyear.php',
		'Simple Form'   => './simple_form.php'
	)
);

include __DIR__ . '/tpl/head.php';
include __DIR__ . '/tpl/body_start.php';


if (isset($_GET['id'])) {
	header("Location: news_edit.php?id=" . $_GET['id']);
	die();
}

?>

    <div class="row">
        <div class="col col-12">
            <br>
            <h1>Add a news item</h1>
            <form action="scripts/add_item.php" method="post">
                <div class="form-group">
                    <label for="name">Title</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your a news title"
                           required>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" class="form-control rounded-0" required
                              placeholder="write some content!"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
<?php
include __DIR__ . '/tpl/body_end.php';
?>