<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta Data -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?=$page_title;?></title>

	<!-- Styles -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
	      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="css/styles.css">

	<!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
	        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
	        crossorigin="anonymous"></script>
	<script type="application/javascript" src="js/main.js"></script>
	<?php if($navigation['active'] == 'Links'):?>
	<script type="application/javascript" src="js/links.js"></script>
	<?php endif; ?>

</head>
<body>
<header>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">WP19</a>
		<ul class="navbar-nav mr-auto">
			<?php
			$root = 'http://siegfried.webhosting.rug.nl/~s3745686/';

			// TODO: ask

			foreach($navigation['items'] as $menu_item => $menu_url){
				if($navigation['active'] == $menu_item){
					$active = 'active';
				}
				else {
					$active = '';
				}

				$full_url = $root . $menu_url;
				?>
			<li class="nav-item <?=$active;?>">
				<a class="nav-link" href="<?=$full_url;?>"><?=$menu_item;?></a>
			</li>
			<?php } ?>
		</ul>
	</nav>
</header>