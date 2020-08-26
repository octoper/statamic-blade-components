<?php

namespace Octoper\BladeComponents;

use Octoper\BladeComponents\Tags\BladeComponent;
use Statamic\Providers\AddonServiceProvider;

class BladeComponentsServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        BladeComponent::class,
    ];
}
