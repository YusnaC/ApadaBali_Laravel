@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="proyek-content">
        <!-- Back Button -->
        <div class="mb-4 ms-5">
            <a href="#" class="text-decoration-none text-dark d-inline-flex align-items-center">
                <i class='bx bx-arrow-back fs-2'></i>
            </a>
        </div>
        <!-- Card -->
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card shadow-sm rounded-0 p-5">
                    <div class="card-body">
                       <div class="row px-5 g-5">
                        <!-- Edit Profile Form -->
                        <div class="col-md-6">
                            <h2 class="fs-4 fw-bold mb-5">Edit Profile</h2>
                            <form>
                            <div class="mb-4">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control text-secondary" id="username" value="Admin">
                            </div>
                            <div class="mb-4">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control text-secondary" id="nama" value="Admin">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control text-secondary" id="email" value="admin@gmail.com">
                            </div>
                            <div class="mb-4">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control custom-textarea text-secondary" id="alamat" rows="3">Jl. Waturenggong Gg. XVIIB Panjer, Denpasar.</textarea>
                            </div>
                            </form>
                        </div>

                        <!-- Change Password Form -->
                        <div class="col-md-6">
                            <h2 class="fs-4 fw-bold mb-5">Change Password</h2>
                            <form>
                            <div class="mb-4">
                                <label for="current-password" class="form-label">Current Password</label>
                                <input type="password" class="form-control text-secondary" id="current-password" value="************">
                            </div>
                            <div class="mb-4">
                                <label for="new-password" class="form-label">New Password</label>
                                <input type="password" class="form-control text-secondary" id="new-password" value="************">
                            </div>
                            <div class="mb-4">
                                <label for="confirm-password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control text-secondary" id="confirm-password" value="************">
                            </div>
                            <div class="d-flex justify-content-end">
                            <button type="submit" class="btn-save">Save</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection