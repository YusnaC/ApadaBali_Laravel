@extends('layouts.app')

@section('title', 'Tambah Data Drafter')

@section('content')

     <!-- Back Button -->
     <div class="mb-4 ms-5">
        <a href="{{ route('tables.drafter') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
            <i class='bx bx-arrow-back fs-2'></i>
        </a>
    </div>

    <!-- Main Content -->
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-sm rounded-0 p-5">
                <div class="card-body">
                    <h4 class="text-center mb-5 fw-bold">
                        {{ isset($drafter) ? 'Edit Data Drafter' : 'Tambah Data Drafter' }}
                    </h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Section -->
                    <form action="{{ isset($drafter) ? route('drafter.update', $drafter->id_drafter) : route('drafter.store') }}" method="POST">
                        @csrf
                        @if(isset($drafter))
                            @method('PUT')
                        @endif

                        <!-- Row 1: ID Drafter and Username -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_drafter" class="form-label">Id Drafter</label>
                                <input type="text" id="id_drafter" name="id_drafter" 
                                       class="form-control text-secondary @error('id_drafter') is-invalid @enderror" 
                                       value="{{ old('id_drafter', isset($drafter) ? $drafter->id_drafter : $newId) }}" readonly>
                                @error('id_drafter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" 
                                       class="form-control @error('username') is-invalid @enderror"
                                       value="{{ isset($drafter) ? $drafter->username : old('username') }}">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Password and Email -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" 
                                       class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" 
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ isset($drafter) ? $drafter->email : old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 3: Nama and No WhatsApp -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_drafter" class="form-label">Nama</label>
                                <input type="text" id="nama_drafter" name="nama_drafter" 
                                       class="form-control @error('nama_drafter') is-invalid @enderror"
                                       value="{{ isset($drafter) ? $drafter->nama_drafter : old('nama_drafter') }}">
                                @error('nama_drafter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="no_whatsapp" class="form-label">No WhatsApp</label>
                                <input type="text" id="no_whatsapp" name="no_whatsapp" 
                                       class="form-control @error('no_whatsapp') is-invalid @enderror"
                                       value="{{ isset($drafter) ? $drafter->no_whatsapp : old('no_whatsapp') }}">
                                @error('no_whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat Section -->
                        <div class="mb-3">
                            <label for="alamat_drafter" class="form-label">Alamat</label>
                            <textarea id="alamat_drafter" name="alamat_drafter" 
                                    class="form-control custom-textarea @error('alamat_drafter') is-invalid @enderror" 
                                    rows="3">{{ isset($drafter) ? $drafter->alamat_drafter : old('alamat_drafter') }}</textarea>
                            @error('alamat_drafter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Save Button -->
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn-save">
                                {{ isset($drafter) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
