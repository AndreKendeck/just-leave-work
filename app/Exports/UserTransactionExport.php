<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserTransactionExport implements FromView
{
    /** @var string */
    protected $month;

    /** @var string */
    protected $year;

    /** @var int */
    protected $userId;

    /**
     * @param integer $userId
     * @param string $month
     * @param string $year
     */
    public function __construct(int $userId, string $month = null, string $year = null)
    {
        $this->userId = $userId;
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        $transactions = \App\Transaction::where('user_id', $this->userId)
            ->whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year)
            ->get();

        return view('exports.transactions', [
            'transactions' => $transactions,
        ]);
    }
}
