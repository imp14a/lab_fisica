@import <AppKit/CPToolbar.j>
@import "FontView.j"

var MainToolbarItemIdentifier = "MainToolbarItem"

@implementation ParametersToolbar : CPToolbar
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
   return [MainToolbarItemIdentifier, CPToolbarSeparatorItemIdentifier];
}

// Return an array of toolbar item identifier (the default toolbar items that are present in the toolbar) CPToolbarFlexibleSpaceItemIdentifier
- (CPArray)toolbarDefaultItemIdentifiers:(CPToolbar)aToolbar
{
   return [CPToolbarSpaceItemIdentifier, MainToolbarItemIdentifier];
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
        case MainToolbarItemIdentifier:
            var mainView = [[CPView alloc] initWithFrame:CGRectMake(0,0,120,50)];


            var btnApply = [[CPButton alloc] initWithFrame:CGRectMake(41,0,50,48)];
            var imgApply = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/apply.png" size:CPSizeMake(32, 32)];
            var btnCancel = [[CPButton alloc] initWithFrame:CGRectMake(96,0,50,48)];
            var imgCancel = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/cancel.png" size:CPSizeMake(32, 32)];


            [btnApply setImagePosition:CPImageAbove];
            [btnApply setTitle:"Aplicar"];
            [btnApply setBordered:NO];
            [btnApply setImage:imgApply];
            //[btnApply setAlternateImage:imgAddOver];
            [btnCancel setImagePosition:CPImageAbove];
            [btnCancel setTitle:"Cancelar"];
            [btnCancel setBordered:NO];
            [btnCancel setImage:imgCancel];

            [mainView addSubview:btnApply];
            [mainView addSubview:btnCancel];

            [toolbarItem setView:mainView];
            [toolbarItem setLabel:"Opciones"];
            [toolbarItem setMinSize:CGSizeMake(190, 54)];
            [toolbarItem setMaxSize:CGSizeMake(190, 54)];
        break;
    }

    return toolbarItem;
}

@end
