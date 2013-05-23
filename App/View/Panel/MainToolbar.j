@import <AppKit/CPToolbar.j>
@import "InspectorView.j"
@import "ReproductorView.j"

var MainToolbarItemIdentifier = "MainToolbarItem",
    InspectorToolbarItemIdentifier = "InspectorToolbarItem",
    MonitorToolbarItemIdentifier = "EditToolbarItem",
     TimeToolbarItemIdentifier = "FontToolbarItem";

@implementation MainToolbar : CPToolbar
{

}

- (id) initWithIdentifier(CPString):anIdentifier
{
    self = [super initWithIdentifier:anIdentifier];
    if(self){
            [self setDelegate:self];
            [self setVisible:YES];
    }
    return self;
}

// Return an array of toolbar item identifier (all the toolbar items that may be present in the toolbar)
- (CPArray)toolbarAllowedItemIdentifiers:(CPToolbar)aToolbar
{
   return [MainToolbarItemIdentifier, MonitorToolbarItemIdentifier, InspectorToolbarItemIdentifier,
            CPToolbarSeparatorItemIdentifier, TimeToolbarItemIdentifier];
}

// Return an array of toolbar item identifier (the default toolbar items that are present in the toolbar) CPToolbarFlexibleSpaceItemIdentifier
- (CPArray)toolbarDefaultItemIdentifiers:(CPToolbar)aToolbar
{
   return [CPToolbarSpaceItemIdentifier, MainToolbarItemIdentifier, CPToolbarSpaceItemIdentifier,
           CPToolbarSeparatorItemIdentifier, TimeToolbarItemIdentifier, CPToolbarSeparatorItemIdentifier,
           MonitorToolbarItemIdentifier, CPToolbarSeparatorItemIdentifier,InspectorToolbarItemIdentifier];
}

- (CPToolbarItem)toolbar:(CPToolbar)aToolbar itemForItemIdentifier:(CPString)anItemIdentifier willBeInsertedIntoToolbar:(BOOL)aFlag
{
    var toolbarItem = [[CPToolbarItem alloc] initWithItemIdentifier:anItemIdentifier];

    //@try{
        var image = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/"+anItemIdentifier+".png" size:CPSizeMake(24, 24)];
        if(image){
            [toolbarItem setImage:image];
            [toolbarItem setMinSize:CGSizeMake(45, 32)];
            [toolbarItem setMaxSize:CGSizeMake(45, 32)];
        }
    /*}@catch (CPException e) {
    }*/

    switch(anItemIdentifier){
        case InspectorToolbarItemIdentifier:
            var mainView = [[InspectorView alloc] initWithFrame:CGRectMake(0,0,120,50)];

            [toolbarItem setView:mainView];
            [toolbarItem setLabel:"Simulador"];
            [toolbarItem setMinSize:CGSizeMake(360, 54)];
            [toolbarItem setMaxSize:CGSizeMake(360, 54)];

        break;
        case MainToolbarItemIdentifier:
             var mainView = [[ReproductorView alloc] initWithFrame:CGRectMake(0,0,120,50)];

            [toolbarItem setView:mainView];
            [toolbarItem setLabel:"Menú Principal"];
            [toolbarItem setMinSize:CGSizeMake(220, 54)];
            [toolbarItem setMaxSize:CGSizeMake(220, 54)];
        break;
        case MonitorToolbarItemIdentifier:
            var monitorView = [[CPView alloc] initWithFrame:CGRectMake(0,0,180,50)];
             var txtMonitor = [[CPTextField alloc] initWithFrame:CGRectMake( 0, 9, 210, 30) ];
            [txtMonitor setEditable:NO];
            [txtMonitor setBezeled:YES];
            [txtMonitor setAlignment:CPRightTextAlignment];
            [txtMonitor setStringValue:"Monitor"];
            [monitorView addSubview:txtMonitor];
            [toolbarItem setView:monitorView];
            [toolbarItem setLabel:"Monitor"];
            [toolbarItem setMinSize:CGSizeMake(210, 54)];
            [toolbarItem setMaxSize:CGSizeMake(210, 54)];
        break;
        case TimeToolbarItemIdentifier:
            var timeView = [[CPView alloc] initWithFrame:CGRectMake( 0, 0, 110, 50) ];
            var txtTime = [[CPTextField alloc] initWithFrame:CGRectMake( 0, 9, 100, 30) ];
            [txtTime setEditable:NO];
            [txtTime setBezeled:YES];
            [txtTime setAlignment:CPRightTextAlignment];
            [txtTime setStringValue:"Tiempo"];
            [timeView addSubview:txtTime];

            [toolbarItem setView:timeView];
            [toolbarItem setLabel:"Tiempo"];
            [toolbarItem setMinSize:CGSizeMake(100, 54)];
            [toolbarItem setMaxSize:CGSizeMake(100, 54)];
        break;
    }

    return toolbarItem;
}

@end
