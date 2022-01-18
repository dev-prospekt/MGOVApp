<?php

namespace App\Exports;

use App\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Animal\AnimalItem;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    public function __construct($animalItem, $kvartal)
    {
        $this->animalItem = $animalItem;
        $this->kvartal = $kvartal;
    }

    public function query()
    {
        $collect = collect($this->animalItem);
        $id = $collect->pluck('id');
        $animalItems = AnimalItem::query()->whereIn('id', $id);

        return $animalItems;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'T' => ['font' => ['bold' => true]],
        ];
    }

    public function headings(): array
    {
        return [
            'Naziv oporavilišta',
            'Evidencijski broj životinje',
            'Latinski naziv',
            'Datum zaprimanja u oporavilište',
            'Datum završetka skrbi',
            'Ukupan broj dana proveden u oporavilištu u tom kvartalu',
            'Broj dana solitarne ili grupne skrbi',
            'Broj dana osnovne skrbi',
            'Ukupan trošak osnovne skrbi',
            'Proširena skrb pružena',
            'Broj dana proširene skrbi',
            'Cijena proširene skrbi po danu',
            'Ukupan trošak proširene skrbi',
            'Životinja bila u hibernaciji/estivaciji',
            'Broj dana proveden u hibernaciji',
            'Umanjenje troška za broj dana proveden u hibernaciji',
            'Eutanazija izvršena',
            'Eutanazija izvršena',
            'Cijena eutanazije',
            'Ukupna cijena'
        ];
    }

    public function map($animalItem): array
    {
        $currency = 'kn';
        $kvartal_end_date = Carbon::parse($this->kvartal['kvartal_end_date']);
        $a_start_date = $animalItem->dateRange->start_date;
        $a_end_date = $animalItem->dateRange->end_date;

        // Kraj skrbi
        $end_date = (!empty($animalItem->careEnd) && $a_end_date <= $kvartal_end_date) ? $a_end_date : 'skrb se nastavlja u sljedeće izvještajno razdoblje';
        $check_end_date = Str::is('skrb*', $end_date); // Provjera je li vraca datum ili string

        // Ukupan broj dana proveden u oporavilištu u tom kvartalu
        $totalDays = ((!empty($a_end_date)) && $a_end_date <= $kvartal_end_date) ? $a_end_date->diffInDays($a_start_date).' dana' : 'Nije završena skrb';
        // Ukupni broj dana osnovne skrbi
        $totalDaysCare = (!empty($animalItem->careEnd)) ? $a_end_date->diffInDays($a_start_date).' dana' : 'Nije završena skrb';

        // Trošak osnovne skrbi
        if(!empty($animalItem->careEnd)){
            $hibern_price = isset($animalItem->shelterAnimalPrice->hibern) ? $animalItem->shelterAnimalPrice->hibern : 0;
            $full_care_price = isset($animalItem->shelterAnimalPrice->full_care) ? $animalItem->shelterAnimalPrice->full_care : 0;
            $euthanasia_price = isset($animalItem->euthanasia->price) ? $animalItem->euthanasia->price : 0;
            $solitary_price = isset($animalItem->shelterAnimalPrice->solitary_price) ? $animalItem->shelterAnimalPrice->solitary_price : 0;
            $group_price = isset($animalItem->shelterAnimalPrice->group_price) ? $animalItem->shelterAnimalPrice->group_price : 0;
        }

        // Proširena skrb
        $fullCareDays = 0;
        if($animalItem->dateFullCare){
            foreach ($animalItem->dateFullCare as $item) {
                $totalDaysFullCareStartDate = $item->start_date;
                $totalDaysFullCareEndDate = $item->end_date;
                $fullCareDays = $totalDaysFullCareEndDate->diffInDays($totalDaysFullCareStartDate).' dana';
            }
        }

        // SolitaryorGroup
        $allSolitaryGroup = collect($animalItem->dateSolitaryGroups);
        $solitaryGroup = $allSolitaryGroup->where('end_date', '!=', null)->groupBy('solitary_or_group')->all();
        if (!empty($solitaryGroup)){
            foreach ($solitaryGroup as $item => $value){
                foreach ($value as $v){
                    $solitaryGroupDaysFinish[] = $item.':'.$v->end_date->diffInDays($v->start_date).' dana';
                }
            }
        }

        // Hibernacija
        $hibern = $animalItem->dateRange->hibern_start;
        $hibern_end = $animalItem->dateRange->hibern_end;
        $hibern_start = (isset($hibern)) ? 'da' : 'ne';
        $hibernTotalDay = ($hibern_start == 'da') ? $hibern_end->diffInDays($hibern).' dana' : '0 dana';

        if(isset($solitary_price) || isset($group_price)){
            $totalHiberPriceIsset = (isset($hibern_price)) ? $hibern_price : 0;
            $totalHibernPrice = ($solitary_price + $group_price) - $totalHiberPriceIsset;
        }

        // Euthanasia
        $euthanasia = $animalItem->euthanasia;
        $euthanasiaDaNe = (isset($euthanasia)) ? 'da' : 'ne';
        $euthanasiaPrice = (isset($euthanasia)) ? $euthanasia->price.$currency : '0'.$currency;

        // Izvedeno
        $staffTypeId = (isset($euthanasia)) ? $animalItem->euthanasia->shelterStaff->shelter_staff_type_id : 0;
        $euthanasiatype = '';
        if($staffTypeId != 0){
            if($staffTypeId == '3'){
                $euthanasiatype = 'Izvršeno u oporavilištu';
            }
            elseif($staffTypeId == '4'){
                $euthanasiatype = 'Izvršeno izvan oporavilišta';
            }
            else {
                $euthanasiatype = '';
            }
        }

        // Total price
        $totalPrice = $animalItem->shelterAnimalPrice;
        $totalPrice = (isset($totalPrice)) ? $totalPrice->total_price.$currency : '0'.$currency;

        return [
            $animalItem->shelter->name,
            $animalItem->animal_code, // Unikatni kod za tu jedinku
            $animalItem->animal->latin_name,
            $animalItem->dateRange->start_date->format('d.m.Y'),
            ($check_end_date == true) ? $end_date : $end_date->format('d.m.Y'),
            $totalDays,
            (isset($solitaryGroupDaysFinish)) ? $solitaryGroupDaysFinish : 0,
            $totalDaysCare,
            (isset($solitary_price) && isset($group_price)) ? ($solitary_price + $group_price).$currency : 0,
            ($fullCareDays != 0) ? 'da' : 'ne',
            $fullCareDays,
            '200'.$currency,
            (isset($full_care_price)) ? $full_care_price.$currency : 0,
            $hibern_start,
            $hibernTotalDay,
            ($hibern_start == 'da') ? $totalHibernPrice . $currency : '0'.$currency,
            $euthanasiaDaNe,
            $euthanasiatype,
            $euthanasiaPrice,
            $totalPrice
        ];
    }
}
