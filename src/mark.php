<?php

// needed
require_once('includes/iphoto2mac.php');

// specials
$id = $_REQUEST['id'];
if ($id == 'all') {
	
	// more complex
	$rolls = iPhoto::getRolls();
	Globals::$History = array_keys($rolls);
	
} else if ($id == 'none') {
	
	// clear
	Globals::$History = array();
	
} else {
	
	// push value
	Globals::$History[] = $_REQUEST['id'];

}

// save history
save_history();

