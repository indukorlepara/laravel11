<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;  // Import the UsersImport class

class ExcelImportController extends Controller
{
    public function uploadExcel(Request $request)
    {
        // Validate the request to ensure that an Excel file is uploaded
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',  // Max size 10MB
        ]);

        // Handle the file upload
        $file = $request->file('file');
        
        // Import the Excel data
        Excel::import(new UsersImport, $file);

        return response()->json(['message' => 'Excel file imported successfully'], 200);
    }
}

