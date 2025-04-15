<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;  // Correct namespace for Importable trait

class UsersImport implements ToModel
{
    use Importable;  // This should now work without errors

    public function model(array $row)
    {
        return new User([
            'name' => $row[0],
            'email' => $row[1],
            'password' => bcrypt($row[2]),
        ]);
    }
}
