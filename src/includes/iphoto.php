<?php

class iPhoto {

	// local cache
  private static $plist;
  private static function getPlist() {

    // check cached version
    if (iPhoto::$plist == null) {
    	try {
    		if (file_exists(ALBUM_XML_LOCATION)) {
	      	$parser = new plistParser();
	      	iPhoto::$plist = $parser->parseFile(ALBUM_XML_LOCATION);
    		}
    	} catch (Exception $e) {
    		return null;
    	}
    }

    // done
    return iPhoto::$plist;
  }

  public static function getRolls() {

    // get plist
    $plist = iPhoto::getPlist();
    if ($plist == null) {
    	return null;
    }

    // build rolls array
    $rolls = array();
    foreach ($plist['List of Rolls'] as $plist_roll) {

      // build roll
      $roll = Roll::FromPlist($plist_roll);
      if (in_array($roll->id, Globals::$History)) {
        $roll->exported = true;
      }

      // done
      $rolls[$roll->id] = $roll;
    }

    // done
    return $rolls;
  }

  public static function getImages() {

    // get plist
    $plist = iPhoto::getPlist();
    if ($plist == null) {
    	return null;
    }

    // build images array
    $images = array();
    foreach ($plist['Master Image List'] as $id => $plist_image) {

      // check
      if (in_array($plist_image['MediaType'], array('Image', 'Movie')) == false) {
        continue;
      }

      // build image
      $image = Image::FromPlist($plist_image);

      // done
      $images[$id] = $image;
    }


    // done
    return $images;
  }

}
