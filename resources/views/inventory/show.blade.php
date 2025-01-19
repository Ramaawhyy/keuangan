@extends('layouts.main')

@section('content')
<main class="main-content position-relative border-radius-lg">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg" style="width: 700px; border-radius: 15px;">
            <!-- Bagian atas card -->
            <div class="card-header bg-primary text-white text-center" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h4 class="mb-0 font-weight-bold text-white">Detail Barang</h4>
            </div>

            <!-- Bagian bawah card -->
            <div class="card-body bg-white">
                <p><strong>Tanggal:</strong> {{ $inventory->tanggal }}</p>
                <p><strong>Nama Barang:</strong> {{ $inventory->nama_barang }}</p>
                <p><strong>Jumlah:</strong> {{ number_format($inventory->jumlah, 0, ',', '.') }}</p>
                <div class="text-center mt-4">
                    <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
