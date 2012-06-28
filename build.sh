
# configuration
ROOT=$HOME/Desktop
TARGET='iPhoto Exporter.app'

# delete previous
rm -rf "$ROOT/$TARGET"

# create application bundle
mkdir -p "$ROOT/$TARGET/Contents/MacOS"
mkdir -p "$ROOT/$TARGET/Contents/Resources"

# copy contents
rsync -avC --exclude='.*' --exclude='data/*' --include='.htaccess' . "$ROOT/$TARGET/Contents/MacOS"
#rm -f "$ROOT/$TARGET/Contents/MacOS/data/*"

# move build files
mv "$ROOT/$TARGET/Contents/MacOS/build/Info.plist" "$ROOT/$TARGET/Contents/"
mv "$ROOT/$TARGET/Contents/MacOS/build/iphoto2mac.icns" "$ROOT/$TARGET/Contents/Resources/"

