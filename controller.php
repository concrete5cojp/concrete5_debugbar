<?php
namespace Concrete\Package\Debugbar;

use Concrete\Core\Package\Package;
use Concrete\Core\View\View;
use Concrete5Debugbar\Debugbar;
use Database;
use Events;

class Controller extends Package
{
    protected $pkgHandle = 'debugbar';
    protected $appVersionRequired = '8.0.0';
    protected $pkgVersion = '0.1';
    protected $pkgAutoloaderRegistries = [
        'src/Concrete5Debugbar' => 'Concrete5Debugbar'
    ];

    /**
     * Returns the translated name of the package.
     *
     * @return string
     */
    public function getPackageName()
    {
        return t('PHP Debug Bar for concrete5');
    }

    /**
     * Returns the translated package description.
     *
     * @return string
     */
    public function getPackageDescription()
    {
        return t('Displays a debug bar in the browser with information from php.');
    }

    public function on_start()
    {
        require $this->getPackagePath() . '/vendor/autoload.php';

        Events::addListener('on_before_render', function ($event) {
            $debugbar = new Debugbar();
            $debugbarRenderer = $debugbar->getJavascriptRenderer(
                $this->getRelativePath() . '/vendor/maximebf/debugbar/src/DebugBar/Resources'
            );

            $v = $event->getArgument('view');
            $v->addHeaderItem($debugbarRenderer->renderHead());
            $v->addFooterItem($debugbarRenderer->render());
        });
    }
}