<?php

namespace App\Exports;

use App\Models\BlogCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
// used for autosizing columns
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CategoryExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(Request $request)
    {
        if (!empty($request->term)) {
            dd($request->term);
           $categories =BlogCategory::where('title',$request->term)->get();
        }else{
            $categories= BlogCategory::all();
        }
        return $categories;
    }

    public function map($categories): array
    {
        return [
            $categories->title,
            strip_tags($categories->Description),
            strip_tags($categories->short_content),
            strip_tags($categories->medium_content),
            strip_tags($categories->long_content),
            ($categories->status == 1) ? 'Active' : 'Blocked',
            $categories->created_at,
        ];
    }

    public function headings(): array
    {
        return ['Title', 'Description','Short Content','Medium Content', 'Long Content','Status', 'Created at'];
    }

}

