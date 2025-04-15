<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function exportCsv()
    {
        // Get data from the 'users' table
        $users = User::all();

        // Define the CSV file name
        $csvFileName = 'users.csv';

        // Create a StreamedResponse to stream the CSV content
        $response = new StreamedResponse(function () use ($users) {
            // Open the output stream to write data to the browser
            $handle = fopen('php://output', 'w');
            
            // Add the headers to the CSV file
            fputcsv($handle, ['ID', 'Name', 'Email', 'Created At', 'Updated At']);

            // Add user data to the CSV
            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->created_at,
                    $user->updated_at
                ]);
            }

            // Close the file handle
            fclose($handle);
        });

        // Set the appropriate headers for the CSV download
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $csvFileName . '"');

        // Return the response to download the file
        return $response;
    }
}
