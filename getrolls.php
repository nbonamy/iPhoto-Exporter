<?php

// needed
require_once('includes/iphoto2mac.php');

// now reverse sort by date
$rolls = iPhoto::getRolls();
if ($rolls == null) {
	header('HTTP/1.0 500 Internal error');
	exit();
}
uasort($rolls, create_function('$a, $b', 'return $b->date-$a->date;'));

// done
echo json_encode(array_values($rolls));
