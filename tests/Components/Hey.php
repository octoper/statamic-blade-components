<?php

namespace Octoper\BladeComponents\Tests\Components;

use Illuminate\View\Component;


class Hey extends Component {

    public ?string $name;

    public function __construct($name = '')
    {
        $this->name = $name;
    }

    public function render()
    {
        return <<<'blade'
            <div>{{ $name ? 'Hey '.$name : 'Hey' }}</div>
        blade;
    }
}
