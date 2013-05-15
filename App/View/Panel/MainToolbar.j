@import <AppKit/CPToolbar.j>
@import "FontView.j"

var FileToolbarItemIdentifier = "FileToolbarItem",
    EditToolbarItemIdentifier = "EditToolbarItem",
     FontToolbarItemIdentifier = "FontToolbarItem";

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
   return [FileToolbarItemIdentifier,EditToolbarItemIdentifier,
            CPToolbarSeparatorItemIdentifier, FontToolbarItemIdentifier];
}

// Return an array of toolbar item identifier (the default toolbar items that are present in the toolbar) CPToolbarFlexibleSpaceItemIdentifier
- (CPArray)toolbarDefaultItemIdentifiers:(CPToolbar)aToolbar
{
   return [CPToolbarSpaceItemIdentifier,FileToolbarItemIdentifier,CPToolbarSeparatorItemIdentifier,
           EditToolbarItemIdentifier,CPToolbarSeparatorItemIdentifier,
           FontToolbarItemIdentifier,CPToolbarSeparatorItemIdentifier];
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
        case FileToolbarItemIdentifier:
            var fileView = [[CPView alloc] initWithFrame:CGRectMake(0,0,120,50)];
            
            var imgAdd = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/AddToolbarItem.png" size:CPSizeMake(32, 32)];
            var imgAddOver = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/AddToolbarItem_over.png" size:CPSizeMake(32, 32)];
            var botonAdd = [[CPButton alloc] initWithFrame:CGRectMake(0,0,50,48)];
            var imgCopy = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/CopyToolbarItem.png" size:CPSizeMake(32, 32)];
            var botonCopy = [[CPButton alloc] initWithFrame:CGRectMake(55,0,50,48)];
            var imgRemove = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/RemoveToolbarItem.png" size:CPSizeMake(32, 32)];
            var botonRemove = [[CPButton alloc] initWithFrame:CGRectMake(110,0,50,48)];

            [botonAdd setImagePosition:CPImageAbove];
            [botonAdd setTitle:"Agregar"];
            [botonAdd setBordered:NO];
            [botonAdd setImage:imgAdd];
            [botonAdd setAlternateImage:imgAddOver];
            [botonCopy setImagePosition:CPImageAbove];
            [botonCopy setTitle:"Copiar"];
            [botonCopy setBordered:NO];
            [botonCopy setImage:imgCopy];
            [botonRemove setImagePosition:CPImageAbove];
            [botonRemove setTitle:"Remover"];
            [botonRemove setBordered:NO];
            [botonRemove setImage:imgRemove];
            [fileView addSubview:botonAdd];
            [fileView addSubview:botonCopy];
            [fileView addSubview:botonRemove];
            [toolbarItem setView:fileView];
            [toolbarItem setLabel:"Diapositivas"];
            [toolbarItem setMinSize:CGSizeMake(160, 54)];
            [toolbarItem setMaxSize:CGSizeMake(160, 54)];
        break;
        case EditToolbarItemIdentifier:
            var editView = [[CPView alloc] initWithFrame:CGRectMake(0,0,110,50)];
            var imgUndo = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/UndoToolbarItem.png" size:CPSizeMake(32, 32)];
            var botonUndo = [[CPButton alloc] initWithFrame:CGRectMake(0,0,55,48)];
            var imgRedo = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/RedoToolbarItem.png" size:CPSizeMake(32, 32)];
            var botonRedo = [[CPButton alloc] initWithFrame:CGRectMake(60,0,55,48)];
            
            [botonUndo setImagePosition:CPImageAbove];
            [botonUndo setTitle:"Deshacer"];
            [botonUndo setBordered:NO];
            [botonUndo setImage:imgUndo];

            [botonRedo setImagePosition:CPImageAbove];
            [botonRedo setTitle:"Rehacer"];
            [botonRedo setBordered:NO];
            [botonRedo setImage:imgRedo];
            
            [editView addSubview:botonUndo];
            [editView addSubview:botonRedo];
            [toolbarItem setView:editView];
            [toolbarItem setLabel:"Edición"];
            [toolbarItem setMinSize:CGSizeMake(115, 50)];
            [toolbarItem setMaxSize:CGSizeMake(115, 50)];
        break;
        case FontToolbarItemIdentifier:
            fontView =[[FontView alloc] initWithFrame:CGRectMake( 0,0, 360,50) ];
            [toolbarItem setView:fontView];
            [toolbarItem setLabel:"Fuente"];
            [toolbarItem setMinSize:CGSizeMake(360, 32)];
            [toolbarItem setMaxSize:CGSizeMake(360, 32)];
        break;
    }
     
    return toolbarItem;
}

@end
