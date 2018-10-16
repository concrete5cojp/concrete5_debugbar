<?php
namespace Concrete5Debugbar\DataCollector;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;

class EnvironmentDataCollector extends DataCollector implements Renderable
{
    public function collect()
    {
        $data['variables'] = $this->getDataFormatter()->formatVar(get_defined_vars());
        $data['server']    = $this->getDataFormatter()->formatVar($_SERVER);
        $data['classes']   = $this->getDataFormatter()->formatVar(get_declared_classes());
        $data['functions'] = $this->getDataFormatter()->formatVar(get_defined_functions());
        $data['constants'] = $this->getDataFormatter()->formatVar(get_defined_constants());

        return $data;
    }

    public function getName()
    {
        return 'environment';
    }

    public function getWidgets()
    {
        return [
            "environment" => [
                "icon" => "file-archive-o",
                "widget" => "PhpDebugBar.Widgets.VariableListWidget",
                "map" => "environment",
                "default" => "{}",
            ],
        ];
    }
}
