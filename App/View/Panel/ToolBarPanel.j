

@import <AppKit/CPView.j>


@implementation ToolBarPanel : CPView
{
	CPTextField _title;
	CPToolbar _elementsView;
}

-(id) initWithFrame(CGRect):aFrame andName(CPString):aName
{
	//self = [super initWithFrame:aFrame];

    if(self){
    	
    	/*_elementsView = [[CPToolbar alloc] initWithFrame:CGRectMake(0.0,0.0,CGRectGetWidth(aFrame),CGRectGetHeight(aFrame)-30)];
    	[_elementsView setBackgroundColor:[CPColor grayColor]];
    	_title = [[CPTextField alloc] initWithFrame:CGRectMake(0.0,CGRectGetHeight(aFrame)-30,CGRectGetWidth(aFrame),30)];

    	[_title setStringValue:aName];
    	[_title sizeToFit];

    	[_title setCenter: CGPointMake(CGRectGetWidth(aFrame)/2,CGRectGetHeight(aFrame)-15) ];

    	[self addSubview:_elementsView];
    	[self addSubview:_title];*/
    }

    return self;
       
}

-(void)addElement(CPView):anElement
{
	[_elementsView addSubview:anElement];
}
@end
