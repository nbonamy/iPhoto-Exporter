#!/bin/sh

echo ''
echo '************************************************************'
echo '* iPhoto Exporter'
echo '************************************************************'
echo '* This will launch iPhoto Explorer in a fresh Safari window'
echo '* Close Safari with Cmd-Q to close iPhoto Exporter nicely'
echo '************************************************************'
echo ''

# change folder to script folder
cd "`dirname "$0"`"

# run php web server. iphoto2mac will write pid in file
./php -S localhost:6472 -t .. > /dev/null 2>&1 &

# open new/fresh safari and wait
open -n -F -W "http://localhost:6472/"

# kill php web server and go back to previous folder
kill `cat ../data/iphoto2mac.pid`
cd - > /dev/null

