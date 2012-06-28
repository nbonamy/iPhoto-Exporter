iPhoto Exporter
===============

iPhoto Exporter allows you to easily extract pictures from iPhoto events. You can download a standalone version from the downloads section https://github.com/nbonamy/iPhoto-Exporter/downloads.

Running iPhoto Exporter
-----------------------

iPhoto Explorer is written in PHP/JavaScript and thus needs to be run through a Web server but it can also be packaged into a regular MacOS X application bundle and run as a standalone application.

iPhoto Explorer automatically extracts your events from your iPhoto Library and tracks already exported events so that you can even use iPhoto Explorer as a backup tool.

The folders to where the photos are exported, are customizable using some special values. You can setup the "Target folder mask" in the options using:
* %s will be replaced with the event name
* PHP date function flags: http://php.net/manual/en/function.date.php

Other options include:
* Target root folder: specify the export root folder. This can be a network folder though iPhoto Explorer will not mount it for you (yet)
* Always overwrite target files: by default iPhoto Exporter only exports modified files since last export of the same event. If you check this, iPhoto Explorer will no longer check the last modified time of files and copy them always
* Clean-up target folder: iPhoto Explorer will delete from the destination folder any files that has been deleted in your iPhoto events. Uncheck this to disable this behavior and keep all files

For instance, using the mask '[Y]/[Y-m-d] %s' and setting the root to '/Volumes/Backup/Pictures' will copy files to /Volumes/Backup/Pictures/[2012]/[2012-06-28] Birthday. The folder hierarchy will be created for you so you do not have to worry about that.

Packaging iPhoto Exporter
-------------------------

You can run the build.sh script to create a standalone version of iPhoto Exporter. You need XCode 4 to be installed as this will be needed to compile the launcher application. Once compiled and bundled, the install script will copy a PHP 5.4 that includes a standalone webserver and the PHP scripts.

When the application is run, the PHP webserver is started and a WebView is displayed showing iPhoto Exporter.


