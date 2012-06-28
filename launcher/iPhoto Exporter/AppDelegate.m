//
//  AppDelegate.m
//  iPhoto Explorer
//
//  Created by Nicolas Bonamy on 6/28/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import "AppDelegate.h"

@implementation AppDelegate

@synthesize window = _window;
@synthesize spinner = _spinner;
@synthesize webview = _webview;

- (void)applicationDidFinishLaunching:(NSNotification *)aNotification
{
	// we will build the paths to 
	NSArray *runargs = [[NSProcessInfo processInfo] arguments];
	NSString* path = [[runargs objectAtIndex:0] stringByDeletingLastPathComponent];
	
	// now build path to php and src
	NSString* php = [path stringByAppendingString:@"/bin/php"];
	NSString* src = [path stringByAppendingString:@"/src/"];
	NSArray* args = [NSArray arrayWithObjects:@"-S", @"localhost:6472", @"-t", src, nil];
	webserver = [NSTask launchedTaskWithLaunchPath:php arguments:args];
	
	// now wait a bit and set web view
	[self.spinner startAnimation:nil];
	[NSTimer scheduledTimerWithTimeInterval:2.0
																	 target:self
																 selector:@selector(loadWebview)
																 userInfo:nil
																	repeats:NO];
}

- (void) loadWebview {
	[self.spinner setHidden:YES];
	[[self.webview mainFrame] loadRequest:[NSURLRequest requestWithURL:[NSURL URLWithString:@"http://localhost:6472/index.php"]]];
}

- (void) applicationWillTerminate:(NSNotification *)notification {
	
	// terminate php server
	[webserver terminate];
	
}

@end
