<?php
namespace Concrete5Debugbar\DataCollector;

use Concrete\Core\Logging\LogList;
use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;

class LogDataCollector extends DataCollector implements Renderable
{
    /**
     * @inheritDoc
     */
    function collect()
    {
        $list = new LogList();
        $logs = $list->get();

        $data = [];
        foreach ($logs as $log) {
            $data[$log->getDisplayTimestamp()] = $this->getDataFormatter()->formatVar($log->getMessage());
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    function getName()
    {
        return 'concrete5log';
    }

    /**
     * @inheritDoc
     */
    function getWidgets()
    {
        return [
            "logs" => [
                "icon" => "file-archive-o",
                "widget" => "PhpDebugBar.Widgets.VariableListWidget",
                "map" => "concrete5log",
                "default" => "{}"
            ]
        ];
    }

}