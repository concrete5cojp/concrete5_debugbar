<?php
namespace Concrete5Debugbar\DataCollector;

use Concrete\Core\Http\Request;
use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;

class RequestDataCollector extends DataCollector implements Renderable
{
    /**
     * @inheritDoc
     */
    function collect()
    {
        /** @var Request $request */
        $request = \Core::make('Concrete\Core\Http\Request');

        $data = array();
        $data['path'] = $this->getDataFormatter()->formatVar($request->getPath());
        $data['query'] = $this->getDataFormatter()->formatVar($request->query);
        $data['cookies'] = $this->getDataFormatter()->formatVar($request->cookies);
        $data['headers'] = $this->getDataFormatter()->formatVar($request->headers);
        $data['host'] = $this->getDataFormatter()->formatVar($request->getHost());
        $data['post'] = $this->getDataFormatter()->formatVar($request->getPort());
        $data['clientip'] = $this->getDataFormatter()->formatVar($request->getClientIp());

        return $data;
    }

    /**
     * @inheritDoc
     */
    function getName()
    {
        return 'concrete5request';
    }

    /**
     * @inheritDoc
     */
    function getWidgets()
    {
        return array(
            "request" => array(
                "icon" => "tags",
                "widget" => "PhpDebugBar.Widgets.VariableListWidget",
                "map" => "concrete5request",
                "default" => "{}"
            )
        );
    }

}