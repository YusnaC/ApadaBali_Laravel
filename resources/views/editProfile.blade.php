@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<!-- Back Button -->
<div class="mb-4 ms-5">
    <a href="{{ $user->role === 'admin' ? '/dashboard-admin' : '/dashboard-drafter' }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
        <i class='bx bx-arrow-back fs-2'></i>
    </a>
</div>

<!-- Main Content -->
<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="card shadow-sm rounded-0 p-md-5">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif


                <!-- Form Gabungan -->
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row px-md-5 g-5">
                        <!-- Edit Profile Section -->
                        <div class="col-md-6">
                            <h2 class="fs-4 fw-bold mb-4">Edit Profile</h2>

                            <div class="border p-4 rounded">
                                <div class="mb-4">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control text-secondary @error('username') is-invalid border-danger @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" >
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control text-secondary @error('nama') is-invalid border-danger @enderror" id="name" name="nama" value="{{ old('nama', $user->name) }}" >
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control text-secondary @error('email') is-invalid border-danger @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control text-secondary @error('alamat') is-invalid border-danger @enderror" id="alamat" name="alamat" rows="3" >{{ old('address', $user->address) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Change Password Section -->
                        <div class="col-md-6">
                            <h2 class="fs-4 fw-bold mb-4">Change Password</h2>

                            <div class="border p-4 rounded">
                                <div class="mb-4">
                                    <label for="current-password" class="form-label">Current Password</label>
                                    <input type="password" 
                                        class="form-control text-secondary border @error('current_password') is-invalid border-danger @enderror" 
                                        id="current_password" 
                                        name="current_password" 
                                        placeholder="Masukkan password saat ini"
                                        value="{{ old('current_password') }}">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="new-password" class="form-label">New Password</label>
                                    <input type="password" 
                                        class="form-control text-secondary border @error('password') is-invalid border-danger @enderror" 
                                        id="new-password" 
                                        name="password" 
                                        placeholder="Masukkan password baru">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="confirm-password" class="form-label">Confirm Password</label>
                                    <input type="password" 
                                        class="form-control text-secondary border @error('password_confirmation') is-invalid border-danger @enderror" 
                                        id="confirm-password" 
                                        name="password_confirmation" 
                                        placeholder="Konfirmasi password baru">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn-add px-5 py-3">Simpan</button>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Save -->
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
