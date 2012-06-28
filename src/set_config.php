<?php

// needed
require_once('includes/iphoto2mac.php');

// update config
update_string_config_from_request('target_root', CFG_TARGET_ROOT_FOLDER);
update_string_config_from_request('target_mask', CFG_TARGET_FOLDER_MASK);
update_bool_config_from_request('overwrite_always', CFG_OVERWRITE_ALWAYS);
update_bool_config_from_request('delete_obsolete', CFG_DELETE_OBSOLETE);
Globals::$Config->save();
