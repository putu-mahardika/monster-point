<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ErrorMessageField extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return <<<'blade'
            <span id="{{ $attributes['for'] }}_error_field" {{ $attributes->merge(['class' => 'small text-danger fst-italic error-field']) }}>{{ $slot }}</span>
        blade;
    }
}
