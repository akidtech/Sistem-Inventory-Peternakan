@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')

    <div class="row mb-3">
        <div class="col-12">
            <h3 class="font-weight-bold">Profil Saya</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('pengaturan.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        {{-- Upload Foto --}}
                        <div class="form-group text-center mb-4">
                            <div class="mb-3">
                                @if ($user->foto)
                                    <img src="{{ asset('uploads/foto/' . $user->foto) }}" id="preview-foto"
                                        class="rounded-circle"
                                        style="width:100px; height:100px; object-fit:cover; border: 3px solid #2E7D32;">
                                @else
                                    <div id="preview-foto-placeholder"
                                        class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width:100px; height:100px; background:#e8f5e9; border: 3px solid #2E7D32; font-size:36px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <img src="" id="preview-foto" class="rounded-circle d-none"
                                        style="width:100px; height:100px; object-fit:cover; border: 3px solid #2E7D32;">
                                @endif
                            </div>
                            <label for="foto" class="btn btn-sm btn-outline-success">
                                <i class="ti-camera mr-1"></i> Ganti Foto
                            </label>
                            <input type="file" name="foto" id="foto" class="d-none"
                                accept="image/jpg,image/jpeg,image/png">
                            <p class="text-muted mt-1" style="font-size:11px">JPG/PNG, maks 2MB</p>
                        </div>

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $user->name) }}">
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No HP</label>
                                    <input type="text" name="no_hp" class="form-control"
                                        value="{{ old('no_hp', $user->no_hp) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Role</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                        </div>

                        <hr>
                        <h6 class="font-weight-bold mb-3">Ganti Password</h6>

                        <div class="form-group">
                            <label>Password Lama</label>
                            <input type="password" name="old_password" class="form-control"
                                placeholder="Masukkan password lama">
                            @error('old_password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Min. 6 karakter">
                                    @error('password')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="ti-save mr-1"></i> Simpan Perubahan
                        </button>

                    </form>
                </div>
            </div>
        </div>

        {{-- Info Akun --}}
        <div class="col-md-5">
            <div class="card">
                <div class="card-body text-center">
                    @if ($user->foto)
                        <img src="{{ asset('uploads/foto/' . $user->foto) }}" class="rounded-circle mb-3"
                            style="width:80px; height:80px; object-fit:cover; border: 3px solid #2E7D32;">
                    @else
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:80px; height:80px; background:#e8f5e9; border: 3px solid #2E7D32; font-size:30px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <h5 class="font-weight-bold">{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                    <span
                        class="badge {{ $user->role == 'admin' ? 'badge-danger' : 'badge-success' }} badge-pill px-3 py-2">
                        {{ ucfirst($user->role) }}
                    </span>
                    <hr>
                    <div class="text-left">
                        <p class="mb-1"><i class="ti-mobile mr-2 text-muted"></i> {{ $user->no_hp ?? '-' }}</p>
                        <p class="mb-1"><i class="ti-location-pin mr-2 text-muted"></i> {{ $user->alamat ?? '-' }}</p>
                        <p class="mb-0"><i class="ti-calendar mr-2 text-muted"></i> Bergabung
                            {{ $user->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('js')
    <script>
        // Preview foto sebelum upload
        document.getElementById('foto').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview-foto');
                    const placeholder = document.getElementById('preview-foto-placeholder');

                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    if (placeholder) placeholder.classList.add('d-none');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
