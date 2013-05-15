

@import <AppKit/CPView.j>
//Qimport "SlidePanel.j"

@implementation ContentArea : CPView
{
	CPView _slideArea;
}

- (id) initWithFrame(CGRect):aFrame
{

	self = [super initWithFrame:aFrame];
    if(self){

    	// This view will grow in both height an width.
    	_slideArea = [[CPView alloc] initWithFrame:CGRectMake(30,30, CGRectGetWidth(aFrame) -60, CGRectGetHeight(aFrame) -150) ];

    	
    	[_slideArea setAutoresizingMask:CPViewWidthSizable | CPViewHeightSizable ];

        //TODO quitar esto de aqui

        var backImg = [[CPImage alloc] initWithContentsOfFile:"Resources/default/default-background.jpg" size:CPSizeMake(1024, 840)];

        var imgView = [[CPImageView alloc] initWithFrame:CGRectMake(0,0,1024,840)];

        [imgView setCenter:[_slideArea center]];
        [imgView setImage:backImg];

        [_slideArea addSubview:imgView];

        [self setAutoresizingMask:CPViewWidthSizable | CPViewHeightSizable];
    	[self addSubview:_slideArea];
    }
    return self;
}

- (void)drawRect:(CPRect)rect
{
    var ctx = [[CPGraphicsContext currentContext] graphicsPort];
    var margin = 0;
    rect.origin.x += margin;
    rect.origin.y += margin;
    rect.size.width -= 2*margin;
    rect.size.height -= 2*margin;

    var startColor = CGColorCreateGenericRGB(0.66, 0.75, 0.82, 1);
    var endColor = CGColorCreateGenericRGB(0.4, 0.4, 0.4, 1);

    var gradient = CGGradientCreateWithColors(CGColorSpaceCreateDeviceRGB(), [startColor, endColor], [0, 1]);
    CGContextBeginPath(ctx);
    var path = CGPathWithRoundedRectangleInRect(rect, 0, 0, YES, YES, YES, YES);
    CGContextAddPath(ctx, path);
    CGContextClosePath(ctx);
    CGContextDrawLinearGradient(ctx, gradient, CGPointMake(0, 0), CGPointMake(0, rect.size.height), 0);
}

@end
