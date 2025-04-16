<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Kasir App</title>
    <link rel="icon" type="image/png" sizes="16x16"
        href="http://45.64.100.26:88/ukk-kasir/public/assets/images/favicon.png">
    <link href="http://45.64.100.26:88/ukk-kasir/public/dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://45.64.100.26:88/ukk-kasir/public/plugins/swal2.css">
</head>

<body>
    <div
        class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <h3>Log In Form</h3>
                            <form action="{{ route('authProcess') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email</label>
                                    <input type="email" name="email" value="" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" name="password" value="" class="form-control"
                                        id="exampleInputPassword1">
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Log
                                    In</button>
                            </form>
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
</body>

</html>
