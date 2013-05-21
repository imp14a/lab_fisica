@import <AppKit/CPTabViewItem>

@implementation ImageTabViewitem : CPTabViewItem
{

}

- (id)initWithIdentifier:(CPString)anIdentifier
{
	self = [super initWithIdentifier:anIdentifier];
	if(self)
	{

	}
	return self;
}

- (void)drawLabel:(BOOL)shouldTruncateLabel inRect:(CPRect)tabRect{


    CPImage pImage = [pDelegate imageForCell];

    [[CPGraphicsContext currentContext] saveGraphicsState];
    var xform = [CPAffineTransform transform];
    [xform translateXBy:0.0 yBy: CGRectGetHeight([tabRect bounds])];
    [xform scaleXBy:1.0 yBy:-1.0];
    [xform concat];


    var x_Offset = 0 ;
    if(pImage){
        [pImage drawInRect:CGRectMake(CGRectGetWidth([tabRect bounds])-8,-6,16, 16)fromRect:CGRectMakeZero
                operation:CPCompositeSourceOver
                fraction:1.0];
        x_Offset =  16;
    }
     [[CPGraphicsContext currentContext] restoreGraphicsState];

    [super drawLabel:shouldTruncateLabel inRect:tabRect];
}

@end
