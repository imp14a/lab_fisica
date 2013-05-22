
@import <AppKit/CPTabViewItem.j>

@implementation ImageTabViewItem : CPTabViewItem
{
    CPImage _image;
}

- (id)initWithIdentifier:(CPString)anIdentifier andImage:(CPImage)anImage
{
	self = [super initWithIdentifier:anIdentifier];
	if(self)
	{
        _image=anImage;
	}
	return self;
}

- (void)drawLabel:(BOOL)shouldTruncateLabel inRect:(CPRect)tabRect
{
    [[CPGraphicsContext currentContext] saveGraphicsState];
    var xform = [CPAffineTransform transform];
    [xform translateXBy:0.0 yBy: CGRectGetHeight([tabRect bounds])];
    [xform scaleXBy:1.0 yBy:-1.0];
    [xform concat];


    var x_Offset = 0 ;
    if(_image){
        [_image drawInRect:CGRectMake(CGRectGetWidth([tabRect bounds])-8,-6,16, 16)
                fromRect:CGRectMakeZero
                operation:CPCompositeSourceOver
                fraction:1.0];
        x_Offset =  16;
    }
     [[CPGraphicsContext currentContext] restoreGraphicsState];
     CPLog.info("llego hasta aka");
    [super drawLabel:shouldTruncateLabel inRect:tabRect];
}

@end
