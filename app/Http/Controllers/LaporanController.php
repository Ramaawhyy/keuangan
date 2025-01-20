<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Inventory;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;

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
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
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



        // Data untuk card
        $transaksiMasuk = DB::table('keuangans')->where('kategori', 'masuk')->sum('jumlah');
        $pengeluaran = DB::table('keuangans')->where('kategori', 'keluar')->sum('jumlah');
        $barangMasuk = DB::table('inventorys')->where('kategori', 'masuk')->sum('jumlah');
        $barangKeluar = DB::table('inventorys')->where('kategori', 'keluar')->sum('jumlah');


        // Data untuk grafik keuangan bulanan
        $keuanganData = [
            'masuk' => [],
            'keluar' => []
        ];

        for ($month = 1; $month <= 12; $month++) {
            // Ambil transaksi masuk berdasarkan bulan
            $masuk = DB::table('keuangans')
                ->where('kategori', 'masuk')
                ->whereMonth('tanggal', $month) // Memastikan mengambil data berdasarkan bulan
                ->sum('jumlah');

            // Ambil transaksi keluar berdasarkan bulan
            $keluar = DB::table('keuangans')
                ->where('kategori', 'keluar')
                ->whereMonth('tanggal', $month) // Memastikan mengambil data berdasarkan bulan
                ->sum('jumlah');

            // Simpan hasil ke dalam array
            $keuanganData['masuk'][] = $masuk;
            $keuanganData['keluar'][] = $keluar;
        }

        // Membuat grafik keuangan dengan ConsoleTVs/Charts
        $keuanganChart = new Chart;
        $keuanganChart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $keuanganChart->dataset('Transaksi Masuk', 'line', $keuanganData['masuk'])->color('#00ff00');
        $keuanganChart->dataset('Transaksi Keluar', 'line', $keuanganData['keluar'])->color('#ff0000');

        // Data untuk grafik inventory
        $inventoryData = [
            'masuk' => $barangMasuk,
            'keluar' => $barangKeluar
        ];

        // Membuat grafik inventory
        $inventoryChart = new Chart;
        $inventoryChart->labels(['Barang Masuk', 'Barang Keluar']);
        $inventoryChart->dataset('Barang Masuk', 'bar', [$barangMasuk, 0])->color('#00ff00');
        $inventoryChart->dataset('Barang Keluar', 'bar', [0, $barangKeluar])->color('#ff0000');



        return view('laporan.index', compact(
            'keuangans',
            'totalMasuk',
            'totalKeluar',
            'selisih',
            'tableData',
            'transaksiMasuk',
            'pengeluaran',
            'barangMasuk',
            'barangKeluar',
            'keuanganChart',
            'inventoryChart',
            'inventoryData'
        ));
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

        $pdf = FacadePdf::loadView('laporan.pdf', ['tableData' => $tableData]);

        return $pdf->download('laporan-transaksi.pdf');
    }
}
