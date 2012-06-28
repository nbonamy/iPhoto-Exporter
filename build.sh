
# configuration
ROOT=$HOME/Desktop
TARGET='iPhoto Exporter.app'

# delete previous
rm -rf "$ROOT/$TARGET"

# create application bundle
mkdir -p "$ROOT/$TARGET/Contents/MacOS"
mkdir -p "$ROOT/$TARGET/Contents/Resources"

# copy contents
rsync -avC --exclude='.*' --exclude='data/*' --include='.htaccess' src/ "$ROOT/$TARGET/Contents/MacOS"
rsync -avC --exclude='.*' bin/ "$ROOT/$TARGET/Contents/MacOS/bin"
chmod +x "$ROOT/$TARGET/Contents/MacOS/bin"/*

# move build files
cp "build/Info.plist" "$ROOT/$TARGET/Contents/"
cp "build/iphoto2mac.icns" "$ROOT/$TARGET/Contents/Resources/"

