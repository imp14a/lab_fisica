/*
 * AppController.j
 * LabFisica
 *
 * Created by You on January 29, 2013.
 * Copyright 2013, Your Company All rights reserved.
 */

@import <Foundation/CPObject.j>
@import "View/MainWindow.j"


@implementation AppController : CPObject
{
    CPWindow theWindow;
}

- (void)applicationDidFinishLaunching:(CPNotification)aNotification
{
    theWindow = [[MainWindow alloc] init];
    [theWindow orderFront:self];

    [CPMenu setMenuBarVisible:YES];
}

@end
