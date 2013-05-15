

@import <AppKit/CPView.j>


@implementation ToolbarNamedItem : CPView
{

}

- (id) initWithFrame(CGRect):aFrame
{

	self = [super initWithFrame:aFrame];
    if(self){

    }
    return self;
}
-(void)addElement(CPView):anElement
{
    [self addSuview:anElement];
}

@end
