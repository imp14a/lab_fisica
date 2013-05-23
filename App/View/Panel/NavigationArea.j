

@import <AppKit/CPCollectionView.j>

@implementation NavigationArea : CPView
{
}

- (id)initWithFrame(CGRect):aFrame
{
	self = [super initWithFrame:aFrame];

    if(self){

        var boxView = [[CPBox alloc] initWithFrame:CGRectMake(10, 10, CGRectGetWidth([self bounds]) - 20, CGRectGetHeight([self bounds]) - 100)];
        [boxView setBackgroundColor:[CPColor lightGrayColor]];
        [boxView setAutoresizingMask:CPViewHeightSizable | CPViewWidthSizable];
        [boxView setBorderType:CPLineBorder];
        [boxView setBorderColor:[CPColor darkGrayColor]];
        [boxView setBoxType:CPBoxCustom];
        [boxView setCornerRadius:5.0];

        var txtTheoryView = [[CPTextField alloc] initWithFrame:CGRectMake(20, 20, CGRectGetWidth([boxView bounds]) - 20,  CGRectGetHeight([boxView bounds]) - 20 )];
        [txtTheoryView setAutoresizingMask:CPViewHeightSizable | CPViewWidthSizable];
        [txtTheoryView setBezeled:YES];
        [txtTheoryView setEditable:NO];


        var tabStyle = [[CPSegmentedControl alloc] initWithFrame:CGRectMake(100,0, CGRectGetWidth([self bounds]), 48)];
        //[tabStyle setAutoresizingMask:CPViewWidthSizable];
        //[tabStyle setMinSize:CGSizeMake(CGRectGetWidth([self bounds]), 48)];
        //[tabStyle setMinSize:CGSizeMake(360, 54)];

        var imageProc = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/proc.png" size:CPSizeMake(20, 20)];
        var imageMarco = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/theory.png" size:CPSizeMake(20, 20)];
        var imagePrint = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/print.png" size:CPSizeMake(20, 20)];
        var imageConclusion = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/conclusion.png" size:CPSizeMake(20, 20)];

        [tabStyle setSegmentCount: 4];
        [tabStyle setSelected:imageMarco forSegment: 0];
        [tabStyle setTarget:self];
        [tabStyle setAction:@selector(tabEvent:)];

        [tabStyle setImage:imageMarco forSegment: 0];
        [tabStyle setImage:imageProc forSegment: 1];
        [tabStyle setImage:imageConclusion forSegment: 2];
        [tabStyle setImage:imagePrint forSegment: 3];
        [tabStyle setWidth:50 forSegment:0];
        [tabStyle setWidth:50 forSegment:1];
        [tabStyle setWidth:50 forSegment:2];
        [tabStyle setWidth:50 forSegment:3];


        [self setBackgroundColor:[CPColor lightGrayColor]];
        [self addSubview:boxView];
        [self addSubview:tabStyle];
        [self addSubview:txtTheoryView];
		[self setAutoresizingMask:CPViewHeightSizable];

    }

    return self;

}

- (void)tabEvent:(id)sender
{

}

@end
