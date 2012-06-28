<?php

// manage include path
set_include_path(get_include_path().PATH_SEPARATOR.'vendor/');

// includes
require_once('Config/Lite.php');
require_once('plistParser/plistParser.inc');
require_once('includes/constants.php');
require_once('includes/iPhoto.php');
require_once('model/roll.php');
require_once('model/image.php');

// globals
class Globals {
	public static $Config;
  public static $History;
  public static $Success;
  public static $Warning;
  public static $Error;
}

// init stuff
session_start();
date_default_timezone_set('UTC');

// we need to know the pid when run in "application" mode
file_put_contents(PID_FILE, getmypid());

// twig
require_once('vendor/Twig/lib/Twig/Autoloader.php');
Twig_Autoloader::register();

function render($tmpl, $args = array()) {

  // setup twig on templates without cache
  $loader = new Twig_Loader_Filesystem('templates');
  $twig = new Twig_Environment($loader, array(
      'cache' => false
  ));

  // add globals
  $args['session'] = $_SESSION;
  $args['config'] = unserialize(Globals::$Config->serialize());
  $args['success'] = Globals::$Success;
  $args['warning'] = Globals::$Warning;
  $args['error'] = Globals::$Error;

  // render
  return $twig->render($tmpl, $args);
}

// load history
Globals::$History = array();
if (file_exists(HISTORY_FILE)) {
  Globals::$History = unserialize(file_get_contents(HISTORY_FILE));
  if (is_array(Globals::$History) === false) {
    Globals::$History = array();
  }
}

// make sure history is saved automatically on shutdown
function save_history() {
  file_put_contents(HISTORY_FILE, serialize(Globals::$History), LOCK_EX);
}
register_shutdown_function('save_history');

// config utility
function config_set_default($key, $default) {
	if (Globals::$Config->has(CFG_SECTION_MAIN, $key) === false) {
		Globals::$Config->set(CFG_SECTION_MAIN, $key, $default);
	}
}

// load config and init default values
Globals::$Config = new Config_Lite(CONFIG_FILE);
config_set_default(CFG_TARGET_ROOT_FOLDER, DEFAULT_TARGET_ROOT);
config_set_default(CFG_TARGET_FOLDER_MASK, DEFAULT_TARGET_MASK);
config_set_default(CFG_OVERWRITE_ALWAYS, Globals::$Config->toBool(DEFAULT_OVERWRITE_ALWAYS));
config_set_default(CFG_DELETE_OBSOLETE, Globals::$Config->toBool(DEFAULT_DELETE_OBSOLETE));
Globals::$Config->save();
