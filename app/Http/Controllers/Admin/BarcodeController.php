<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarcodeController extends Controller
{
    // Generar código de barras en formato HTML
    public function generateHtml($codigo)
    {
        $generator = new BarcodeGeneratorHTML();
        $barcode = $generator->getBarcode($codigo, $generator::TYPE_CODE_128);

        return view('barcode.show', compact('barcode', 'codigo'));
    }

    // Generar código de barras como PNG
    public function generatePng($codigo)
    {
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($codigo, $generator::TYPE_CODE_128);

        return response($barcode)
            ->header('Content-Type', 'image/png');
    }
}

