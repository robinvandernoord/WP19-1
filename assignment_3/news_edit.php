<?php
/* enable errors for debug */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$file = 'data/articles.json';

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
	$edit_id = $_GET['id'];
} else {
	header("Location: news_add.php");
	die();
}

$all_items = json_decode(file_get_contents($file), true);

$selected_item = array_reverse(array_filter($all_items, function($var) use ($edit_id) {
	return $var['id'] == $edit_id;
}));


foreach($selected_item as $id => $info): # should only be one
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
			<?php endif; ?>

            <form action="scripts/edit_item.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="id" name="id" placeholder="<?=$info['id'];?>" hidden
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
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger" id="delete-entry">Delete</button><!-- todo -->

                <script>
                    $(function () {
                        $('#delete-entry').on('click', function () {
                            if (confirm('Are you sure you want to remove this news item?')) {
                                $.ajax('scripts/news_remove.php?id=' + $('#id').val(), {
                                    'success': function () {
                                        window.location.href = 'index.php';
                                    },
                                })
                            }
                        });
                    })
                </script>

            </form>
        </div>
    </div>
<?php
endforeach;
include __DIR__ . '/tpl/body_end.php';
?>