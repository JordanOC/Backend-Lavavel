<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class ImportProductController extends Controller
{
    public function import()
    {
        Artisan::call('import:products');

        return redirect()->back()->with('success', 'Importação de produtos iniciada com sucesso!');
    }
}
