iPhoto Exporter
===============

iPhoto Exporter allows you to easily extract pictures from iPhoto events.

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

You can run the build.sh script to create a standalone version of iPhoto Exporter. This is far from being a native MacOS X application but at least it allows you to run iPhoto Exporter with a single double-click if you do not want to go through the hassle of setting up Apache and PHP properly on your Mac.

The application bundle will be created on your desktop but you can of course decide to move it to your Applications folder. When you double-click the application, it will:
* Run a standalone PHP web server (embedded in the application)
* Open a new and fresh Safari window running iPhoto Exporter
* Wait for you to qui Safari and shutdown the PHP web server

