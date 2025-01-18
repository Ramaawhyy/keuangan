@extends('layouts.main')

@section('content')
<main class="main-content position-relative border-radius-lg">
    <div class="container-fluid py-4">
        

        <!-- Grafik -->
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Sales Overview</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-arrow-up text-success"></i>
                            <span class="font-weight-bold">+50%</span> Sejak Minggu Terakhir
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter dan Tabel -->
        <div class="card mt-4">
            <div class="card-header pb-0">
                <h6>Data Transaksi Bulanan</h6>
            </div>
            <div class="card-body">
                <!-- Filter -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    <!-- Pencarian -->
                    <div class="d-flex align-items-center gap-2">
                        <!-- Search Bar -->
                        <div class="input-group" style="max-width: 200px;">
                            <span class="input-group-text text-body">
                                <i class="fas fa-search" aria-hidden="true"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Cari">
                        </div>

                        <!-- Filter Dropdown -->
                        <select class="form-select" style="width: 100px;">
                            <option selected>Bulan</option>
                            <option>Januari</option>
                            <option>Februari</option>
                            <option>Maret</option>
                            <option>April</option>
                            <option>Mei</option>
                            <option>Juni</option>
                            <option>Juli</option>
                            <option>Agustus</option>
                            <option>September</option>
                            <option>Oktober</option>
                            <option>November</option>
                            <option>Desember</option>
                        </select>
                        <select class="form-select" style="width: 100px;">
                            <option selected>2024</option>
                            <option>2023</option>
                            <option>2022</option>
                        </select>
                    </div>

                    <!-- Tombol Submit -->
                    <button class="btn btn-success">Submit</button>
                </div>

                <!-- Tabel -->
                <div class="table-responsive">
    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">NO</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Bulan</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Transaksi</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Pemasukan</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Pengeluaran</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Selisih</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Jumlah Barang Masuk</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Jumlah Barang Keluar</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Stock Akhir</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td class="text-center">Januari</td>
                <td class="text-center">10</td>
                <td class="text-center">Rp.50.000</td>
                <td class="text-center">Rp.40.000</td>
                <td class="text-center">Rp.10.000</td>
                <td class="text-center">120</td>
                <td class="text-center">100</td>
                <td class="text-center">100</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td class="text-center">Februari</td>
                <td class="text-center">15</td>
                <td class="text-center">Rp.150.000</td>
                <td class="text-center">Rp.100.000</td>
                <td class="text-center">Rp.50.000</td>
                <td class="text-center">150</td>
                <td class="text-center">120</td>
                <td class="text-center">120</td>
            </tr>
            <!-- Tambahkan data lainnya -->
        </tbody>
    </table>
</div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@endsection
