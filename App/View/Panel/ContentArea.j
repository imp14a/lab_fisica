

@import <AppKit/CPView.j>
//Qimport "SlidePanel.j"

@implementation ContentArea : CPView
{
	CPWebView _physicsView;
}

- (id) initWithFrame(CGRect):aFrame
{

	self = [super initWithFrame:aFrame];
    if(self){

    	_physicsView = [[CPWebView alloc] initWithFrame:CGRectMake(50, 50,  CGRectGetWidth([self bounds]) - 100, CGRectGetHeight([self bounds]) - 180)];
        [_physicsView setMainFrameURL:"http://labfisica/Service/pages/control/main.php?controller=SimulatorController&action=simulator"];
        [_physicsView setAutoresizingMask:CPViewWidthSizable | CPViewHeightSizable];

        [self addSubview:_physicsView];

        [self setAutoresizingMask:CPViewWidthSizable | CPViewHeightSizable];
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

    var startColor = CGColorCreateGenericRGB(0.5, 0.5, 0.5, 1);
    var endColor = CGColorCreateGenericRGB(1, 1, 1, 1);

    var gradient = CGGradientCreateWithColors(CGColorSpaceCreateDeviceRGB(), [startColor, endColor], [0, 1]);
    CGContextBeginPath(ctx);
    var path = CGPathWithRoundedRectangleInRect(rect, 0, 0, YES, YES, YES, YES);
    CGContextAddPath(ctx, path);
    CGContextClosePath(ctx);
    CGContextDrawLinearGradient(ctx, gradient, CGPointMake(0, 0), CGPointMake(0, rect.size.height), 0);
}

@end
