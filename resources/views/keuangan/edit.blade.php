@extends('layouts.main')

@section('content')
<main class="main-content position-relative border-radius-lg ">
    <div class="container mt-4">
        <h4 class="mb-4">Edit Transaksi</h4>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('keuangan.update', $keuangan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $keuangan->tanggal }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ $keuangan->deskripsi }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-control" id="kategori" name="kategori" required>
                            <option value="Masuk" {{ $keuangan->kategori == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                            <option value="Keluar" {{ $keuangan->kategori == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $keuangan->jumlah }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
