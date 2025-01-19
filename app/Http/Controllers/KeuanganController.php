<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategori = $request->kategori;

        $query = Keuangan::query();

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $keuangans = $query->get();
        
        // Total Pemasukan
        $totalMasuk = $keuangans->where('kategori', 'Masuk')->sum('jumlah');
        
        // Total Pengeluaran
        $totalKeluar = $keuangans->where('kategori', 'Keluar')->sum('jumlah');
        
        // Selisih Pemasukan dan Pengeluaran
        $selisih = $totalMasuk - $totalKeluar;

        return view('keuangan.index', compact('keuangans', 'totalMasuk', 'totalKeluar', 'selisih'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('keuangan.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'jumlah' => 'required|numeric',
        ]);

        Keuangan::create($request->all());
        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function show($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        return view('keuangan.show', compact('keuangan'));
    }

    public function edit($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        return view('keuangan.edit', compact('keuangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'kategori' => 'required|in:Masuk,Keluar',
            'jumlah' => 'required|numeric',
        ]);

        $keuangan = Keuangan::findOrFail($id);
        $keuangan->update($request->all());

        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->forceDelete();
    
        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil dihapus!');
    }    

    public function downloadCsv()
{
    $keuangans = Keuangan::all();

    $filename = "data_keuangan.csv";
    $handle = fopen($filename, 'w+');
    fputcsv($handle, ['Tanggal', 'Deskripsi Transaksi', 'Kategori', 'Jumlah']);

    foreach ($keuangans as $keuangan) {
        fputcsv($handle, [
            $keuangan->tanggal,
            $keuangan->deskripsi,
            $keuangan->kategori,
            $keuangan->jumlah
        ]);
    }

    fclose($handle);

    return response()->download($filename)->deleteFileAfterSend(true);
}

}
