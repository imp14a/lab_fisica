/*
 * AppController.j
 * LabFisica
 *
 * Created by You on January 29, 2013.
 * Copyright 2013, Your Company All rights reserved.
 */

@import <Foundation/CPObject.j>
@import "View/MainWindow.j"
@import "Controller/MainController.j"

@implementation AppController : CPObject
{
    CPWindow theWindow;
    MainController theController;
}

- (void)applicationDidFinishLaunching:(CPNotification)aNotification
{
	theController = [[MainController alloc] init];
    theWindow = [[MainWindow alloc] init];
    [theWindow orderFront:self];

    [CPMenu setMenuBarVisible:YES];
}

@end
