@extends('layouts.main')

@section('content')
<main class="main-content position-relative border-radius-lg ">
    <div class="container mt-4">
        <h4 class="mb-4">Edit Transaksi</h4>
        <div class="card">
            <div class="card-body">
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
                        <label for="jumlah" class="form-label">Supllier</label>
                        <input type="number" class="form-control" id="supplier" name="supplier" value="{{ $inventory->supplier }}" required>
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
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('innventory.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
