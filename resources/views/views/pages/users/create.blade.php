@extends('views.main') {{-- Tidak perlu menggunakan 'views.' --}}
@section('title', '| User')
@section('breadcrumb1', 'User')
@section('breadcrumb2', 'User')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf {{-- Tambahkan CSRF token --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Nama <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" name="name" class="form-control form-control-line @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Email <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="email" name="email" class="form-control form-control-line @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Role <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <select name="role" class="form-select shadow-none form-control-line @error('role') is-invalid @enderror">
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                                        </select>
                                        @error('role')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Password <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="password" name="password" class="form-control form-control-line @error('password') is-invalid @enderror">
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col text-end">
                                <button type="submit" class="btn btn-primary w-25">Simpan</button>
                            </div>
                        </div>
                    </form>
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
@endsection