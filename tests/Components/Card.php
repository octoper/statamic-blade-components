<?php

namespace Octoper\BladeComponents\Tests\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public function render()
    {
        return <<<'blade'
			<div class="card">
				<h1>{{ $title }}</h1>
				<div>{{ $slot }}</div>
			</div>
		blade;
    }
}
