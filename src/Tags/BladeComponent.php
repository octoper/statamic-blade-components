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

    public function wildcard(string $expression): string
    {
        $compiledBladeView = Blade::compileString(
            <<<EOT
			<x-{$expression} {$this->createAttributes($this->params->toArray())}>{$this->parse()}</x-{$expression}>
			EOT
        );

        $factory = Container::getInstance()->make('view');

        return view($this->createViewFromString($factory, $compiledBladeView))->render();
    }
}
