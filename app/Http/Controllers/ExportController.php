<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function downloadCsv()
    {
        $fileName = 'data_barang.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');

            // Menulis header kolom ke CSV
            fputcsv($handle, ['No', 'Tanggal', 'Nama Barang', 'Jumlah', 'Supplier']);

            // Ambil data dari database
            $data = DB::table('barang')->select('no', 'tanggal', 'nama_barang', 'jumlah', 'supplier')->get();

            // Menulis data ke CSV
            foreach ($data as $row) {
                fputcsv($handle, [
                    $row->no,
                    $row->tanggal,
                    $row->nama_barang,
                    $row->jumlah,
                    $row->supplier,
                ]);
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}