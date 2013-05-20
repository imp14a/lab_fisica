


@import <AppKit/CPWindow.j>
@import <AppKit/CPToolbar.j>
@import "Panel/MetaDataArea.j"
@import "Panel/NavigationArea.j"
@import "Panel/ContentArea.j"
@import "Panel/MainToolbar.j"
@import "Panel/ParametersToolbar.j"


@implementation MainWindow : CPWindow
{

}

- (id) init
{
	self = [super initWithContentRect:CGRectMakeZero() styleMask:CPBorderlessBridgeWindowMask];
    if(self){

        contentView = [self contentView];
        var contentNavigationSplit = [[CPSplitView alloc]
            initWithFrame:CGRectMake(0,0,CGRectGetWidth([contentView bounds]),CGRectGetHeight([contentView bounds]))];

        [contentNavigationSplit setAutoresizingMask:CPViewWidthSizable | CPViewHeightSizable];

        var navigationMetaSplit = [[CPSplitView alloc]
            initWithFrame:CGRectMake(0,0,450.0,CGRectGetHeight([contentView bounds]))];

        var navigationArea = [[NavigationArea alloc] initWithFrame:CGRectMake(0, 0, 450, CGRectGetHeight([contentView bounds]))];
        var contentArea = [[ContentArea alloc] initWithFrame:CGRectMake(0, 0, CGRectGetWidth([contentView bounds]) - 150, CGRectGetHeight([contentView bounds])-150)];

        [navigationMetaSplit setVertical:NO];
        [navigationMetaSplit addSubview:navigationArea];

        [contentNavigationSplit addSubview:navigationMetaSplit];
        [contentNavigationSplit addSubview:contentArea];

        var toolbar = [[MainToolbar alloc] initWithIdentifier:"Herramientas"];
        [self setToolbar:toolbar];

        var testView = [[CPWindow alloc] init];
        [testView setFrame:CGRectMake(70, 70, 300, 300)];
        [testView setTitle:"Propiedades Iniciales"];

        var toolbar2 = [[ParametersToolbar alloc] initWithIdentifier:"Popup"];
        [testView setToolbar:toolbar2];
        [testView orderFront:self];

        [CPApp runModalForWindow:testView];

        [contentView addSubview:contentNavigationSplit];

    }
    return self;

}

@end
