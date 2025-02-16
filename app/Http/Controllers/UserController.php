<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;


class UserController extends Controller
{
    
    public function import(Request $request)
    {
        if ($request->isMethod('post')) {
            
            $request->validate([
                'file' => 'required|mimes:csv,txt',
            ]);

            $file = $request->file('file');
            Excel::import(new ProductsImport, $file);

            return back()->with('success', 'Importação concluída!');
        }

        
        return view('import');
    }
}

