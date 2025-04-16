@extends('views.main')
@section('title', '| Penjualan')
@section('breadcrumb1', 'Penjualan')
@section('breadcrumb2', 'Penjualan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-start mb-3">
                            <a href="{{ route('exportExcel') }}" class="btn btn-info">Export Penjualan (.xlsx)</a>
                        </div>
                        @if (Auth::user()->role == 'employee')
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('sales.create') }}" class="btn btn-primary">Tambah Penjualan</a>
                            </div>
                        @endif
                        <!-- Sales Table -->
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Pelanggan</th>
                                        <th scope="col">Tanggal Penjualan</th>
                                        <th scope="col">Total Harga</th>
                                        <th scope="col">Dibuat Oleh</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            @if ($sale->customer)
                                                <td>{{ $sale->customer->name }}</td>
                                            @else
                                                <td>NON-MEMBER</td>
                                            @endif
                                            <td>{{ $sale->sale_date }}</td>
                                            <td>Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                            <td>{{ $sale->user->name }}</td>
                                            <td>
                                                <a href="" data-bs-target="#show-{{ $sale->id }}"
                                                    data-bs-toggle="modal" class="btn btn-sm btn-warning">Lihat</a>
                                                <a href="{{ route('exportPDF', $sale->id) }}"
                                                    class="btn btn-sm btn-primary">Unduh Bukti</a>
                                            </td>
                                        </tr>
                                        <div class="modal" tabindex="-1" id="show-{{ $sale->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLihat">Detail Penjualan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                            <small>
                                                                <strong>Member status : </strong>{{ $sale->customer ? $sale->customer->name : 'Non-Member' }}<br>
                                                                <strong>No HP : </strong>{{ $sale->customer ? $sale->customer->no_hp : '-' }}<br>
                                                                <strong>Poin : </strong>{{ $sale->customer ? $sale->customer->poin : 0 }}
                                                            </small>

                                                            </div>
                                                            <div class="col-6">
                                                                <small>
                                                                    <strong>Bergabung sejak : </strong>{{ $sale->customer ? $sale->customer->created_at->format('d F Y') : '-' }}</strong>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3 text-center mt-5">
                                                            <div class="col-3"><b>Nama Produk</b></div>
                                                            <div class="col-3"><b>Qty</b></div>
                                                            <div class="col-3"><b>Harga</b></div>
                                                            <div class="col-3"><b>Sub Total</b></div>
                                                        </div>
                                                        @foreach ($detail_sale as $item)
                                                            @if ($sale->id == $item->sale_id)
                                                                <div class="row mb-1">
                                                                    <div class="col-3 text-center">
                                                                        {{ $item->product ? $item->product->name : '-' }}
                                                                    </div>
                                                                    <div class="col-3 text-center">{{ $item->quantity }}
                                                                    </div>
                                                                    <div class="col-3 text-center">
                                                                        {{ $item->product ? $item->product->price : '-' }}
                                                                    </div>
                                                                    <div class="col-3 text-center">{{ $item->sub_total }}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        <div class="row text-center mt-3">
                                                            <div class="col-9 text-end"><b>Total</b></div>
                                                            <div class="col-3"><b>{{ $sale->total_pay }}</b></div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <center>
                                                                Dibuat pada: {{ now() }} <br> Oleh: Petugas
                                                            </center>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{ route('sales.index') }}" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="http://45.64.100.26:88/ukk-kasir/public/plugins/swal2.js"></script>
    <script>
        function notif(type, msg) {
            Swal.fire({
                icon: type,
                text: msg
            })
        }
        @if (session('success'))
            notif('success', "{{ session('success') }}")
        @endif
        @if (session('error'))
            notif('error', "{{ session('error') }}")
        @endif
    </script>
@endsection
