<?php

include 'scripts/functions.php';

// head of each page

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=$page_title?></title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<?php if ($navigation['active'] == 'Leap Year'): ?>
        <script type="application/javascript" src="scripts/js/leapyear.js"></script>
	<?php elseif ($navigation['active'] == 'News'): ?>
        <script type="application/javascript" src="scripts/js/newsloader.js"></script>
	<?php elseif ($navigation['active'] == 'Add news item'): ?>
        <script type="application/javascript" src="scripts/js/newsform.js"></script>
	<?php endif; ?>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">WP19 Assignment 3</a>
        <ul class="navbar-nav mr-auto">
			<?php $active = $navigation['active']; ?>
			<?php foreach($navigation['items'] as $title => $url) {
				if ($title == $active) { ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?=$url?>"><?=$title?></a>
                    </li>
				<?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$url?>"><?=$title?></a>
                    </li>
				<?php } ?>
			<?php } ?>
        </ul>
    </nav>
</header>