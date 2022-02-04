<?php namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class LeadsExport implements FromArray
{
    private $leads;

    public function __construct($leads)
    {
        $this->leads = $leads;
    }

    public function array(): array
    {
        return $this->leads;
    }
}
