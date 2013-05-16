@import <AppKit/CPToolbar.j>
@import "FontView.j"

var MainToolbarItemIdentifier = "MainToolbarItem",
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
   return [MainToolbarItemIdentifier, MonitorToolbarItemIdentifier,
            CPToolbarSeparatorItemIdentifier, TimeToolbarItemIdentifier];
}

// Return an array of toolbar item identifier (the default toolbar items that are present in the toolbar) CPToolbarFlexibleSpaceItemIdentifier
- (CPArray)toolbarDefaultItemIdentifiers:(CPToolbar)aToolbar
{
   return [CPToolbarSpaceItemIdentifier, MainToolbarItemIdentifier, CPToolbarSeparatorItemIdentifier,
           TimeToolbarItemIdentifier, CPToolbarSeparatorItemIdentifier,
           MonitorToolbarItemIdentifier, CPToolbarSeparatorItemIdentifier];
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


            var btnNew = [[CPButton alloc] initWithFrame:CGRectMake(0,0,50,48)];
            var imgNew = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/open.png" size:CPSizeMake(32, 32)];
            var btnStart = [[CPButton alloc] initWithFrame:CGRectMake(55,0,50,48)];
            var imgStart = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/start.png" size:CPSizeMake(32, 32)];
            var btnStop = [[CPButton alloc] initWithFrame:CGRectMake(110,0,50,48)];
            var imgStop = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/stop.png" size:CPSizeMake(32, 32)];
            var btnRestart = [[CPButton alloc] initWithFrame:CGRectMake(165,0,50,48)];
            var imgRestart = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/restart.png" size:CPSizeMake(32, 32)];
            var btnProperties = [[CPButton alloc] initWithFrame:CGRectMake(220,0,75,48)];
            var imgProperties = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/properties.png" size:CPSizeMake(32, 32)];
            var btnWorld = [[CPButton alloc] initWithFrame:CGRectMake(295,0,50,48)];
            var imgWorld = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/world.png" size:CPSizeMake(32, 32)];
            var btnGraph = [[CPButton alloc] initWithFrame:CGRectMake(350,0,50,48)];
            var imgGraph = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/graph.png" size:CPSizeMake(32, 32)];
            var btnZoom = [[CPButton alloc] initWithFrame:CGRectMake(405,0,50,48)];
            var imgZoom = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/zoom.png" size:CPSizeMake(32, 32)];
            var btnScript = [[CPButton alloc] initWithFrame:CGRectMake(460,0,50,48)];
            var imgScript = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/script.png" size:CPSizeMake(32, 32)];

            [btnNew setImagePosition:CPImageAbove];
            [btnNew setTitle:"Abrir"];
            [btnNew setBordered:NO];
            [btnNew setImage:imgNew];
            //[btnNew setAlternateImage:imgAddOver];
            [btnStart setImagePosition:CPImageAbove];
            [btnStart setTitle:"Iniciar"];
            [btnStart setBordered:NO];
            [btnStart setImage:imgStart];
            [btnStop setImagePosition:CPImageAbove];
            [btnStop setTitle:"Detener"];
            [btnStop setBordered:NO];
            [btnStop setImage:imgStop];
            [btnRestart setImagePosition:CPImageAbove];
            [btnRestart setTitle:"Reiniciar"];
            [btnRestart setBordered:NO];
            [btnRestart setImage:imgRestart];
            [btnProperties setImagePosition:CPImageAbove];
            [btnProperties setTitle:"Propiedades"];
            [btnProperties setBordered:NO];
            [btnProperties setImage:imgProperties];
            [btnWorld setImagePosition:CPImageAbove];
            [btnWorld setTitle:"Mundo"];
            [btnWorld setBordered:NO];
            [btnWorld setImage:imgWorld];
            [btnGraph setImagePosition:CPImageAbove];
            [btnGraph setTitle:"Gráfica"];
            [btnGraph setBordered:NO];
            [btnGraph setImage:imgGraph];
            [btnScript setImagePosition:CPImageAbove];
            [btnScript setTitle:"Script"];
            [btnScript setBordered:NO];
            [btnScript setImage:imgScript];
            [btnZoom setImagePosition:CPImageAbove];
            [btnZoom setTitle:"Zoom"];
            [btnZoom setBordered:NO];
            [btnZoom setImage:imgZoom];

            [mainView addSubview:btnNew];
            [mainView addSubview:btnStart];
            [mainView addSubview:btnStop];
            [mainView addSubview:btnRestart];
            [mainView addSubview:btnProperties];
            [mainView addSubview:btnWorld];
            [mainView addSubview:btnGraph];
            [mainView addSubview:btnScript];
            [mainView addSubview:btnZoom];


            [toolbarItem setView:mainView];
            [toolbarItem setLabel:"Menú Principal"];
            [toolbarItem setMinSize:CGSizeMake(515, 54)];
            [toolbarItem setMaxSize:CGSizeMake(515, 54)];
        break;
        case MonitorToolbarItemIdentifier:
            /*var timeView = [[CPView alloc] initWithFrame:CGRectMake(0,0,110,50)];
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
            [toolbarItem setMaxSize:CGSizeMake(115, 50)];*/
        break;
        case TimeToolbarItemIdentifier:
            var timeView = [[CPView alloc] initWithFrame:CGRectMake( 0, 0, 110, 50) ];
            var txtTime = [[CPTextField alloc] initWithFrame:CGRectMake( 0, 0, 50, 48) ];
            var btnScript = [[CPButton alloc] initWithFrame:CGRectMake(55,0,50,48)];
            [btnScript setTitle:"Script"];
            [btnScript setBezelStyle:CPSmallSquareBezelStyle];
            [txtTime setEditable:YES];
            [txtTime setBackgroundColor:[CPColor whiteColor]];
            [txtTime setStringValue:"PUTITO"];
            [timeView addSubview:txtTime];
            [timeView addSubview:btnScript];

            [toolbarItem setView:timeView];
            [toolbarItem setLabel:"Tiempo"];
            [toolbarItem setMinSize:CGSizeMake(115, 54)];
            [toolbarItem setMaxSize:CGSizeMake(115, 54)];
        break;
    }

    return toolbarItem;
}

@end
