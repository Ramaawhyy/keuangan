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

        $totalMasuk = Inventory::where('kategori', 'Masuk')->sum('jumlah');
        $totalKeluar = Inventory::where('kategori', 'Keluar')->sum('jumlah');
        $selisih = $totalMasuk - $totalKeluar;

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

    public function laporan()
    {
        $monthlyData = Inventory::selectRaw('MONTH(tanggal) as month, YEAR(tanggal) as year, kategori, SUM(jumlah) as total')
            ->groupBy('month', 'year', 'kategori')
            ->get();

        $formattedData = $monthlyData->groupBy(['year', 'month']);

        return view('laporan.index', compact('formattedData'));
    }


}
