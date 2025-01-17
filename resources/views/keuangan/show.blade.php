@extends('layouts.main')

@section('content')
<main class="main-content position-relative border-radius-lg ">
    <div class="container mt-4">
        <h4 class="mb-4">Detail Transaksi</h4>
        <div class="card">
            <div class="card-body">
                <p><strong>Tanggal:</strong> {{ $keuangan->tanggal }}</p>
                <p><strong>Deskripsi:</strong> {{ $keuangan->deskripsi }}</p>
                <p><strong>Kategori:</strong> {{ $keuangan->kategori }}</p>
                <p><strong>Jumlah:</strong> Rp.{{ number_format($keuangan->jumlah, 0, ',', '.') }}</p>
                <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</main>
@endsection
