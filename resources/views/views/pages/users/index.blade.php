@extends('views.main')
@section('title', '| User')
@section('breadcrumb1', 'User')
@section('breadcrumb2', 'User')

@section('content')
    <div class="row">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah User</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm"
                                                style="background-color: #fbc02d; color: white;">Edit</a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm"
                                                    style="background-color: #ff5252; color:black;">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
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
        @endsection