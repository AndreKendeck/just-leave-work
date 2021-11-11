<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{

    public function __construct(
        public string $name,
        public string | null $label = null,
        public bool $disabled = false,
        public string | null $tooltip = null,
        public bool $required = true,
        public string $type = 'text'
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input');
    }
}
