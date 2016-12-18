<?php
namespace Concrete5Debugbar;

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
        $doctrineDebugStack = new DebugStack();
        \Core::make('Concrete\Core\Database\DatabaseManager')->getConfiguration()->setSQLLogger($doctrineDebugStack);
        $this->addCollector(new DoctrineCollector($doctrineDebugStack));
        // TODO: Concrete5AuthenticationCollector
        // TODO: Concrete5ControllerCollector
        // TODO: Concrete5LoggingCollector
        // TODO: Concrete5RequestCollector
        // TODO: Concrete5RouteCollector
        // TODO: Concrete5ViewCollector
    }
}