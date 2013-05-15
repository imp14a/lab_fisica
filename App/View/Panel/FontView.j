


@import <AppKit/CPView.j>


@implementation FontView : CPView
{

}

-(id) initWithFrame(CGRect):aFrame
{
	self = [super initWithFrame:aFrame];

    if(self){

    	var font = [[CPPopUpButton alloc] initWithFrame:CGRectMake( 0,0,80,24 )];
    	var fontSize = [[CPPopUpButton alloc] initWithFrame:CGRectMake( 85,0,55,24 )];

    	var colorButton = [[CPButton alloc] initWithFrame:CGRectMake(145,0,30,24)];

    	var fontStyle = [[CPSegmentedControl alloc] initWithFrame:CGRectMake(180,0,70,24)];
    	var textAlign = [[CPSegmentedControl alloc] initWithFrame:CGRectMake(260,0,70,24)];

    	var imageB = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/format/bold_style.png" size:CPSizeMake(16, 16)];
    	var imageI = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/format/italic_style.png" size:CPSizeMake(16, 16)];
    	var imageU = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/format/underline_style.png" size:CPSizeMake(16, 16)];

    	var imageAL = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/format/aling_left.png" size:CPSizeMake(16, 16)];
    	var imageAC = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/format/aling_center.png" size:CPSizeMake(16, 16)];
    	var imageAR = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/format/aling_right.png" size:CPSizeMake(16, 16)];
    	var imageAJ = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/format/aling_justify.png" size:CPSizeMake(16, 16)];

    	var imageCW = [[CPImage alloc] initWithContentsOfFile:"Resources/icon/format/color_whell.png" size:CPSizeMake(16, 16)];


    	[colorButton setImage:imageCW];

    	[fontStyle setSegmentCount: 3];
    	[fontStyle setTrackingMode: CPSegmentSwitchTrackingSelectAny];
    	[textAlign setSegmentCount: 4];

    	[fontStyle setImage:imageB forSegment: 0];
    	[fontStyle setImage:imageI forSegment: 1];
    	[fontStyle setImage:imageU forSegment: 2];

    	[textAlign setSelected:imageAL forSegment: 0];
    	[textAlign setImage:imageAL forSegment: 0];
    	[textAlign setImage:imageAC forSegment: 1];
    	[textAlign setImage:imageAR forSegment: 2];
    	[textAlign setImage:imageAJ forSegment: 3];

    	//TODO estos se quitaran
    	[font setTitle:"Arial"];
    	[fontSize setTitle:"12"];

    	[self addSubview:font];
    	[self addSubview:fontSize];
    	[self addSubview:colorButton];
    	[self addSubview:fontStyle];
    	[self addSubview:textAlign];

    }

    return self;
       
}

@end
