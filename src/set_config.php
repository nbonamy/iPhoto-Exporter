<?php

// needed
require_once('includes/iphoto2mac.php');

// update config
Globals::$Config->set(CFG_SECTION_MAIN, CFG_TARGET_ROOT_FOLDER, $_REQUEST['target_root']);
Globals::$Config->set(CFG_SECTION_MAIN, CFG_TARGET_FOLDER_MASK, $_REQUEST['target_mask']);
Globals::$Config->set(CFG_SECTION_MAIN, CFG_OVERWRITE_ALWAYS, Globals::$Config->toBool(is_checked($_REQUEST['overwrite_always'])));
Globals::$Config->set(CFG_SECTION_MAIN, CFG_DELETE_OBSOLETE, Globals::$Config->toBool(is_checked($_REQUEST['delete_obsolete'])));
Globals::$Config->save();
