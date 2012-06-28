<?php

class Roll {

  public static function FromPlist($plist) {

    // basic information
    $roll = new Roll();
    $roll->id = $plist['RollID'];
    $roll->name = $plist['RollName'];
    $roll->date = $plist['RollDateAsTimerInterval']+APPLE_BASE_TIMESTAMP;
    $roll->count = $plist['PhotoCount'];
    $roll->exported = false;

    // title is a bit special as this will be formatted with date which can transform any character
    $escaped = '';
    for ($i=0; $i<strlen($roll->name); $i++) {
    	$escaped .= '\\'.$roll->name[$i];
    }

    // now process
    $mask = Globals::$Config->getString(CFG_SECTION_MAIN, CFG_TARGET_FOLDER_MASK, DEFAULT_TARGET_MASK);
    $roll->title = date(sprintf($mask, $escaped), $roll->date);

    // list of images
    $roll->images = array();
    foreach ($plist['KeyList'] as $index => $id) {
      $roll->images[] = $id;
    }

    // done
    return $roll;
  }

  public $id;
  public $name;
  public $date;
  public $title;
  public $count;
  public $exported;
  public $images;

}