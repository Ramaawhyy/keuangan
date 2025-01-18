<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    $transaksiMasuk = DB::table('keuangans')->where('kategori', 'masuk')->sum('jumlah');
    $pengeluaran = DB::table('keuangans')->where('kategori', 'keluar')->sum('jumlah');

    $barangMasuk = DB::table('inventorys')->where('kategori', 'masuk')->sum('jumlah');
    $barangKeluar = DB::table('inventorys')->where('kategori', 'keluar')->sum('jumlah');

    // Kirim data ke view
    return view('dashboard', compact('transaksiMasuk', 'pengeluaran', 'barangMasuk', 'barangKeluar'));
}

}

