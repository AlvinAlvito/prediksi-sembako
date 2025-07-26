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
                    <span class="text">Data Penjualan Produk</span>
                </div>

                @if (session('success'))
                    <div class="alert alert-success mt-2">{{ session('success') }}</div>
                @endif

                <div class="row justify-content-end mb-3">
                    <div class="col-lg-3 text-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah"><i
                                class="uil uil-plus"></i> Tambah Data</button>
                    </div>
                </div>

                <table id="datatable" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Jan</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Apr</th>
                            <th>Mei</th>
                            <th>Jun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ number_format($item->harga_satuan) }}</td>
                                <td>{{ $item->jan }}</td>
                                <td>{{ $item->feb }}</td>
                                <td>{{ $item->mar }}</td>
                                <td>{{ $item->apr }}</td>
                                <td>{{ $item->mei }}</td>
                                <td>{{ $item->jun }}</td>
                                <td class="d-flex gap-2">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-link text-primary p-0 m-0" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $item->id }}">
                                        <i class="uil uil-edit"></i>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('penjualan.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0 m-0"><i
                                                class="uil uil-trash-alt"></i></button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Belum ada data penjualan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @foreach ($penjualan as $item)
        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1"
            aria-labelledby="modalEditLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('penjualan.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Data Penjualan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3"><label>Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control"
                                    value="{{ $item->nama_produk }}" required>
                            </div>
                            <div class="mb-3"><label>Harga Satuan</label>
                                <input type="number" name="harga_satuan" class="form-control"
                                    value="{{ $item->harga_satuan }}" required>
                            </div>
                            <div class="row">
                                @foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun'] as $bulan)
                                    <div class="col-6 mb-3">
                                        <label>{{ ucfirst($bulan) }}</label>
                                        <input type="number" name="{{ $bulan }}" class="form-control"
                                            value="{{ $item[$bulan] }}" required>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach


    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('penjualan.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Penjualan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label>Nama Produk</label><input type="text" name="nama_produk"
                                class="form-control" required></div>
                        <div class="mb-3"><label>Harga Satuan</label><input type="number" name="harga_satuan"
                                class="form-control" required></div>
                        <div class="row">
                            @foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun'] as $bulan)
                                <div class="col-6 mb-3">
                                    <label>{{ ucfirst($bulan) }}</label>
                                    <input type="number" name="{{ $bulan }}" class="form-control" required>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
