


@import <AppKit/CPWindow.j>
@import <AppKit/CPToolbar.j>
@import "Panel/MetaDataArea.j"
@import "Panel/NavigationArea.j"
@import "Panel/ContentArea.j"
@import "Panel/MainToolbar.j"


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

        var navegationMetaSplit = [[CPSplitView alloc]
            initWithFrame:CGRectMake(0,0,200.0,CGRectGetHeight([contentView bounds]))];

        var navigationArea = [[NavigationArea alloc] initWithFrame:CGRectMake(0, 0, 150, CGRectGetHeight([contentView bounds]) - 200.0)];
        var metaDataArea = [[MetaDataArea alloc] init];
        var contentArea = [[ContentArea alloc] initWithFrame:CGRectMake(0, 0, CGRectGetWidth([contentView bounds]) - 150, CGRectGetHeight([contentView bounds])-150)];

        //[navigationMetaSplit setVertical:NO];
        //[navigationMetaSplit addSubview:navigationArea];
        //[navigationMetaSplit addSubview:metaDataArea];

        //[contentNavigationSplit addSubview:navigationMetaSplit];
        [contentNavigationSplit addSubview:contentArea];

        var toolbar = [[MainToolbar alloc] initWithIdentifier:"Herramientas"];
        [self setToolbar:toolbar];

        [contentView addSubview:contentNavigationSplit];

    }
    return self;

}

@end
