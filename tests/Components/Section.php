<?php

namespace Octoper\BladeComponents\Tests\Components;

use Illuminate\View\Component;


class Section extends Component {

	public ?string $name;

	public function __construct($name = '')
	{
		$this->name = $name;
	}

	public function render()
	{
		return <<<'blade'
			<div>
				<h1>{{ $name }}</h1>
				<div>{{ $slot }}</div>
			</div>
		blade;
	}
}
