<?php

namespace Octoper\StatamicBladeComponents\Tests;

use Statamic\Extend\Manifest;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Octoper\StatamicBladeComponents\StatamicBladeComponentsServiceProvider;
use Statamic\Providers\StatamicServiceProvider;
use Statamic\Statamic;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            StatamicServiceProvider::class,
            StatamicBladeComponentsServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Statamic' => Statamic::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->make(Manifest::class)->manifest = [
            'statamic-package-statamic-blade-components' => [
                'id' => 'octoper/statamic-package-statamic-blade-components',
                'namespace' => 'DoubleThreeDigital\\AddonBoilerplate\\',
            ],
        ];
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $configs = [
            'assets', 'cp', 'forms', 'static_caching',
            'sites', 'stache', 'system', 'users'
        ];

        foreach ($configs as $config) {
            $app['config']->set("statamic.$config", require(__DIR__."/../vendor/statamic/cms/config/{$config}.php"));
        }

        $app['config']->set('statamic.users.repository', 'file');
    }
}
