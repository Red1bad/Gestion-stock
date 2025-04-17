<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ProductExport implements FromCollection, WithCustomStartCell,WithHeadings, WithColumnWidths, WithStyles, ShouldAutoSize, WithBackgroundColor
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::join('categories', 'category_id','=' ,'categories.id')
        ->join('suppliers', 'supplier_id','=' ,'suppliers.id')
        ->select('products.id', 'products.name','products.description',  'price', 'categories.name as category',
            DB::raw("CONCAT(suppliers.first_name, ' ', suppliers.last_name) as supplier") )
        ->get();
    }

     /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ['id',
        'name',
        'description',
        'price',
        'category',
        'supplier'];
    }

    public function startCell(): string
    {
        return 'C5';
    }


    // styles ---------------------------------------------------------


    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 8,
            'D' => 25,
            'E' => 50,
            'G' => 25,
            'H' => 25
        ];
    }



    public function backgroundColor()
    {
        // Return RGB color code.
        return 'EFEFEF';

        // Return a Color instance. The fill type will automatically be set to "solid"
        return new Color(Color::COLOR_BLUE);

        // Or return the styles array
        return [
             'fillType'   => Fill::FILL_GRADIENT_LINEAR,
             'startColor' => ['argb' => Color::COLOR_RED],
        ];
    }




    public function styles(Worksheet $sheet)
    {
        $sheet->getRowDimension(5)->setRowHeight(40);

        $sheet->getStyle('C5:H5')->applyFromArray(
            [
                'font' => [
                    'name' => 'Arial',
                    'bold' => true,
                    'italic' => false,
                    'underline' => Font::UNDERLINE_DOUBLE,
                    'strikethrough' => false,
                    'color' => [
                        'rgb' => 'FF0000' // Texte en rouge
                    ],
                    'size' => 11 // Taille de police ajoutée
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THICK,
                        'color' => ['rgb' => '0000FF'],
                    ],
                ],
                'fill' => [ // Ajout d'un fond optionnel
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'ADD8E6' // Bleu clair
                    ]
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'quotePrefix' => true
            ]
        );



        $sheet->getStyle('C6:H108')->applyFromArray(
            [
                'font' => [
                    'name' => 'Arial',
                    'bold' => false,
                    'italic' => false,
                    'strikethrough' => false,
                    'color' => [
                        'rgb' => '000000' // Texte en noir
                    ],
                    'size' => 11
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THICK,
                        'color' => ['rgb' => '00FF00'], // Vert
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'FFFFFF' // Fond blanc
                    ]
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'quotePrefix' => true
            ]
        );
    }

}