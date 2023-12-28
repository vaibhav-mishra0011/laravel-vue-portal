<?php

namespace App\Http\Controllers;

use App\Exports\ClientExport;
use App\Imports\ClientImport;
use App\Models\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Log;

class ClientController extends Controller
{

    public function removeDuplicates(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);


        try {
            $file = $request->file('file');
            Excel::import(new ClientImport, $file);
            $clientData = Excel::toArray([], $file)[0];
            $headers = array_shift($clientData);
            $newClientData = [];

            foreach ($clientData as $row) {
                $email = $row[2];
                $existingClient = Client::where('email', $email)->exists();

                if (!$existingClient) {
                    array_push($newClientData, $row);
                }

            }
            $newClientData = array_merge([$headers], $newClientData);
            Log::debug($newClientData);

            return Excel::download(new ClientExport($newClientData), 'removed_clients.xlsx');

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error during import: ' . $e->getMessage()], 422);
        }
    }

    public function saveData(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        $file = $request->file('file')->store('files');
        Excel::import(new ClientImport, $file);
        Log::debug(request()->all());

        return response()->json(['message' => 'File uploaded and processed successfully']);
    }

}


