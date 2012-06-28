<?php

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
