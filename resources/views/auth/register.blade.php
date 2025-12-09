<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="KediriFishHub - Platform Jual Beli Benih Ikan">
    <title>Register - KediriFishHub</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
<link href="{{ asset('sb-admin-2/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image" style="background: url('{{ asset('img/fish-register.jpg') }}') center center / cover no-repeat; position: relative;">
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(78, 115, 223, 0.7); display: flex; align-items: center; justify-content: center; flex-direction: column; color: white; padding: 2rem;">
                            <i class="fas fa-fish fa-5x mb-4"></i>
                            <h2 class="text-white font-weight-bold">KediriFishHub</h2>
                            <p class="text-center text-white-50">Bergabunglah dan mulai berbisnis benih ikan berkualitas</p>
                            <div class="mt-4">
                                <div class="text-white mb-2">
                                    <i class="fas fa-check-circle mr-2"></i> Akses ke ribuan peternak
                                </div>
                                <div class="text-white mb-2">
                                    <i class="fas fa-check-circle mr-2"></i> Transaksi aman & terpercaya
                                </div>
                                <div class="text-white mb-2">
                                    <i class="fas fa-check-circle mr-2"></i> Gratis untuk bergabung
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Buat Akun Baru!</h1>
                            </div>

                            <form method="POST" action="{{ route('register') }}" class="user">
                                @csrf

                                <!-- Name -->
                                <div class="form-group">
                                    <input type="text" 
                                           class="form-control form-control-user @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           placeholder="Nama Lengkap"
                                           required 
                                           autofocus 
                                           autocomplete="name">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Email Address -->
                                <div class="form-group">
                                    <input type="email" 
                                           class="form-control form-control-user @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           placeholder="Alamat Email"
                                           required 
                                           autocomplete="username">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" 
                                               class="form-control form-control-user @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password"
                                               placeholder="Password"
                                               required 
                                               autocomplete="new-password">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" 
                                               class="form-control form-control-user @error('password_confirmation') is-invalid @enderror" 
                                               id="password_confirmation" 
                                               name="password_confirmation"
                                               placeholder="Ulangi Password"
                                               required 
                                               autocomplete="new-password">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Role Selection -->
                                <div class="form-group">
                                    <label class="small mb-2">Daftar Sebagai:</label>
                                    <div class="row">
                                        <div class="col-sm-6 mb-2">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="role_peternak" name="role" class="custom-control-input" value="peternak" {{ old('role') == 'peternak' ? 'checked' : '' }} required>
                                                <label class="custom-control-label" for="role_peternak">
                                                    <i class="fas fa-user-tie text-primary mr-1"></i> Peternak
                                                </label>
                                            </div>
                                            <small class="text-muted ml-4">Jual benih ikan Anda</small>
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="role_pembudidaya" name="role" class="custom-control-input" value="pembudidaya" {{ old('role') == 'pembudidaya' ? 'checked' : '' }} required>
                                                <label class="custom-control-label" for="role_pembudidaya">
                                                    <i class="fas fa-user text-success mr-1"></i> Pembudidaya
                                                </label>
                                            </div>
                                            <small class="text-muted ml-4">Beli benih ikan berkualitas</small>
                                        </div>
                                    </div>
                                    @error('role')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Terms & Conditions -->
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="terms" name="terms" required>
                                        <label class="custom-control-label" for="terms">
                                            Saya setuju dengan <a href="#" class="text-primary">Syarat & Ketentuan</a>
                                        </label>
                                    </div>
                                    @error('terms')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Daftar Sekarang
                                </button>

                                <hr>

                               
                            </form>

                            <hr>

                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">Sudah punya akun? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>