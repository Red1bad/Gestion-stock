<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\Product;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    // public function generatePDF()
    // {
    //     $mpdf = new Mpdf();

    //     $html = '<h1>Hello World</h1>';

    //     $mpdf->WriteHTML($html);
    //     return $mpdf->Output('products.pdf', 'I'); // 'I' = Ouvre le PDF directement dans le navigateur

    //     // return $mpdf->Output('products.pdf', 'D'); // 'D' = Force le téléchargement du fichier

    // }


    // avec VUE

    public function generatePDF()
    {

        $products = Product::all();

        // Générer le contenu HTML à partir d'une vue Blade dédiée
        $html = view('pdf.products', compact('products'))->render();

        $mpdf = new Mpdf();

        $mpdf->WriteHTML($html);

        return $mpdf->Output('liste-produits.pdf', 'I'); 
    }
}