<?php

// manage include path
set_include_path(get_include_path().PATH_SEPARATOR.'vendor/');

// globals
class Globals {
	public static $Config;
  public static $History;
  public static $Success;
  public static $Warning;
  public static $Error;
}

// includes
require_once('Config/Lite.php');
require_once('plistParser/plistParser.inc');
require_once('includes/constants.php');
require_once('includes/iPhoto.php');
require_once('includes/twig.php');
require_once('includes/utils.php');
require_once('includes/config.php');
require_once('includes/history.php');
require_once('model/roll.php');
require_once('model/image.php');

// init stuff
session_start();
date_default_timezone_set('UTC');

// we need to know the pid when run in "application" mode
file_put_contents(PID_FILE, getmypid());
