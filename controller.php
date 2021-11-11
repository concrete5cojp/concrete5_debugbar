<?php

namespace Concrete\Package\Concrete5Debugbar;

use Concrete\Core\Package\Package;
use Concrete\Core\Permission\Key\Key;
use Concrete5Debugbar\Debugbar;

class Controller extends Package
{
    const PLACEHOLDER_TEXT = '<!-- debugbar:placeholder -->';
    protected $pkgHandle = 'concrete5_debugbar';
    protected $appVersionRequired = '8.3.0';
    protected $pkgVersion = '0.3';

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
        $this->registerAutoload();

        if (!class_exists('DebugBar\DebugBar')) {
            throw new \Exception(t('Required libraries not found.'));
        }

        $this->installContentFile('config/permissions.xml');

        return parent::install();
    }

    public function on_start()
    {
        $permission = Key::getByHandle('show_debug_bar');

        if ($permission && $permission->validate()) {

            $this->registerAutoload();

            $app = $this->getApplication();

            $app->singleton('debugbar', Debugbar::class);
            $app->bind('debugbar/renderer', function () use ($app) {
                /** @var Debugbar $debugbar */
                $debugbar = $app->make('debugbar');

                return $debugbar->getJavascriptRenderer($this->getRelativePath() . '/vendor/maximebf/debugbar/src/DebugBar/Resources');
            });
            $app->bind('debugbar/messages', function () use ($app) {
                $debugbar = $app->make('debugbar');

                return $debugbar['messages'];
            });
            $app->bind('debugbar/time', function () use ($app) {
                $debugbar = $app->make('debugbar');

                return $debugbar['time'];
            });

            $app->make('director')->addListener('on_before_render', function ($event) use ($app) {
                $debugbarRenderer = $app->make('debugbar/renderer');
                $v = $event->getArgument('view');
                $v->addHeaderItem($debugbarRenderer->renderHead());
                $v->addFooterItem(self::PLACEHOLDER_TEXT);
            });

            $app->make('director')->addListener('on_page_output', function ($event) use ($app) {
                $debugbarRenderer = $app->make('debugbar/renderer');
                $contents = $event->getArgument('contents');
                $contents = str_replace(self::PLACEHOLDER_TEXT, $debugbarRenderer->render(), $contents);
                $event->setArgument('contents', $contents);
            });
        }
    }

    /**
     * Register autoloader.
     */
    protected function registerAutoload()
    {
        if (file_exists($this->getPackagePath() . '/vendor/autoload.php')) {
            require $this->getPackagePath() . '/vendor/autoload.php';
        }
    }
}
