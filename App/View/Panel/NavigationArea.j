

@import <AppKit/CPCollectionView.j>


@implementation NavigationArea : CPView
{
	CPCollectionView _slideContainer;
}

- (id)initWithFrame(CGRect):aFrame
{
	self = [super initWithFrame:aFrame];

    if(self){

    	[self setBackgroundColor:[CPColor colorWithHexString:"a8c1d3"]];
    	// This view will grow in height, but stay fixed width attached to the left side of the screen.
    	_itemContainer =[[CPCollectionView alloc] initWithFrame:aFrame];


        [_itemContainer setAutoresizingMask: CPViewWidthSizable |CPViewHeightSizable];
        [_itemContainer setMinItemSize:CGSizeMake(180, 100)];
        [_itemContainer setMaxItemSize:CGSizeMake(180, 100)];

        var itemPrototype = [[CPCollectionViewItem alloc] init];
        //var slidePrototype = [[SlidePrototype alloc] initWithFrame:CGRectMakeZero()];

        //[itemPrototype setView:slidePrototype];

        //[_itemContainer setItemPrototype:itemPrototype];

        var scrollView = [[CPScrollView alloc] initWithFrame:aFrame];

        [scrollView setDocumentView:_itemContainer];
        [scrollView setAutoresizingMask: CPViewWidthSizable | CPViewHeightSizable];
        [scrollView setAutohidesScrollers:YES];

        [[scrollView contentView] setBackgroundColor:[CPColor colorWithHexString:"E8EAEE"]];

        [self addSubview:scrollView];

        images = [  [[CPImage alloc]
                        initWithContentsOfFile:"Resources/icon/AddToolbarItem.jpg"
                                          size:CGSizeMake(600.0, 430.0)],
        [[CPImage alloc]
                        initWithContentsOfFile:"Resources/icon/AddToolbarItem.jpg"
                                          size:CGSizeMake(500.0, 430.0)],
        [[CPImage alloc]
                        initWithContentsOfFile:"Resources/icon/AddToolbarItem.jpg"
                                          size:CGSizeMake(500.0, 430.0)],
        [[CPImage alloc]
                        initWithContentsOfFile:"Resources/icon/AddToolbarItem.jpg"
                                          size:CGSizeMake(500.0, 430.0)],
        [[CPImage alloc]
                        initWithContentsOfFile:"Resources/icon/AddToolbarItem.jpg"
                                          size:CGSizeMake(500.0, 430.0)],
        [[CPImage alloc]
                        initWithContentsOfFile:"Resources/icon/AddToolbarItem.jpg"
                                          size:CGSizeMake(500.0, 430.0)],
        [[CPImage alloc]
                        initWithContentsOfFile:"Resources/icon/AddToolbarItem.jpg"
                                          size:CGSizeMake(500.0, 430.0)],
                    [[CPImage alloc]
                        initWithContentsOfFile:"Resources/icon/AddToolbarItem.jpg"
                                          size:CGSizeMake(500.0, 389.0)]];

        [_itemContainer setContent:images];

		[self setAutoresizingMask:CPViewHeightSizable];

    }

    return self;

}

@end
