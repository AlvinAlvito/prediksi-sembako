@extends('layouts.main')

@section('content')
<section class="dashboard">
    <div class="top">
        <i class="uil uil-bars sidebar-toggle"></i>

        <div class="search-box">
            <i class="uil uil-search"></i>
            <input type="text" placeholder="Search here...">
        </div>

        <img src="/images/profil.png" alt="">
    </div>

    <div class="dash-content">
        <div class="activity">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="title">
                    <i class="bi bi-box-seam me-2"></i>
                    <span class="text fs-5">Detail Produk: <strong>{{ $produk->nama_produk }}</strong></span>
                </div>
                <a href="{{ route('hasil.prediksi') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            {{-- Informasi Umum --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-info-circle-fill me-2"></i> Informasi Produk
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li><strong>Harga Satuan:</strong> Rp {{ number_format($produk->harga_satuan) }}</li>
                        <li><strong>Persamaan Regresi:</strong> {{ $regresi->persamaan }}</li>
                        <li><strong>Intercept (a):</strong> {{ round($regresi->a, 2) }}</li>
                        <li><strong>Koefisien (b):</strong> {{ round($regresi->b, 2) }}</li>
                        <li><strong>MAPE:</strong> {{ $regresi->mape }}%</li>
                    </ul>
                </div>
            </div>

            {{-- Tabel Data Aktual --}}
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-bar-chart-fill me-2"></i> Data Penjualan Aktual (Jan–Jun)
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr><th>Bulan</th><th>Penjualan</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($aktual as $bulan => $jumlah)
                                <tr>
                                    <td>{{ $bulan }}</td>
                                    <td>{{ $jumlah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tabel Prediksi --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-graph-up-arrow me-2"></i> Prediksi Penjualan (Jul–Des)
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr><th>Bulan</th><th>Prediksi Penjualan</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($prediksi as $bulan => $jumlah)
                                <tr>
                                    <td>{{ $bulan }}</td>
                                    <td>{{ $jumlah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Grafik Chart.js --}}
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-bar-chart-line-fill me-2"></i> Grafik Penjualan
                </div>
                <div class="card-body">
                    <canvas id="grafikPrediksi"></canvas>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Chart Script --}}
<script>
    const ctx = document.getElementById('grafikPrediksi').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_merge(array_keys($aktual), array_keys($prediksi))) !!},
            datasets: [
                {
                    label: 'Data Aktual',
                    data: {!! json_encode(array_values($aktual)) !!},
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 0, 255, 0.1)',
                    tension: 0.3
                },
                {
                    label: 'Prediksi',
                    data: {!! json_encode(array_values($prediksi)) !!},
                    borderColor: 'red',
                    backgroundColor: 'rgba(255, 0, 0, 0.1)',
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Grafik Penjualan Sembako' }
            }
        }
    });
</script>

{{-- Bootstrap Icons CDN --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
