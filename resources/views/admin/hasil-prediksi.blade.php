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
                <i class="uil uil-clipboard-notes"></i>
                <span class="text">Hasil Prediksi Penjualan (Juli - Desember)</span>
            </div>

            <table id="datatable" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jul</th>
                        <th>Agu</th>
                        <th>Sep</th>
                        <th>Okt</th>
                        <th>Nov</th>
                        <th>Des</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr onclick="window.location='{{ url('/admin/detail-produk/' . $item->produk->id) }}'" style="cursor: pointer;">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->produk->nama_produk }}</td>
                            <td>{{ number_format($item->produk->harga_satuan) }}</td>
                            <td>{{ $item->jul }}</td>
                            <td>{{ $item->agu }}</td>
                            <td>{{ $item->sep }}</td>
                            <td>{{ $item->okt }}</td>
                            <td>{{ $item->nov }}</td>
                            <td>{{ $item->des }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center">Belum ada data prediksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script> $(function () { $('#datatable').DataTable(); }); </script>
@endsection
