@extends('layouts.main')

@section('title', 'Laporan')
@section('content')
<main class="main-content position-relative border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <!-- Grafik Keuangan -->
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Grafik Keuangan (Transaksi Masuk & Keluar)</h6>
                    </div>
                    <div class="card-body p-3">
                        {!! $keuanganChart->container() !!}
                    </div>
                </div>
            </div>

            <!-- Grafik Inventory -->
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Grafik Inventory (Barang Masuk & Keluar)</h6>
                    </div>
                    <div class="card-body p-3">
                        {!! $inventoryChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! $keuanganChart->script() !!}
    {!! $inventoryChart->script() !!}

    <!-- Filter dan Tabel -->
    <div class="card mt-4">
        <div class="card-header pb-0">
            <h6>Data Transaksi</h6>
        </div>
        <div class="card-body">
            <!-- Filter dan Download PDF -->
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                <form method="GET" action="{{ route('laporan.index') }}" class="d-flex align-items-center gap-2">
                    <div class="input-group" style="max-width: 200px;">
                        <span class="input-group-text text-body">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Cari" name="cari" value="{{ request('cari') }}">
                    </div>
                    <select class="form-select" name="bulan" style="width: 150px; height: 38px;">
                        <option value="">Pilih Bulan</option>
                        <option value="1" {{ request('bulan') == '1' ? 'selected' : '' }}>Januari</option>
                        <option value="2" {{ request('bulan') == '2' ? 'selected' : '' }}>Februari</option>
                        <option value="3" {{ request('bulan') == '3' ? 'selected' : '' }}>Maret</option>
                        <option value="4" {{ request('bulan') == '4' ? 'selected' : '' }}>April</option>
                        <option value="5" {{ request('bulan') == '5' ? 'selected' : '' }}>Mei</option>
                        <option value="6" {{ request('bulan') == '6' ? 'selected' : '' }}>Juni</option>
                        <option value="7" {{ request('bulan') == '7' ? 'selected' : '' }}>Juli</option>
                        <option value="8" {{ request('bulan') == '8' ? 'selected' : '' }}>Agustus</option>
                        <option value="9" {{ request('bulan') == '9' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                    </select>
                    <button type="submit" class="btn btn-primary" style="height: 42px;">Filter</button>
                </form>

                <a href="{{ route('laporan.pdf', ['bulan' => request('bulan')]) }}" class="btn btn-primary" style="height: 42px;">Download PDF</a>
            </div>

            <table class="table align-items-center table-sm mb-0" style="font-size: 0.875rem;">
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
                        <td class="text-center">{{ $data['pemasukan'] ?? 0 }}</td>
                        <td class="text-center">{{ $data['pengeluaran'] ?? 0 }}</td>
                        <td class="text-center">{{ $data['selisih'] ?? 0 }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-footer text-center mt-4">
                <a href="{{ route('keuangan.index') }}" class="text-primary">View All >></a>
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
            datasets: [{
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