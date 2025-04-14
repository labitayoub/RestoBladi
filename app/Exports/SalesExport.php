<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class SalesExport implements FromView
{
    protected $sales;
    protected $total;
    protected $from;
    protected $to;

    /**
     * Constructor to initialize the export with required data
     * 
     * @param Collection $sales
     * @param float $total
     * @param string $from
     * @param string $to
     */
    public function __construct($sales, $total, $from, $to)
    {
        $this->sales = $sales;
        $this->total = $total;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * Load the view for export
     *
     * @return View
     */
    public function view(): View
    {
        return view('manager.rapport.export', [
            'sales' => $this->sales,
            'total' => $this->total,
            'from' => $this->from,
            'to' => $this->to
        ]);
    }
}