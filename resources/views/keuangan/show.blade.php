@extends('layouts.main')

@section('content')
<main class="main-content position-relative border-radius-lg">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg" style="width: 700px; border-radius: 15px;">
            <!-- Bagian atas card -->
            <div class="card-header bg-primary text-white text-center" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h4 class="mb-0 font-weight-bold text-white">Detail Transaksi</h4>
            </div>

            <!-- Bagian bawah card -->
            <div class="card-body bg-white">
                <p><strong>Tanggal:</strong> {{ $keuangan->tanggal }}</p>
                <p><strong>Deskripsi:</strong> {{ $keuangan->deskripsi }}</p>
                <p><strong>Kategori:</strong> {{ $keuangan->kategori }}</p>
                <p><strong>Jumlah:</strong> Rp.{{ number_format($keuangan->jumlah, 0, ',', '.') }}</p>
                <div class="text-center">
                    <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
