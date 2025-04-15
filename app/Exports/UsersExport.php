<?php
namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class UsersExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * Return the data to be exported.
     */
    public function collection()
    {
        return User::all();  // You can customize this to filter/select columns
    }

    /**
     * Define headings for the Excel file.
     */
    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Created At', 'Updated At'];
    }

    /**
     * Title for the sheet in the Excel file.
     */
    public function title(): string
    {
        return 'Users';
    }
}
