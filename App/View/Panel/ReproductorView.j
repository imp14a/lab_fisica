@import <AppKit/CPView.j>

@implementation ReproductorView : CPView
{

}


-(id)initWithFrame(CGRect):aFrame
{
	self = [super initWithFrame:aFrame];

    if(self)
    {
    	var btnNew = [[CPButton alloc] initWithFrame:CGRectMake(0,0,50,48)];
        var imgNew = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/open.png" size:CPSizeMake(32, 32)];

        var btnStart = [[CPButton alloc] initWithFrame:CGRectMake(55,0,50,48)];
        var imgStart = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/start.png" size:CPSizeMake(32, 32)];

        var btnStop = [[CPButton alloc] initWithFrame:CGRectMake(110,0,50,48)];
        var imgStop = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/pause.png" size:CPSizeMake(32, 32)];

        var btnRestart = [[CPButton alloc] initWithFrame:CGRectMake(165,0,50,48)];
        var imgRestart = [[CPImage alloc] initWithContentsOfFile:"Resources/Icons/restart.png" size:CPSizeMake(32, 32)];

        [btnNew setImagePosition:CPImageAbove];
        [btnNew setTitle:"Abrir"];
        [btnNew setBordered:NO];
        [btnNew setImage:imgNew];
        //[btnNew setAlternateImage:imgAddOver];
        [btnStart setImagePosition:CPImageAbove];
        [btnStart setTitle:"Iniciar"];
        [btnStart setBordered:NO];
        [btnStart setImage:imgStart];
        [btnStop setImagePosition:CPImageAbove];
        [btnStop setTitle:"Pausar"];
        [btnStop setBordered:NO];
        [btnStop setImage:imgStop];
        [btnRestart setImagePosition:CPImageAbove];
        [btnRestart setTitle:"Reiniciar"];
        [btnRestart setBordered:NO];
        [btnRestart setImage:imgRestart];

        [self addSubview:btnNew];
        [self addSubview:btnStart];
        [self addSubview:btnStop];
        [self addSubview:btnRestart];
    }
    return self;
}

@end
