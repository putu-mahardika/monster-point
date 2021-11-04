<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FooterText extends Component
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
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-center small">
                    <div class="text-muted">Copyright &#9400; {{ now()->year }} {{ config('app.name') }}</div>
                </div>
                <div class="d-flex align-items-center justify-content-center small text-muted">
                    All Rights Reserved - @version('compact')
                </div>
            </div>
        blade;
    }
}
