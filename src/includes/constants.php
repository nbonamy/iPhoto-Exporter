<?php

// misc stuff
//define('ALBUM_XML_LOCATION', dirname(__FILE__).'/../data/AlbumData.xml');
define('ALBUM_XML_LOCATION', getenv('HOME').'/Pictures/iPhoto Library/AlbumData.xml');
define('HISTORY_FILE', getenv('HOME').'/.iphoto2mac.history');
define('CONFIG_FILE', getenv('HOME').'/.iphoto2mac.conf');
define('LOG_FILE', dirname(__FILE__).'/../data/iphoto2mac.txt');
define('PID_FILE', dirname(__FILE__).'/../data/iphoto2mac.pid');
define('APPLE_BASE_TIMESTAMP', 978307200);
define('DIR_SEPARATOR', '/');

// configuration parameters
define('CFG_SECTION_MAIN', 'main');
define('CFG_TARGET_ROOT_FOLDER', 'target_root');
define('CFG_TARGET_FOLDER_MASK', 'target_mask');
define('CFG_OVERWRITE_ALWAYS', 'overwrite_always');
define('CFG_DELETE_OBSOLETE', 'delete_obsolete');

// default configuration values
define('DEFAULT_TARGET_ROOT', getenv('HOME').'/Pictures/Export');
define('DEFAULT_TARGET_MASK', '[Y]/[Y-m-d] %s');
define('DEFAULT_OVERWRITE_ALWAYS', false);
define('DEFAULT_DELETE_OBSOLETE', true);

// session parameters
define('SESSION_TODO', 'todo');
define('SESSION_DRYRUN', 'dryrun');
define('SESSION_STATUS', 'status');
define('SESSION_TOTAL', 'total');
define('SESSION_PROCESSED', 'processed');
define('SESSION_CURRENT_TITLE', 'title');
define('SESSION_CURRENT_THUMB', 'thumb');
define('SESSION_REPORT', 'report');
define('SESSION_ABORT', 'abort');

// process status
define('STATUS_PENDING', 'pending');
define('STATUS_RUNNING', 'running');
define('STATUS_ABORTED', 'aborted');
define('STATUS_COMPLETED', 'completed');
