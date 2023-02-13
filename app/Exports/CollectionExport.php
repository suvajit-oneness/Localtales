<?php

namespace App\Exports;

use App\Models\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
// used for autosizing columns
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CollectionExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Collection::all();
    }

    public function map($categories): array
    {
        return [

            $categories->meta_key,
            $categories->title,
            $categories->suburb,
            $categories->category,
            $categories->short_description,
            $categories->paragraph1_heading,
            $categories->paragraph1,
            $categories->paragraph2_heading,
            $categories->paragraph2,
            $categories->paragraph3_heading,
            $categories->paragraph3,
            $categories->google_doc,
            $categories->completion,
            $categories->who,
            $categories->quality_check,
        ];
    }

    public function headings(): array
    {
        return ['Keyword', 'CollectionName','Suburb','Categories','Collection Description','Paragraph1 Heading','Paragraph1 (50-100 words)', 'Paragraph2 Heading','Paragraph 2 (100 - 150 words)','Paragraph3 Heading','Paragraph 3 (100 - 150 words)','Google Doc','Completion','Who?','Quality Checked'];
    }

}

