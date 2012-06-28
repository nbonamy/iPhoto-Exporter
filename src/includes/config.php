<?php

// to update string setting
function update_string_config_from_request($key, $config) {
	if (isset($_REQUEST[$key])) {
		Globals::$Config->set(CFG_SECTION_MAIN, $config, $_REQUEST[$key]);
	}
}

// to update bool setting
function update_bool_config_from_request($key, $config) {
	if (isset($_REQUEST[$key])) {
		Globals::$Config->set(CFG_SECTION_MAIN, $config, Globals::$Config->toBool(is_checked($_REQUEST[$key])));
	} else {
		Globals::$Config->set(CFG_SECTION_MAIN, $config, Globals::$Config->toBool(false));
	}
}

// to set a default value
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

