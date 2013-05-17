

@import <AppKit/CPCollectionView.j>


@implementation NavigationArea : CPView
{
}

- (id)initWithFrame(CGRect):aFrame
{
	self = [super initWithFrame:aFrame];

    if(self){

    	[self setBackgroundColor:[CPColor whiteColor]];

        var tabView = [[CPTabView alloc] initWithFrame:CGRectMake(0, 0, CGRectGetWidth([self bounds]), CGRectGetHeight([self bounds]))];

        var theoryTab = [[CPTabViewItem alloc] initWithIdentifier:"theoryTab"];
        [theoryTab setLabel:"Marco Teórico"];
        var theoryView = [[CPView alloc] initWithFrame:CGRectMakeZero()];
        var theoryText = [[CPTextField alloc] initWithFrame:CGRectMake(14,18,CGRectGetWidth([theoryView bounds])-30, CGRectGetHeight([theoryView bounds])-100)];
        [theoryText setStringValue:"MARCO TEÓRICO DE PRÁCTICA"];
        [theoryText setLineBreakMode:CPLineBreakByWordWrapping];
        [theoryText setAutoresizingMask:CPViewWidthSizable | CPViewHeightSizable];
        [theoryText setEditable:NO];
        [theoryText setBezeled:YES];
        [theoryView addSubview:theoryText];
        [theoryTab setView:theoryView];

        var procedureTab = [[CPTabViewItem alloc] initWithIdentifier:"procedureTab"];
        [procedureTab setLabel:"Procedimiento"];
        var procedureView = [[CPView alloc] initWithFrame:CGRectMake(0,0,CGRectGetWidth([tabView bounds]), CGRectGetHeight([tabView bounds]))];
        var procedureText = [[CPTextField alloc] initWithFrame:CGRectMake(14,18,CGRectGetWidth([procedureView bounds])-30, CGRectGetHeight([procedureView bounds])-100)];
        [procedureText setStringValue:"PROCEDIMIENTO DE PRÁCTICA"];
        [procedureText setLineBreakMode:CPLineBreakByWordWrapping];
        [procedureText setAutoresizingMask:CPViewWidthSizable | CPViewHeightSizable];
        [procedureText setEditable:NO];
        [procedureText setBezeled:YES];
        [procedureView addSubview:procedureText];
        [procedureTab setView:procedureView];

        var resultTab = [[CPTabViewItem alloc] initWithIdentifier:"resultTab"];
        [resultTab setLabel:"Resultados"];
        var resultView = [[CPView alloc] initWithFrame:CGRectMakeZero()];
        var resultText = [[CPTextField alloc] initWithFrame:CGRectMake(14,18,CGRectGetWidth([resultView bounds])-30, CGRectGetHeight([resultView bounds])-100)];
        [resultText setStringValue:"RESULTADOS DE PRÁCTICA"];
        [resultText setLineBreakMode:CPLineBreakByWordWrapping];
        [resultText setAutoresizingMask:CPViewWidthSizable | CPViewHeightSizable];
        [resultText setEditable:NO];
        [resultText setBezeled:YES];
        [resultView addSubview:resultText];
        [resultTab setView:resultView];

        var conclusionTab = [[CPTabViewItem alloc] initWithIdentifier:"conclusionTab"];
        [conclusionTab setLabel:"Conclusiones"];
        var conclusionView = [[CPView alloc] initWithFrame:CGRectMakeZero()];
        var conclusionText = [[CPTextField alloc] initWithFrame:CGRectMake(14,18,CGRectGetWidth([conclusionView bounds])-30, CGRectGetHeight([conclusionView bounds])-100)];
        [conclusionText setStringValue:"RESULTADOS DE PRÁCTICA"];
        [conclusionText setLineBreakMode:CPLineBreakByWordWrapping];
        [conclusionText setAutoresizingMask:CPViewWidthSizable | CPViewHeightSizable];
        [conclusionText setEditable:NO];
        [conclusionText setBezeled:YES];
        [conclusionView addSubview:conclusionText];
        [conclusionTab setView:conclusionView];

        [tabView addTabViewItem:theoryTab];
        [tabView addTabViewItem:procedureTab];
        [tabView addTabViewItem:resultTab];
        [tabView addTabViewItem:conclusionTab];

        [tabView setAutoresizingMask:CPViewWidthSizable | CPViewHeightSizable];

        [self addSubview:tabView];

		[self setAutoresizingMask:CPViewHeightSizable];

    }

    return self;

}

@end
