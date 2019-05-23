<?php
include 'functions.php';

// remove news items with state 'removed' completely from the data file

$left = get_ledger('status', '!=', 'removed');

overwrite($left);
echo count($left);