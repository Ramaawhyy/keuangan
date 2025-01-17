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

        $query = inventory::query();

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $inventory = $query->get();

        // Total Pemasukan
        $totalMasuk = $inventory->where('kategori', 'Masuk')->sum('jumlah');

        // Total Pengeluaran
        $totalKeluar = $inventory->where('kategori', 'Keluar')->sum('jumlah');

        // Selisih Pemasukan dan Pengeluaran
        $selisih = $totalMasuk - $totalKeluar;

        return view('inventory.index', compact('inventory', 'totalMasuk', 'totalKeluar', 'selisih'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_barang' => 'required|string',
            'supplier' => 'required|string',
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric',
        ]);

        Inventory::create($request->all());
        return redirect()->route('inventory.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('inventory.show', compact('inventory'));
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('inventory.edit', compact('inventory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_barang' => 'required|string',
            'supplier' => 'required|string',
            'kategori' => 'required|in:Masuk,Keluar',
            'jumlah' => 'required|numeric',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Barang berhasil dihapus!');
    }

    public function downloadCsv()
    {
        $inventory = Inventory::all();

        $filename = "data_inventory.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['tanggal', 'nama_barang', 'supplier', 'kategori', 'jumlah']);

        foreach ($inventory as $inventory) {
            fputcsv($handle, [
                $inventory->tanggal,
                $inventory->nama_barang,
                $inventory->kategori,
                $inventory->jumlah
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
