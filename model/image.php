<?php

class Image {
  
  public static function FromPlist($plist) {

    // basic information
    $image = new Image();
    $image->guid = $plist['GUID'];
    $image->caption = $plist['Caption'];
    $image->date = $plist['DateAsTimerInterval']+APPLE_BASE_TIMESTAMP;
    $image->thumb = $plist['ThumbPath'];
    $image->type= $plist['ImageType'];
    
    // path depends on modification
    if (isset($plist['OriginalPath'])) {
      $image->path = $plist['OriginalPath'];
    } else {
      $image->path = $plist['ImagePath'];
    }
    
    // done
    return $image;
  }
  
  public $guid;
  public $caption;
  public $date;
  public $path;
  public $thumb;
  public $type;

}
