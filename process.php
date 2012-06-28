<?php

// needed
require_once('includes/iphoto2mac.php');

// check that we are really pending
if ($_SESSION[SESSION_STATUS] != STATUS_PENDING) {
  header("HTTP/1.0 500 Already running");
  exit();
}

// run it
set_time_limit(0);
ignore_user_abort(true);

// log file
unlink(LOG_FILE);
function _log($msg) {
	error_log($msg.PHP_EOL, 3, LOG_FILE);
}

// make sure we clean up properly
function update_status() {
  if ($_SESSION[SESSION_STATUS] != STATUS_COMPLETED) {
    $_SESSION[SESSION_STATUS] = STATUS_ABORTED;
  }
}
register_shutdown_function('update_status');

// need that
$reports = array();
$rolls = iPhoto::getRolls();
$images = iPhoto::getImages();

// progress management
function inc_session_progress($current, $count=1) {
  $_SESSION[SESSION_PROCESSED] = $_SESSION[SESSION_PROCESSED]+$count;
  $_SESSION[SESSION_CURRENT_THUMB] = $current;
  session_write_close();
  session_start();
}

// start
$_SESSION[SESSION_STATUS] = STATUS_RUNNING;

// iterate
$rolls = $_SESSION[SESSION_TODO];
foreach ($rolls as $roll) {

  // update title
  $_SESSION[SESSION_CURRENT_TITLE] = $roll->name;

  // for reporting
  $roll_files = array();
  $success = 0;
  $skipped = 0;
  $deleted = 0;
  $notfound = 0;
  $errors = 0;

  // destination folder
  $target  = Globals::$Config->getString(CFG_SECTION_MAIN, CFG_TARGET_ROOT_FOLDER, DEFAULT_TARGET_ROOT);
  $target .= DIR_SEPARATOR.$roll->title.DIR_SEPARATOR;
	
  // log
	_log(PHP_EOL.'[I] "'.$roll->name.'" exported to '.$target);
	
	// now check
  if (is_dir($target) === false) {
  	_log('[D] Destination folder does not exist');
  	if ($_SESSION[SESSION_DRYRUN] == false) {
  		if (mkdir($target, 0777, true) === false) {
  			_log('[E] Unable to create destination folder');
  			inc_session_progress(null, $roll->count);
  			$errors = $roll->count;
  			continue;
  		}
  	}
  } else {
  	_log('[D] Destination folder exists');
  }

  // now iterate on images
  foreach ($roll->images as $image_id) {

    // check abort
    if ($_SESSION[SESSION_ABORT] == true) {
      $_SESSION[SESSION_STATUS] = STATUS_ABORTED;
      exit();
    }

    // check
    if (isset($images[$image_id]) == false) {
    	_log('[W] Image '.$image_id.' listed in event but not in image list');
      inc_session_progress(null);
      $notfound++;
      continue;
    }

    // the image
    $image = $images[$image_id];
    $filename = basename($image->path);

    // now process
    $src = $image->path;
    $dst = $target.$filename;

    // check if source exists
    if (file_exists($src) === false) {
    	_log('[W] Image '.$filename.' listed in event but not found on disk');
      inc_session_progress(null);
    	$notfound++;
			continue;
    }

    // exists
    $roll_files[] = strtolower($filename);
    inc_session_progress($image->thumb);

    // check if modified
    if (Globals::$Config->getBool(CFG_SECTION_MAIN, CFG_OVERWRITE_ALWAYS, DEFAULT_OVERWRITE_ALWAYS) === false) {
	    if (file_exists($dst)) {
	    	$msrc = filemtime($src);
	    	$mdst = filemtime($dst);
	    	if ($msrc == $mdst) {
	    		$skipped++;
	    		continue;
	    	}
	    }
    }

    // copy and update modified time
  	if ($_SESSION[SESSION_DRYRUN] == false) {
	    if (copy($src, $dst) === true) {
	    	$mtime = filemtime($src);
	    	touch($dst, $mtime);
	    	$success++;
	    } else {
	    	_log('[E] Error while copying '.$filename);
	    	$errors++;
	    }
  	} else {
  		$success++;
  	}
  }

  // now check obsolete
  if (Globals::$Config->getBool(CFG_SECTION_MAIN, CFG_DELETE_OBSOLETE, DEFAULT_DELETE_OBSOLETE) === true) {
  	if (is_dir($target)) {
		  $handler = opendir($target);
		  while ($file = readdir($handler)) {
		  	if (is_file($target.$file)) {
		  		if (in_array(strtolower($file), $roll_files) === false) {
  					_log('[I] Deleting obsolete file '.$target.$file);
		  			if ($_SESSION[SESSION_DRYRUN] == false) {
		  				unlink($target.$file);
	  				}
		  			$deleted++;
		  		}
		  		$results[] = $file;
		  	}
		  }
		  closedir($handler);
  	}
  }

  // status
  $reports[] = array(
  	'roll' => $roll,
  	'success' => $success,
  	'skipped' => $skipped,
  	'deleted' => $deleted,
  	'notfound' => $notfound,
  	'errors' => $errors);

  // mark as processed
  if ($errors != $roll->count && $_SESSION[SESSION_DRYRUN] == false) {
    Globals::$History[] = $roll->id;
    save_history();
  }
}

// proper completion
$_SESSION[SESSION_STATUS] = STATUS_COMPLETED;
$_SESSION[SESSION_REPORT] = render('report.twig', array('reports' => $reports));
//include('status.php');