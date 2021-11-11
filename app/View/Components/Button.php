<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
   /**
    * @param string $type
    * @param boolean $disabled
    */
    public function __construct(public string $type = 'primary', public bool $disabled = false)
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
