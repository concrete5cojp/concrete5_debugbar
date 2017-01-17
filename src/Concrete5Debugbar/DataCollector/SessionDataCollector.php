<?php
namespace Concrete5Debugbar\DataCollector;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Session;

class SessionDataCollector extends DataCollector implements Renderable
{
    /**
     * @inheritDoc
     */
    function collect()
    {
        return Session::all();
    }

    /**
     * @inheritDoc
     */
    function getName()
    {
        return 'concrete5session';
    }

    /**
     * @inheritDoc
     */
    function getWidgets()
    {
        return [
            "session" => [
                "icon" => "tags",
                "widget" => "PhpDebugBar.Widgets.VariableListWidget",
                "map" => "concrete5session",
                "default" => "{}"
            ]
        ];
    }

}