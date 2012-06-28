<?php

require_once('Twig/lib/Twig/Autoloader.php');
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
