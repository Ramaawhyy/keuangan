<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Inventory;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->kategori;

        $query = Keuangan::query();

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $keuangans = $query->get();

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
            });

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
}
