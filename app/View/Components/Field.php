<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Field extends Component
{
    public $name;
    public $label;
    public $required;
    public $type;
    public $placeholder;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $type = 'text', $label  = null, $required = false, $placeholder =  null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->required = $required;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.field');
    }
}
