<?php

// needed
require_once('includes/iphoto2mac.php');

// check status
if (isset($_SESSION[SESSION_STATUS]) && $_SESSION[SESSION_STATUS] == STATUS_RUNNING) {
  $_SESSION[SESSION_ABORT] = true;
  Globals::$Error[] = 'Another process is currently running and was requested to abort. Please reload this page and confirm "Form submission" if asked by your browser.';
}

// check parameters
if (strlen(Globals::$Config->getString(CFG_SECTION_MAIN, CFG_TARGET_ROOT_FOLDER, DEFAULT_TARGET_ROOT)) == 0) {
	Globals::$Error[] = 'Target root folder cannot be empty. Please go back and check your options.';
}
if (strlen(Globals::$Config->getString(CFG_SECTION_MAIN, CFG_TARGET_FOLDER_MASK, DEFAULT_TARGET_MASK)) == 0) {
	Globals::$Error[] = 'Target folder mask cannot be empty. Please go back and check your options.';
}

// check if root is a properly formated and if is a network drive and is mounted
$root = Globals::$Config->getString(CFG_SECTION_MAIN, CFG_TARGET_ROOT_FOLDER, DEFAULT_TARGET_ROOT);
$tokens = explode('/', $root);
if (strlen($tokens[0]) != 0) {
	Globals::$Error[] = 'Target root folder must be an absolute path (starting with /). Please go back and check your options.';
} else if ($tokens[1] == 'Volumes') {
	if (count($tokens) == 2 || strlen($tokens[2]) == 0) {
		Globals::$Error[] = '/Volumes is not a valid target root. Please go back and check your options.';
	} else if (is_dir('/'.$tokens[1].'/'.$tokens[2]) == false) {
		Globals::$Error[] = 'Target root is located on a (network) drive not currently available. Please mount it or go back and check your options.';
	}
}

// error
if (count(Globals::$Error) > 0) {
	echo render('export.twig', array('error' => true));
	exit();
}

// reset all status
$_SESSION[SESSION_PROCESSED] = 0;
$_SESSION[SESSION_CURRENT_TITLE] = null;
$_SESSION[SESSION_CURRENT_THUMB] = null;
$_SESSION[SESSION_STATUS] = STATUS_PENDING;
$_SESSION[SESSION_ABORT] = false;
$_SESSION[SESSION_DRYRUN] = 0;

// check if asked for a full run
if (isset($_REQUEST['fullrun']) === false) {

	// need that
	$rolls = iPhoto::getRolls();

	// for progress purpose
	$todo = array();
	$_SESSION[SESSION_TOTAL] = 0;
	$_SESSION[SESSION_DRYRUN] = isset($_REQUEST['dryrun']) ? $_REQUEST['dryrun'] : 1;

	// first validate rolls
	foreach ($_POST as $key => $value) {

	  // check key
	  $tokens = preg_split('/_/', $key);
	  if (count($tokens) != 2) {
	    continue;
	  }

	  // get roll
	  $roll_id = $tokens[1];
	  if (isset($rolls[$roll_id]) == false) {
	    Globals::$Error[] = 'Unkown Event Id: '.$roll_id;
	    continue;
	  }

	  // ok
	  $roll = $rolls[$roll_id];
	  $_SESSION['total'] += $roll->count;
	  $todo[] = $roll;
	}

	// check
	if (count($todo) == 0) {
	  Globals::$Warning[] = 'There was no event to process.';
	  $_SESSION[SESSION_TODO] = array();
	  echo render('export.twig', array('error' => true));
	  exit();
	}

	// store what is to be exported in session
	// caller will have to call process.php separately
	// to start processing. it can get regular statuses
	// by calling status.php repeatedly
	$_SESSION[SESSION_TODO] = $todo;
	//include('process.php');
}

// done
echo render('export.twig');
