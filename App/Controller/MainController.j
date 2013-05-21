@import <Foundation/CPObject.j>

var PropertiesModalWindow = "PropertiesModalWindow",
    WorldModalWindow = "WorldModalWindow",
    MonitorModalWindow = "MonitorModalWindow",
    GraphModalWindow = "GraphModalWindow",
    ScriptModalWindow = "ScriptModalWindow";

@implementation MainController : CPObject
{

}

- (id)init()
{
    self = [super init];
    if(self)
    {
        //Prepara notificaciones

        //MainToolbar
         [[CPNotificationCenter defaultCenter] addObserver:self
            selector:@selector(createAndRunModalWindow:) name:"btnMainToolbar" object:nil];


        //ModalToolbar
         [[CPNotificationCenter defaultCenter] addObserver:self
        selector:@selector(btnModalToolbar:) name:"btnModalToolbar" object:nil];
    }
    return self;
}

- (void)createAndRunModalWindow:(CPNotification)notification
{
    var modalWindow = [[CPWindow alloc] init];

    switch([notification object])
    {
        case PropertiesModalWindow:
            [modalWindow setFrame:CGRectMake(100, 100, 300, 300)];
            [modalWindow setTitle:"Propiedades Iniciales"];

            var toolbarParameters = [[ParametersToolbar alloc] initWithIdentifier:"Popup"];
            [modalWindow setToolbar:toolbarParameters];
            [modalWindow orderFront:self];

            [CPApp runModalForWindow:modalWindow];
        break;
        case WorldModalWindow:
            [modalWindow setFrame:CGRectMake(100, 100, 300, 300)];
            [modalWindow setTitle:"Mundo"];

            var toolbarParameters = [[ParametersToolbar alloc] initWithIdentifier:"Popup"];
            [modalWindow setToolbar:toolbarParameters];
            [modalWindow orderFront:self];

            [CPApp runModalForWindow:modalWindow];
        break;
    }
}

- (void)btnModalToolbar:(CPNotification)notification
{
    switch([notification object])
    {
        case "Cancelar":
            [[CPApp modalWindow] close];
            [CPApp stopModal];
        break;
        case "Aplicar":
            alert("Aplicar");
        break;
    }
}

@end
