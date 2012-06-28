//
//  AppDelegate.h
//  iPhoto Explorer
//
//  Created by Nicolas Bonamy on 6/28/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import <Cocoa/Cocoa.h>
#import <Webkit/Webkit.h>

@interface AppDelegate : NSObject <NSApplicationDelegate> {
	NSTask* webserver;
}

@property (assign) IBOutlet NSWindow *window;
@property (strong) IBOutlet WebView *webview;

@end
