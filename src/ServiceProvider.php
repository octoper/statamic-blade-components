<?php

namespace Octoper\BladeComponents;

use Octoper\BladeComponents\Tags\BladeComponent;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
	/** @var array<mixed> */
    protected $tags = [
        BladeComponent::class,
    ];
}
