<?php

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
	$id = $_GET['id'];
} else {
	header("Location: news_add.php");
	die();
}


$info = get_content($id);

?>

    <div class="row">
        <div class="col col-12">
            <br>
            <h1>Edit a news item</h1>

			<?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success" role="alert">
                    News item successfully
					<?php if ($_GET['success'] == 'new'): ?>
                        added!
					<?php elseif ($_GET['success'] == 'changed'): ?>
                        changed!
					<?php endif ?>
                </div>
			<?php elseif (isset($_GET['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    Something went wrong. <?=$_GET['error'];?>
                </div>
			<?php endif; ?>

            <form action="scripts/edit_item.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" class="form-control" id="id" name="id" placeholder="<?=$id;?>" hidden
                           value="<?=$id;?>">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name"
                           required value="<?=$info['title'];?>">
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" class="form-control rounded-0" required
                              placeholder="write some content!"><?=$info['text'];?></textarea>
                </div>

                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="picupload" name="bannerimg">
                        <label id="picuploadlabel" class="custom-file-label" for="picupload">Choose news banner
                            picture</label>
                    </div>
                </div>
                <br/>
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger" id="delete-entry">Delete</button>

            </form>
        </div>
    </div>
<?php
include __DIR__ . '/tpl/body_end.php';
?>