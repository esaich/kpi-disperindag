<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PegawaiImport;

class ImportController extends Controller
{
    public function index()
    {
        return view('import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new PegawaiImport, $request->file('file'));

        return back()->with('success', 'Data berhasil diimport!');
    }
}
