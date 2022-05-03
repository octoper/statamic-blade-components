<?php

namespace Octoper\BladeComponents;

use Illuminate\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\ComponentAttributeBag;

trait BladeCompiler
{
    /**
     * Creates attributes tags.
     *
     * @param  array<mixed>  $attributes
     * @return string
     */
    protected function createAttributes(array $attributes)
    {
        return (new ComponentAttributeBag($attributes))->toHtml();
    }

    /**
     * Created a view based on a string.
     *
     * @param  \Illuminate\Contracts\View\Factory  $factory
     * @param  string  $contents
     * @return string
     */
    protected function createViewFromString(Factory $factory, string $contents)
    {
        $factory->addNamespace(
            '__components',
            $directory = Container::getInstance()['config']->get('view.compiled')
        );

        if (! file_exists($viewFile = $directory.'/'.sha1($contents).'.php')) {
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            file_put_contents($viewFile, $contents);
        }

        return '__components::'.basename($viewFile, '.php');
    }
}
