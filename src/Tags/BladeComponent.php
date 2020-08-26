<?php

namespace Octoper\BladeComponents\Tags;

use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\ViewFinderInterface;
use Statamic\Tags\Tags;

class BladeComponent extends Tags
{
    protected static $handle = 'component';

    public function wildcard($expression): string
    {
        if (empty($this->componentClass($expression)))
        {
            return "";
        }

        $generated = Blade::compileString(
            <<<EOT
            <x-{$expression} {$this->createAttributes($this->params->toArray())}>{$this->content}</x-{$expression}>
            EOT
        );

        $factory = Container::getInstance()->make('view');

        return view($this->createViewFromString($factory, $generated))->render();
    }

    protected function createAttributes(array $attributes): string
    {
        return (new ComponentAttributeBag($attributes))->toHtml();
    }

    protected function createViewFromString($factory, $contents): string
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

    /**
     * Guess the view name for the given component.
     *
     * @param  string  $name
     * @return string
     */
    protected function guessViewName($name): string
    {
        $prefix = 'components.';

        $delimiter = ViewFinderInterface::HINT_PATH_DELIMITER;

        if (Str::contains($name, $delimiter)) {
            return Str::replaceFirst($delimiter, $delimiter.$prefix, $name);
        }

        return $prefix.$name;
    }

    /**
     * Get the component class for a given component alias.
     *
     * @param  string  $component
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function componentClass(string $component)
    {
        $viewFactory = Container::getInstance()->make(Factory::class);

        if (class_exists($class = $this->guessClassName($component))) {
            return $class;
        }

        if ($viewFactory->exists($view = $this->guessViewName($component))) {
            return $view;
        }

        return;
    }

    /**
     * Guess the class name for the given component.
     *
     * @param  string  $component
     * @return string
     */
    protected function guessClassName(string $component)
    {
        $namespace = Container::getInstance()
            ->make(Application::class)
            ->getNamespace();

        $componentPieces = array_map(function ($componentPiece) {
            return ucfirst(Str::camel($componentPiece));
        }, explode('.', $component));

        return $namespace.'View\\Components\\'.implode('\\', $componentPieces);
    }

}
