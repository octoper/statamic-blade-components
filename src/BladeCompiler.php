<?php

namespace Octoper\BladeComponents;

use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\ViewFinderInterface;
use InvalidArgumentException;

trait BladeCompiler
{
    /**
     * Get the component class for a given component alias.
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function componentClass(string $component)
    {
        $viewFactory = Container::getInstance()->make(Factory::class);

        if (isset($this->aliases[$component])) {
            if (class_exists($alias = $this->aliases[$component])) {
                return $alias;
            }

            if ($viewFactory->exists($alias)) {
                return $alias;
            }

            throw new InvalidArgumentException("Unable to locate class or view [{$alias}] for component [{$component}].");
        }

        if ($class = $this->findClassByComponent($component)) {
            return $class;
        }

        if (class_exists($class = $this->guessClassName($component))) {
            return $class;
        }

        if ($viewFactory->exists($view = $this->guessViewName($component))) {
            return $view;
        }

        throw new InvalidArgumentException("Unable to locate a class or view for component [{$component}].");
    }

    /**
     * Find the class for the given component using the registered namespaces.
     *
     * @return string|null
     */
    public function findClassByComponent(string $component)
    {
        $segments = explode('::', $component);

        $prefix = $segments[0];

        if (!isset($this->namespaces[$prefix]) || !isset($segments[1])) {
            return;
        }

        if (class_exists($class = $this->namespaces[$prefix].'\\'.$this->formatClassName($segments[1]))) {
            return $class;
        }
    }

    /**
     * Guess the class name for the given component.
     *
     * @return string
     */
    public function guessClassName(string $component)
    {
        $namespace = Container::getInstance()
                    ->make(Application::class)
                    ->getNamespace();

        $class = $this->formatClassName($component);

        return $namespace.'View\\Components\\'.$class;
    }

    /**
     * Format the class name for the given component.
     *
     * @return string
     */
    public function formatClassName(string $component)
    {
        $componentPieces = array_map(function ($componentPiece) {
            return ucfirst(Str::camel($componentPiece));
        }, explode('.', $component));

        return implode('\\', $componentPieces);
    }

    /**
     * Guess the view name for the given component.
     *
     * @param string $name
     *
     * @return string
     */
    public function guessViewName($name)
    {
        $prefix = 'components.';

        $delimiter = ViewFinderInterface::HINT_PATH_DELIMITER;

        if (Str::contains($name, $delimiter)) {
            return Str::replaceFirst($delimiter, $delimiter.$prefix, $name);
        }

        return $prefix.$name;
    }

    /**
     * Creates attributes tags.
     *
     * @return string
     */
    protected function createAttributes(array $attributes)
    {
        return (new ComponentAttributeBag($attributes))->toHtml();
    }

    /**
     * Created a view based on a string.
     *
     * @return string
     */
    protected function createViewFromString(Factory $factory, string $contents)
    {
        $factory->addNamespace(
            '__components',
            $directory = Container::getInstance()['config']->get('view.compiled')
        );

        if (!file_exists($viewFile = $directory.'/'.sha1($contents).'.php')) {
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            file_put_contents($viewFile, $contents);
        }

        return '__components::'.basename($viewFile, '.php');
    }
}
