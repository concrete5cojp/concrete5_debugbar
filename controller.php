<?php
namespace Concrete\Package\Debugbar;

use Concrete\Core\Package\Package;
use Database;
use Events;

class Controller extends Package
{
    protected $pkgHandle = 'concrete5_debugbar';
    protected $appVersionRequired = '8.3.0';
    protected $pkgVersion = '0.2-dev';
    protected $pkgAutoloaderRegistries = [
        'src/Concrete5Debugbar' => 'Concrete5Debugbar'
    ];

    const PLACEHOLDER_TEXT = '<!-- debugbar:placeholder -->';

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

    /**
     * Install process of the package.
     */
    public function install()
    {
        if (!file_exists($this->getPackagePath().'/vendor/autoload.php')) {
            throw new Exception(t('Required libraries not found.'));
        }
        $this->registerAutoload();
        $pkg = parent::install();
    }

    /**
     * Register autoloader.
     */
    protected function registerAutoload()
    {
        require $this->getPackagePath().'/vendor/autoload.php';
    }

    public function on_start()
    {
        $this->registerAutoload();

        if (!isset($this->app)) {
            $this->app = \Core::make('app');
        }

        $this->app->singleton('debugbar', 'Concrete5Debugbar\Debugbar');
        $this->app->bind('debugbar/renderer', function () {
            $debugbar = $this->app->make('debugbar');
            return $debugbar->getJavascriptRenderer(
                $this->getRelativePath().'/vendor/maximebf/debugbar/src/DebugBar/Resources'
            );
        });
        $this->app->bind('debugbar/messages', function () {
            $debugbar = $this->app->make('debugbar');
            return $debugbar['messages'];
        });
        $this->app->bind('debugbar/time', function () {
            $debugbar = $this->app->make('debugbar');
            return $debugbar['time'];
        });

        Events::addListener('on_before_render', function ($event) {
            $debugbarRenderer = $this->app->make('debugbar/renderer');
            $v = $event->getArgument('view');
            $v->addHeaderItem($debugbarRenderer->renderHead());
            $v->addFooterItem(self::PLACEHOLDER_TEXT);
        });

        Events::addListener('on_page_output', function ($event) {
            $debugbarRenderer = $this->app->make('debugbar/renderer');
            $contents = $event->getArgument('contents');
            $contents = str_replace(self::PLACEHOLDER_TEXT, $debugbarRenderer->render(), $contents);
            $event->setArgument('contents', $contents);
        });
    }
}
