<?php

namespace App\Exports;

use App\Invoice;
use App\Models\Animal\AnimalItem;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function __construct($data)
    {
        $this->data = $data;
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
        $collect = collect($this->data);
        $id = $collect->pluck('id');
        $animalItems = AnimalItem::query()->whereIn('id', $id);

        return $animalItems;
    }
}
