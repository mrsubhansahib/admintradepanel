<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WithdrawalWidget extends Component
{
    public $bgColor;
    public $route;
    public $count;
    public $description;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($bgColor, $route, $count, $description)
    {
        $this->bgColor = $bgColor;
        $this->route = $route;
        $this->count = $count;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.withdrawal-widget');
    }
}
