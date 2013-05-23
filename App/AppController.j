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
    CPURLConnection _validateConnection;
}

- (void)applicationDidFinishLaunching:(CPNotification)aNotification
{
	//theController = [[MainController alloc] init];
    //theWindow = [[MainWindow alloc] init];
    //[theWindow orderFront:self];

    var DATA = [[CPString alloc] initWithString:window.location];
    DATA = [DATA substringFromIndex:44];
    //CPLog.info(DATA);

	var request = [CPURLRequest requestWithURL: "http://lab_fisica/Service/pages/core/simulator.php?data="+DATA];

	//create the CPURLConnection and store it. the connection fires immediately
	_validateConnection = [CPURLConnection connectionWithRequest: request delegate: self];

    //[CPMenu setMenuBarVisible:YES];
}


//MÉTODOS DE VALIDACIÓN DE CONEXIÓN


 - (void)connection:(CPURLConnection)aConnection didReceiveData:(CPString)data
{
	//get a javascript object from the json response
	CPLog.info(data);
	var result = JSON.parse(data);

	//check if we're talking about the delete connection
	if (aConnection == _validateConnection)
	{
		CPLog.info(result.access);
		if(result.access)
		{
			theController = [[MainController alloc] init];
    		theWindow = [[MainWindow alloc] init];
    		[theWindow orderFront:self];
		}
		else
		{
			window.location = "http://lab_fisica/App/access_denied.html";
		}
	}
	//clear out this connection's reference
	[self clearConnection:aConnection];
}

- (void)connection:(CPURLConnection)aConnection didFailWithError:(CPError)anError
{
	CPLog.info("fallé");
	if (aConnection == _validateConnection)
	alert("There was an error deleting this photo. Please try again in a moment.");
	[self clearConnection:aConnection];
}

- (void)clearConnection:(CPURLConnection)aConnection
{
	CPLog.info("limpio conexión");
	//we no longer need to hold on to a reference to this connection
	if (aConnection == _validateConnection)
	_validateConnection = nil;
}

@end
