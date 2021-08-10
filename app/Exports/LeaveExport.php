<?php

namespace App\Exports;

use App\Leave;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class LeaveExport implements FromView
{

    use Exportable;

    /** @var string */
    protected $month;

    /** @var string */
    protected $year;

    /** @var int */
    protected $teamId;

    /**
     * @param integer $teamId
     * @param string $from
     * @param string $until
     */
    public function __construct(int $teamId, string $month = null, string $year = null)
    {
        $this->month = $month;
        $this->teamId = $teamId;
        $this->year = $year;
    }

    public function view(): View
    {
        $leaveQuery = Leave::query();

        $leaveQuery->where('team_id', $this->teamId);

        if ($this->month) {
            $leaveQuery->whereMonth('from', $this->month);
        }

        if ($this->year) {
            $leaveQuery->whereYear('from', $this->year);
        }

        $leaveQuery->whereNotNull('approved_at');

        $leaves = $leaveQuery->get();

        return view('exports.leaves', [
            'leaves' => $leaves,
        ]);

    }

}
