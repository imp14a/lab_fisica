@import <AppKit/CPView.j>

@implementation InspectorView : CPView
{

}


-(id)initWithFrame(CGRect):aFrame
{
	self = [super initWithFrame:aFrame];

    if(self)
    {
    	var btnProperties = [[CPButton alloc] initWithFrame:CGRectMake(0,0,75,48)];
        var imgProperties = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/properties.png" size:CPSizeMake(32, 32)];

        var btnWorld = [[CPButton alloc] initWithFrame:CGRectMake(75,0,50,48)];
        var imgWorld = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/world.png" size:CPSizeMake(32, 32)];

        var btnMonitor = [[CPButton alloc] initWithFrame:CGRectMake(130,0,50,48)];
        var imgMonitor = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/monitor.png" size:CPSizeMake(32,32)];

        var btnGraph = [[CPButton alloc] initWithFrame:CGRectMake(185,0,50,48)];
        var imgGraph = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/graph.png" size:CPSizeMake(32, 32)];

        var btnZoom = [[CPButton alloc] initWithFrame:CGRectMake(240,0,50,48)];
        var imgZoom = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/zoom.png" size:CPSizeMake(32, 32)];

        var btnScript = [[CPButton alloc] initWithFrame:CGRectMake(295,0,50,48)];
        var imgScript = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/script.png" size:CPSizeMake(32, 32)];

        [btnProperties setImagePosition:CPImageAbove];
        [btnProperties setTitle:"Propiedades"];
        [btnProperties setBordered:NO];
        [btnProperties setImage:imgProperties];
        [btnProperties setTarget:self];
        [btnProperties setAction:@selector(btnPropertiesAction:)];
        [btnWorld setImagePosition:CPImageAbove];
        [btnWorld setTitle:"Mundo"];
        [btnWorld setBordered:NO];
        [btnWorld setImage:imgWorld];
        [btnWorld setTarget:self];
        [btnWorld setAction:@selector(btnWorldAction:)];
        [btnMonitor setImagePosition:CPImageAbove];
        [btnMonitor setTitle:"Monitor"];
        [btnMonitor setBordered:NO];
        [btnMonitor setImage:imgMonitor];
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


        [self addSubview:btnProperties];
        [self addSubview:btnWorld];
        [self addSubview:btnMonitor];
        [self addSubview:btnGraph];
        [self addSubview:btnScript];
        [self addSubview:btnZoom];
    }
    return self;
}

//Acciones de botones

- (void)btnPropertiesAction:(id)sender
{
    [[CPNotificationCenter defaultCenter] postNotificationName:"btnMainToolbar" object:"PropertiesModalWindow"];
}

- (void)btnWorldAction:(id)sender
{
	[[CPNotificationCenter defaultCenter] postNotificationName:"btnMainToolbar" object:"WorldModalWindow"];
}
@end
