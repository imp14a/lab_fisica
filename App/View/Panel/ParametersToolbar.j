@import <AppKit/CPToolbar.j>
@import "FontView.j"

var ApplyToolbarItemIdentifier = "ApplyToolbarItem",
    CancelToolbarItemIdentifier = "CancelToolbarItem";

@implementation ParametersToolbar : CPToolbar
{

}

- (id) initWithIdentifier(CPString):anIdentifier
{
    self = [super initWithIdentifier:anIdentifier];
    if(self){
            [self setDelegate:self];
            [self setVisible:YES];
            //Prepara notificaciones
            [[CPNotificationCenter defaultCenter] addObserver:self
                selector:@selector(testActionNC) name:"btnCancelar" object:nil];
    }
    return self;
}

// Return an array of toolbar item identifier (all the toolbar items that may be present in the toolbar)
- (CPArray)toolbarAllowedItemIdentifiers:(CPToolbar)aToolbar
{
   return [ApplyToolbarItemIdentifier,CancelToolbarItemIdentifier, CPToolbarSeparatorItemIdentifier];
}

// Return an array of toolbar item identifier (the default toolbar items that are present in the toolbar) CPToolbarFlexibleSpaceItemIdentifier
- (CPArray)toolbarDefaultItemIdentifiers:(CPToolbar)aToolbar
{
   return [ApplyToolbarItemIdentifier,CancelToolbarItemIdentifier];
}

- (CPToolbarItem)toolbar:(CPToolbar)aToolbar itemForItemIdentifier:(CPString)anItemIdentifier willBeInsertedIntoToolbar:(BOOL)aFlag
{
    var toolbarItem = [[CPToolbarItem alloc] initWithItemIdentifier:anItemIdentifier];
    [toolbarItem setMinSize:CGSizeMake(45, 54)];
    [toolbarItem setMaxSize:CGSizeMake(45, 54)];
    [toolbarItem setTarget:self];

    switch(anItemIdentifier){
        case ApplyToolbarItemIdentifier:
            var img = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/apply.png" size:CPSizeMake(32, 32)];
            [toolbarItem setLabel:"Aplicar"];
            [toolbarItem setImage:img]
            [toolbarItem setAction:@selector(testAction:)];
        break;
        case CancelToolbarItemIdentifier:
            var img = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/cancel.png" size:CPSizeMake(32, 32)];
            [toolbarItem setLabel:"Cancelar"];
            [toolbarItem setImage:img]
            [toolbarItem setAction:@selector(testAction:)];
        break;
    }

    return toolbarItem;
}




- (void)testAction:(id)notification
{
    CPLog.info("asdgsdk");
    //[CPApp stopModal];
}

@end
