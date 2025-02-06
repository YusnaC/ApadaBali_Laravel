@extends('layouts.app')

@section('title', 'Tambah Data Drafter')

@section('content')

<!-- Back Button -->
<div class="mb-4 ms-5">
    <a href="/Data-Drafter" class="text-decoration-none text-dark d-inline-flex align-items-center">
        <i class='bx bx-arrow-back fs-2'></i>
    </a>
</div>

<!-- Card -->
<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="card shadow-sm rounded-0 p-5">
            <div class="card-body">
                <h4 class="text-center mb-5 fw-bold">Tambah Data Drafter</h4>
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id-drafter" class="form-label">Id Drafter</label>
                            <input type="text" id="id-drafter" class="form-control text-secondary" value="D0001" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" id="nama" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="no-whatsapp" class="form-label">No WhatsApp</label>
                            <input type="text" id="no-whatsapp" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="alamat" class="form-control custom-textarea" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
