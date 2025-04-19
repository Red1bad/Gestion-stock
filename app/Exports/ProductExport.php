<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ProductExport implements FromCollection, WithCustomStartCell,WithHeadings, WithColumnWidths, WithStyles, ShouldAutoSize, WithBackgroundColor, WithDrawings
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
        return ['Id',
        'Name',
        'Description',
        'Price',
        'Category',
        'Supplier'];
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

        // Ajouter le titre
        $sheet->mergeCells('C3:H3');
        $sheet->setCellValue('C3', 'LISTE DES PRODUITS');

        // Style du titre
        $sheet->getStyle('C3')->applyFromArray([
            'font' => [
                'name' => 'Arial',
                'bold' => true,
                'size' => 18,
                'color' => ['rgb' => '000000']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFFF99' // Jaune pâle par exemple
                ]
            ],
        ]);



        // Style de l'en-tête des colonnes

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
                        'color' => ['rgb' => '000000'], // noir
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





        $lastRow = $sheet->getHighestRow(); // détecte la dernière ligne de données


        // Personnaliser tous les cellusles 'C'
        $sheet->getStyle('C6:C' . $lastRow)->applyFromArray([
            'font' => [
                'name' => 'Arial',
                'size' => 11,
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFDDDD', // rouge pâle par exemple
                ],
            ],
        ]);



        // Personnaliser tous les cellusles 'F'
        $sheet->getStyle('F6:F' . $lastRow)->applyFromArray([
            'font' => [
                'name' => 'Arial',
                'size' => 14,
                'bold' => true,
                'color' => ['rgb' => '008000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFD700',
                ],
            ],
        ]);

    }


    /**
     * Insertion du logo
     */
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Company Logo');
        $drawing->setPath(public_path('images/RB5.jpg')); // <-- mets ici le bon chemin vers ton logo
        // $drawing->setPath('C:\Users\DELL\Pictures\RB\RB5.jpg'); // ← sans public_path()
        $drawing->setHeight(90);
        $drawing->setCoordinates('A1'); // Position du logo
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(10);



        // Deuxième image
        $drawing2 = new Drawing();
        $drawing2->setName('Ofppt');
        $drawing2->setDescription('Ofppt');
        $drawing2->setPath(public_path('images/logo.png'));
        $drawing2->setHeight(150);
        $drawing2->setCoordinates('I1');
        $drawing2->setOffsetX(30);
        $drawing2->setOffsetY(30);

        return [$drawing, $drawing2];
    }

}
