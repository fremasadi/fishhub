@extends('front.frontapp')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0">Profil Saya</h2>
                <a href="{{ url('/') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ===== TAMPILAN PROFIL ===== --}}
            <div class="card" id="section-view" @if($errors->hasAny(['name','email','no_hp','alamat'])) style="display:none!important" @endif>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Informasi Profil</h5>
                        <button type="button" class="btn btn-primary btn-sm" onclick="showEdit()">
                            <i class="fas fa-pen"></i> Edit Profil
                        </button>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Nama Lengkap</p>
                            <p class="fw-semibold mb-0">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Email</p>
                            <p class="fw-semibold mb-0">{{ $user->email }}</p>
                        </div>
                        <div class="col-12"><hr class="my-1"></div>
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">No. HP</p>
                            <p class="fw-semibold mb-0">{{ $pembudidaya->no_hp ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Alamat</p>
                            <p class="fw-semibold mb-0">{{ $pembudidaya->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== FORM EDIT PROFIL ===== --}}
            <div class="card @if(!$errors->hasAny(['name','email','no_hp','alamat'])) d-none @endif" id="section-edit">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0"><i class="fas fa-pen me-2"></i>Edit Profil</h5>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="showView()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </div>

                    <form action="{{ route('pembudidaya.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h6 class="text-muted mb-3">Informasi Akun</h6>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name"
                                       value="{{ old('name', $user->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email"
                                       value="{{ old('email', $user->email) }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h6 class="text-muted mb-3">Informasi Pembudidaya</h6>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('no_hp') is-invalid @enderror"
                                   id="no_hp" name="no_hp"
                                   value="{{ old('no_hp', $pembudidaya->no_hp ?? '') }}"
                                   placeholder="08xxxxxxxxxx"
                                   required>
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                      id="alamat" name="alamat"
                                      rows="3"
                                      required>{{ old('alamat', $pembudidaya->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="showView()">
                                <i class="fas fa-times"></i> Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ===== FORM UBAH PASSWORD ===== --}}
            <div class="card mt-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Ubah Password</h5>
                        <button type="button" class="btn btn-outline-warning btn-sm" id="btn-toggle-password" onclick="togglePassword()">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>

                    <div id="section-password" class="{{ $errors->hasAny(['current_password','password']) ? '' : 'd-none' }}">
                        <form action="{{ route('pembudidaya.profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                <input type="password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       id="current_password" name="current_password"
                                       required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password"
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                    <input type="password"
                                           class="form-control"
                                           id="password_confirmation" name="password_confirmation"
                                           required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key"></i> Ubah Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showEdit() {
    document.getElementById('section-view').classList.add('d-none');
    document.getElementById('section-edit').classList.remove('d-none');
}

function showView() {
    document.getElementById('section-edit').classList.add('d-none');
    document.getElementById('section-view').classList.remove('d-none');
}

function togglePassword() {
    const section = document.getElementById('section-password');
    const btn = document.getElementById('btn-toggle-password');
    const isHidden = section.classList.toggle('d-none');
    btn.innerHTML = isHidden
        ? '<i class="fas fa-chevron-down"></i>'
        : '<i class="fas fa-chevron-up"></i>';
}
</script>
@endsection
