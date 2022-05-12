<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PostExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Post::select('name', 'price')->get();
    }

    public function headings(): array
    {
        return [
            'ten',
            'price'
        ];
    }

    public function prepareRows($rows)
    {
        $sum = 0;
        foreach ($rows as $row) $sum += $row->price;
        $rows[] = [
            'is_summary' => true,
            'total' => $sum
        ];

        return $rows;
    }



    public function map($row): array
    {
        if (isset($row['is_summary']) && $row['is_summary'] === true) {
            //Return a summary row
            return [
                'Total sum:',
                $row['total']
            ];
        } else {
            //Return a normal data row
            return [
                $row->name,
                $row->price
            ];
        }
    }
}
