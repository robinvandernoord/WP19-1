<?php
include 'functions.php';

$left = get_ledger('status', '!=', 'removed');

overwrite($left);
echo count($left);