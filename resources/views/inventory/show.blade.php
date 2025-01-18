@extends('layouts.main')

@section('content')
<main class="main-content position-relative border-radius-lg ">
    <div class="container mt-4">
        <h4 class="mb-4 text-white">Detail Barang</h4>
        <div class="card">
            <div class="card-body">
                <p><strong>Tanggal:</strong> {{ $inventory->tanggal }}</p>
                <p><strong>Nama Barang:</strong> {{ $inventory->nama_barang }}</p>
                <p><strong>Supplier:</strong> {{ $inventory->supplier }}</p>
                <p><strong>Jumlah:</strong> {{ number_format($inventory->jumlah, 0, ',', '.') }}</p>
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</main>
@endsection
