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
                <div class="title">
                    <i class="uil uil-chart-line"></i>
                    <span class="text">Koefisien & Intercept Regresi</span>
                </div>

                <table id="datatable" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Persamaan</th>
                            <th>Intercept (a)</th>
                            <th>Koefisien (b)</th>
                            <th>MAPE (%)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr onclick="window.location='{{ url('/admin/detail-produk/' . $item->produk->id) }}'" style="cursor: pointer;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->produk->nama_produk }}</td>
                                <td>{{ number_format($item->produk->harga_satuan) }}</td>
                                <td>{{ $item->persamaan }}</td>
                                <td>{{ round($item->a, 2) }}</td>
                                <td>{{ round($item->b, 2) }}</td>
                                <td>{{ $item->mape }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
