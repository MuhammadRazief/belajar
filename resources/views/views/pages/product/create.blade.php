@extends('views.main')
@section('title', '| Produk')
@section('breadcrumb1', 'Produk')
@section('breadcrumb2', 'Produk')

@section('content')
<div class="row">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="input1" class="col-md-12">Nama Produk <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" id="input1" class="form-control" name="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input2" class="col-md-12">Harga  <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" id="input2" class="form-control" name="price">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="input3" class="col-md-12">Gambar Produk  <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="file" id="input3" class="form-control" name="img">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input4" class="col-md-12">Stok  <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" id="input4" class="form-control" name="stock">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary w-25">Simpan</button>
                            </div>
                        </div>
                    </form>
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
    @if(session('success'))
        notif('success', "{{ session('success') }}")
    @endif
    @if(session('error'))
        notif('error', "{{ session('error') }}")
    @endif
</script>

{{-- Tambahkan script ini untuk mengubah input harga menjadi format Rupiah --}}
<script>
    var rupiah = document.getElementById('input2');
    rupiah.addEventListener('keyup', function(e){
        rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split    = number_string.split(','),
        sisa     = split[0].length % 3,
        rupiah     = split[0].substr(0, sisa),
        ribuan     = split[0].substr(sisa).match(/\d{3}/gi);

        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
    }
</script>
@endsection
