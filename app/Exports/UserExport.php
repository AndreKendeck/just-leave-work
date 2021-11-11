<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserExport implements FromView
{
    /** @var bool */
    protected $onlyForCurrentMonth;

    /**
     * @param boolean $onlyForCurrentMonth
     */
    public function __construct(bool $onlyForCurrentMonth = false)
    {
        $this->onlyForCurrentMonth = $onlyForCurrentMonth;
    }

    /**
     * @return View
     */
    public function view(): View
    {

    }
}
