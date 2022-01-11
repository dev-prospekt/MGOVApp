<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ZnsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    public function map($data): array
    {
        return [
            $data->id,
            $data->animal->name,
            $data->animal->latin_name,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Naziv',
            'Latinski naziv',
        ];
    }

    public function query()
    {   
        foreach ($this->data as $item) {   
            return $item;
        }
    }
}
