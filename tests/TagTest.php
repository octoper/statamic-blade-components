<?php

use Octoper\BladeComponents\Tests\TestCase;

uses(TestCase::class);

test('simple hey component', function () {
    $component = renderAntler('{{ component:hey }}');

    expect($component)->toBeRendered(
        <<<'EOF'
		<div>Hey</div>
		EOF
    );
});

test('simple hey component with name attribute', function () {
    $component = renderAntler('{{ component:hey name="Nick" }}');

    expect($component)->toBeRendered(
        <<<'EOF'
		<div>Hey Nick</div>
		EOF
    );
});

test('section component with default slot', function () {
    $component = renderAntler(
        <<<'EOF'
			{{ component:section name="Main" }}
				Main Section
			{{ /component:section }}
		EOF
    );

    expect($component)->toBeRendered(
        <<<'EOF'
			<div>
				<h1>Main</h1>
				<div>Main Section</div>
			</div>
		EOF
    );
});

test('section component with default slot and a Statamic variable', function () {
    $component = renderAntler(
        <<<'EOF'
			{{ component:section name="{name}" }}
				{{ name }} Section
			{{ /component:section }}
		EOF,
        [
            'name' => 'Main',
        ]
    );

    expect($component)->toBeRendered(
        <<<'EOF'
			<div>
				<h1>Main</h1>
				<div>Main Section</div>
			</div>
		EOF
    );
});

test('card component with title slot', function () {
    $component = renderAntler(
        <<<'EOF'
			{{ component:card }}
				<x-slot name="title">
					Hey
				</x-slot>

				Hello
			{{ /component:card }}
		EOF
    );

    expect($component)->toBeRendered(
        <<<'EOF'
			<div class="card">
				<h1>Hey</h1>
				<div>Hello</div>
			</div>
		EOF
    );
});
