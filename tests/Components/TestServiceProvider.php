<?php

namespace Octoper\BladeComponents\Tests\Components;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->callAfterResolving(BladeCompiler::class, function () {
            Blade::component(Hey::class);
            Blade::component(Section::class);
            Blade::component(Card::class);
        });
    }
}
