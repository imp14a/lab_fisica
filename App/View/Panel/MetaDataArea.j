

@import <AppKit/CPView.j>


@implementation MetaDataArea : CPView
{
    
}

- (id) init
{
    self = [super initWithFrame:CGRectMake(0.0, 0.0, 150.0, 200.0)];
    
    if(self){
        [self setBackgroundColor:[CPColor darkGrayColor]];
        // This view will stay the same size in both directions, and fixed to the lower left corner.
        //[self setAutoresizingMask:CPViewMinYMargin | CPViewMaxXMargin];
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