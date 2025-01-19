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
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group" style="max-width: 200px;">
                            <span class="input-group-text text-body">
                                <i class="fas fa-search" aria-hidden="true"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Cari">
                        </div>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tableData as $month => $data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $month }}</td>
                                    <td class="text-center">{{ $data['transaksi'] }}</td>
                                    <td class="text-center">Rp.{{ number_format($data['pemasukan'], 0, ',', '.') }}</td>
                                    <td class="text-center">Rp.{{ number_format($data['pengeluaran'], 0, ',', '.') }}</td>
                                    <td class="text-center">Rp.{{ number_format($data['selisih'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header pb-0">
                <h6>Data Barang</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">NO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Barang</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Kategori</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Jumlah</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangData as $barang)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $barang->nama_barang }}</td>
                                    <td class="text-center">{{ $barang->kategori }}</td>
                                    <td class="text-center">{{ $barang->jumlah }}</td>
                                    <td class="text-center">{{ $barang->tanggal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    const labels = Object.keys(chartData);
    const pemasukanData = Object.values(chartData).map(data => data.pemasukan);
    const pengeluaranData = Object.values(chartData).map(data => data.pengeluaran);

    const ctx = document.getElementById('chart-line').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: pemasukanData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                },
                {
                    label: 'Pengeluaran',
                    data: pengeluaranData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        },
    });
</script>

@endsection
