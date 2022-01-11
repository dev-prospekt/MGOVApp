<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ZnsExport implements FromQuery
{
    use Exportable;

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    public function query()
    {
        foreach ($this->data as $item) {
            return $item;
        }
    }
}
