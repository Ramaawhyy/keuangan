<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Inventory;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Response;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->kategori;
        $bulan = $request->bulan; // Parameter bulan dari request
    
        $query = Keuangan::query();
    
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
    
        if ($bulan && is_numeric($bulan) && $bulan >= 1 && $bulan <= 12) {
            // Filter data berdasarkan bulan
            $query->whereMonth('tanggal', $bulan);
        }
    
        $keuangans = $query->get();

        $allMonths = [
            'January', 'February', 'March', 'April', 
            'May', 'June', 'July', 'August', 
            'September', 'October', 'November', 'December'
        ];
    
        // Total Pemasukan dan Pengeluaran
        $totalMasuk = $keuangans->where('kategori', 'Masuk')->sum('jumlah');
        $totalKeluar = $keuangans->where('kategori', 'Keluar')->sum('jumlah');
        $selisih = $totalMasuk - $totalKeluar;
    
        // Data untuk grafik (bulan vs jumlah)
        $chartData = $keuangans
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal)->format('F'); // Group by month name
            })
            ->map(function ($group) {
                return [
                    'pemasukan' => $group->where('kategori', 'Masuk')->sum('jumlah'),
                    'pengeluaran' => $group->where('kategori', 'Keluar')->sum('jumlah'),
                ];
            })->toArray();
    
        // Data untuk tabel
        $tableData = $keuangans
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal)->format('F');
            })
            ->map(function ($group) {
                $pemasukan = $group->where('kategori', 'Masuk')->sum('jumlah');
                $pengeluaran = $group->where('kategori', 'Keluar')->sum('jumlah');
                return [
                    'transaksi' => $group->count(),
                    'pemasukan' => $pemasukan,
                    'pengeluaran' => $pengeluaran,
                    'selisih' => $pemasukan - $pengeluaran,
                ];
            });
    
        return view('laporan.index', compact('keuangans', 'totalMasuk', 'totalKeluar', 'selisih', 'chartData', 'tableData'));
    }

    public function downloadPDF(Request $request)
{
    $bulan = $request->bulan;

    $query = Keuangan::query();

    if ($bulan && is_numeric($bulan) && $bulan >= 1 && $bulan <= 12) {
        $query->whereMonth('tanggal', $bulan);
    }

    $keuangans = $query->get();

    // Data untuk tabel
    $tableData = $keuangans
        ->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->tanggal)->format('F');
        })
        ->map(function ($group) {
            $pemasukan = $group->where('kategori', 'Masuk')->sum('jumlah');
            $pengeluaran = $group->where('kategori', 'Keluar')->sum('jumlah');
            return [
                'transaksi' => $group->count(),
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'selisih' => $pemasukan - $pengeluaran,
            ];
        });

    $pdf = PDF::loadView('laporan.pdf', ['tableData' => $tableData]);

    return $pdf->download('laporan-transaksi.pdf');
}

    
    

}
