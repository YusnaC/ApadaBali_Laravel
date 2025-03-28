@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<!-- Back Button -->
<div class="mb-4 ms-5">
    <a href="{{ url()->previous() }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
        <i class='bx bx-arrow-back fs-2'></i>
    </a>
</div>

<!-- Main Content -->
<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="card shadow-sm rounded-0 p-5">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Gabungan -->
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row px-5 g-5">
                        <!-- Edit Profile Section -->
                        <div class="col-md-6">
                            <h2 class="fs-4 fw-bold mb-4">Edit Profile</h2>

                            <div class="border p-4 rounded">
                                <div class="mb-4">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control text-secondary border" id="username" name="username" value="{{ old('username', $user->username) }}">
                                </div>
                                <div class="mb-4">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control text-secondary border" id="name" name="nama" value="{{ old('nama', $user->username) }}">
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control text-secondary border" id="email" name="email" value="{{ old('email', $user->email) }}">
                                </div>
                                <div class="mb-4">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control text-secondary border" id="alamat" name="alamat" rows="3">{{ old('alamat', $user->address) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Change Password Section -->
                        <div class="col-md-6">
                            <h2 class="fs-4 fw-bold mb-4">Change Password</h2>

                            <div class="border p-4 rounded">
                                <div class="mb-4">
                                    <label for="current-password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control text-secondary border" id="current-password" name="current_password" placeholder="Masukkan password saat ini">
                                </div>
                                <div class="mb-4">
                                    <label for="new-password" class="form-label">New Password</label>
                                    <input type="password" class="form-control text-secondary border" id="new-password" name="password" placeholder="Masukkan password baru">
                                </div>
                                <div class="mb-4">
                                    <label for="confirm-password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control text-secondary border" id="confirm-password" name="password_confirmation" placeholder="Konfirmasi password baru">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4 me-5">
                                <button type="submit" class="btn-add px-4 py-3">Save</button>
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
