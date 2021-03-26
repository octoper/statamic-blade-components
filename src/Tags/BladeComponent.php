<?php

declare(strict_types=1);

namespace Octoper\BladeComponents\Tags;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Blade;
use Octoper\BladeComponents\BladeCompiler;
use Statamic\Tags\Tags;

class BladeComponent extends Tags
{
    use BladeCompiler;

    /* @var string */
    protected static $handle = 'component';

    /* @var array */
    protected static $aliases = ['x'];

    /**
     * Renders given component to Laravel Blade components
     *
     * @param  string $component
	 *
     * @return string
     */
    public function wildcard(string $component): string
    {
        $compiledBladeView = Blade::compileString(
            <<<EOT
			<x-dynamic-component component="{$component}" {$this->createAttributes($this->params->toArray())}>{$this->parse()}</x-dynamic-component>
			EOT
        );

        $factory = Container::getInstance()->make('view');

        return view($this->createViewFromString($factory, $compiledBladeView))->render();
    }

	/**
	 * Creates an x-slot Laravel Blade component.
	 *
	 * @return string
	 */
	public function slot(): string
	{
		if (!isset($this->params['name']) || empty($this->params['name'])) {
			return '';
		}

		return "<x-slot {$this->createAttributes($this->params->toArray())}>{$this->parse()}</x-slot>";
	}
}
