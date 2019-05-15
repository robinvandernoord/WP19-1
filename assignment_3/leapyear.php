<?php
/* enable errors for debug */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/* Header */
$page_title = 'Webprogramming Assignment 3';
$navigation = Array(
	'active' => 'Leap Year',
	'items'  => Array(
		'News'          => './index.php',
		'Add news item' => './news_add.php',
		'Leap Year'     => './leapyear.php',
		'Simple Form'   => './simple_form.php'
	)
);

include __DIR__ . '/tpl/head.php';
include __DIR__ . '/tpl/body_start.php';

function leapyears_age($age, $count=5) {
	$form = '';


	$age  = (int) $age; // typecast age to an integer from string
	$year = date('Y');

	for($i = date('Y'); $i < $year + 4; $i++) {
		if (date('L', strtotime("$i-01-01"))) {
		    // if this year is a leap year:
			for($j = 0; $j < $count; $j++) {
			    // find $count (default 5) next leapyears
				$form .= '<tr>';

				// next 5 leap years, including the current (if applicable)
				$newyear = $i + $j * 4;
				$newage  = $newyear - $year + $age;
				$form    .= "<td>$newyear</td><td>$newage</td>";

				$form .= '</tr>';
			}
			break; // found the next leap year, don't need to look anymore
		}
	}

	$form .= '';

	return $form;
}

?>

    <div class="row">
        <div class="col col-12">
            <br>
			<?php if (!$_POST) {
				$name = $age = $email = $place = '';
			} else {
				// php validation was not required, so if post is here, it should be good.
				$name  = $_POST['name'];
				$age   = $_POST['age'];
				$email = $_POST['email'];
				$place = $_POST['place'];

				echo "<h1>Welcome, $name</h1>";
				if (strtolower($_POST['place']) == 'groningen') {
					echo '<p>You are from Groningen! Gezellig.</p>';
				}
				echo '<p>The next five leap years, this will be your age:</p>';
				?>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Year</th>
                        <th>Age</th>
                    </tr>
                    </thead>
                    <tbody>
					<?=leapyears_age($age);?>
                    </tbody>
                </table>
				<?php
			} // end if $_POST
			?>

            <form action="leapyear.php" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name"
                           required value="<?=$name;?>">
                    <div class="valid-feedback">What a nice name!</div>
                    <div class="invalid-feedback">Please enter a valid name</div>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="text" class="form-control" id="age" name="age" placeholder="Enter your age"
                           required value="<?=$age;?>">
                    <div class="valid-feedback">What a nice age!</div>
                    <div class="invalid-feedback">Please enter a valid age</div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                           placeholder="Enter your email address"
                           required value="<?=$email;?>">
                    <div class="valid-feedback">What a nice address!</div>
                    <div class="invalid-feedback">Please enter a valid email address</div>
                </div>
                <div class="form-group">
                    <label for="place">Place</label>
                    <input type="text" class="form-control" id="place" name="place"
                           placeholder="Enter your place of residence" required value="<?=$place;?>">
                    <div class="valid-feedback">I love that place!</div>
                    <div class="invalid-feedback">Please enter a valid place</div>
                </div>
                <button type="button" class="btn btn-primary" id="do_submit" name="do_submit">Submit</button>
            </form>
        </div>
    </div>
<?php
include __DIR__ . '/tpl/body_end.php';
?>