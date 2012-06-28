<?php

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
