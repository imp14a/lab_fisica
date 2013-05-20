@import <AppKit/CPToolbar.j>

var ApplyToolbarItemIdentifier = "ApplyToolbarItem",
    CancelToolbarItemIdentifier = "CancelToolbarItem";

@implementation ParametersToolbar : CPToolbar
{

}

- (id) initWithIdentifier(CPString):anIdentifier
{
    self = [super initWithIdentifier:anIdentifier];
    if(self)
    {
            [self setDelegate:self];
            [self setVisible:YES];
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
            [toolbarItem setAction:@selector(btnAplicarAction:)];
        break;
        case CancelToolbarItemIdentifier:
            var img = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/cancel.png" size:CPSizeMake(32, 32)];
            [toolbarItem setLabel:"Cancelar"];
            [toolbarItem setImage:img]
            [toolbarItem setAction:@selector(btnCancelarAction:)];
        break;
    }

    return toolbarItem;
}


//Acciones de botones

- (void)btnCancelarAction:(id)notification
{
    [[CPNotificationCenter defaultCenter] postNotificationName:"btnModalToolbar" object:"Cancelar"];
}

- (void)btnAplicarAction:(id)notification
{
    [[CPNotificationCenter defaultCenter] postNotificationName:"btnModalToolbar" object:"Aplicar"];
}

@end
