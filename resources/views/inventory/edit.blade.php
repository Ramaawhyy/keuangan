@extends('layouts.main')

@section('content')
<main class="main-content position-relative border-radius-lg">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg" style="width: 700px; border-radius: 15px;">
            <!-- Bagian atas card -->
            <div class="card-header bg-primary text-white text-center" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h4 class="mb-0 font-weight-bold text-white">Edit Transaksi</h4>
            </div>
            
            <!-- Bagian bawah card -->
            <div class="card-body bg-white">
                <form action="{{ route('keuangan.update', $inventory->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $inventory->tanggal }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $inventory->nama_barang }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-control" id="kategori" name="kategori" required>
                            <option value="Masuk" {{ $inventory->kategori == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                            <option value="Keluar" {{ $inventory->kategori == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $inventory->jumlah }}" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
