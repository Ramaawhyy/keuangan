<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategori = $request->kategori;

        $query = Inventory::query();

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $inventory = $query->get();

        // Menghitung total barang masuk dan keluar
        $totalMasuk = Inventory::where('kategori', 'Masuk')->sum('jumlah');
        $totalKeluar = Inventory::where('kategori', 'Keluar')->sum('jumlah');
        $selisih = $totalMasuk - $totalKeluar;

        // Menghitung stok per barang
        $stokBarang = Inventory::select('nama_barang')
            ->selectRaw('SUM(CASE WHEN kategori = "Masuk" THEN jumlah ELSE 0 END) - SUM(CASE WHEN kategori = "Keluar" THEN jumlah ELSE 0 END) as stok')
            ->groupBy('nama_barang')
            ->get();

        return view('inventory.index', compact('inventory', 'totalMasuk', 'totalKeluar', 'stokBarang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.create');
    }

    public function keluar()
    {
        $barangList = Inventory::select('id', 'nama_barang')->get();
        return view('inventory.keluar', compact('barangList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_barang' => 'required|string',
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric',
        ]);

        Inventory::create($request->all());

        return redirect()->route('inventory.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Store barang keluar.
     */
    public function storeKeluar(Request $request)
    {
        // Validasi data input
        $request->validate([
            'id' => 'required|exists:inventorys,id', // 'id' mengacu pada barang yang dipilih
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
        ]);

        // Cari barang berdasarkan ID
        $barang = Inventory::findOrFail($request->id);

        // Validasi stok barang
        $stok = Inventory::where('nama_barang', $barang->nama_barang)
            ->selectRaw('SUM(CASE WHEN kategori = "Masuk" THEN jumlah ELSE 0 END) - SUM(CASE WHEN kategori = "Keluar" THEN jumlah ELSE 0 END) as stok')
            ->groupBy('nama_barang')
            ->value('stok');

        if ($request->jumlah > $stok) {
            return redirect()->back()->withErrors(['Jumlah barang keluar melebihi stok yang tersedia!']);
        }

        // Tambahkan barang keluar
        Inventory::create([
            'tanggal' => $request->tanggal,
            'nama_barang' => $barang->nama_barang, // Menggunakan nama_barang dari barang yang dipilih
            'kategori' => 'Keluar',
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('inventory.index')->with('success', 'Barang Keluar berhasil disimpan!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_barang' => 'required|string',
            'kategori' => 'required|in:Masuk,Keluar',
            'jumlah' => 'required|numeric',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'Barang berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Barang berhasil dihapus!');
    }

    /**
     * Export data to CSV.
     */

    /**
     * Generate monthly report.
     */
    public function laporan()
    {
        $monthlyData = Inventory::selectRaw('MONTH(tanggal) as month, YEAR(tanggal) as year, kategori, SUM(jumlah) as total')
            ->groupBy('month', 'year', 'kategori')
            ->get();

        $formattedData = $monthlyData->groupBy(['year', 'month']);

        return view('laporan.index', compact('formattedData'));
    }
}
