<?php
namespace Concrete5Debugbar;

use Concrete5Debugbar\DataCollector\RequestDataCollector;
use Concrete5Debugbar\DataCollector\SessionDataCollector;
use DebugBar\Bridge\DoctrineCollector;
use DebugBar\DataCollector\MemoryCollector;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DataCollector\PhpInfoCollector;
use DebugBar\DataCollector\TimeDataCollector;
use Doctrine\DBAL\Logging\DebugStack;

class Debugbar extends \DebugBar\DebugBar
{
    /**
     * Debugbar constructor.
     */
    public function __construct()
    {
        $this->addCollector(new PhpInfoCollector());
        $this->addCollector(new MessagesCollector());
        $this->addCollector(new TimeDataCollector());
        $this->addCollector(new MemoryCollector());
        $this->addCollector(new RequestDataCollector());
        $this->addCollector(new SessionDataCollector());
        $doctrineDebugStack = new DebugStack();
        \Core::make('Concrete\Core\Database\DatabaseManager')->getConfiguration()->setSQLLogger($doctrineDebugStack);
        $this->addCollector(new DoctrineCollector($doctrineDebugStack));
        // TODO: AuthenticationCollector: Show currently login user, session, etc.
        // TODO: ControllerCollector: Show info of the controller of current request
        // TODO: EventsCollector: Show all events on current request
        // TODO: RouteCollector: Show info of the route of current request
        // TODO: ViewCollector: Show info of the view of current request
    }
}