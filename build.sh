
# configuration
TARGET='launcher/build/Release/iPhoto Exporter.app'

# build launcher
cd launcher
xcodebuild
cd -

# copy contents
rsync -avC --exclude='.*' --exclude='data/*' --include='.htaccess' src/ "$TARGET/Contents/MacOS/src"
rsync -avC --exclude='.*' bin/ "$TARGET/Contents/MacOS/bin"
chmod +x "$TARGET/Contents/MacOS/bin"/*

# copy build files
cp -R "$TARGET" .

