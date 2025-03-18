@extends('layouts.app')

@section('title', 'Tambah Data Furniture')

@section('content')
    <!-- Back Button -->
    <div class="mb-4 ms-5">
        <a href="{{ route('furniture.index') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
            <i class='bx bx-arrow-back fs-2'></i>
        </a>
    </div>

    <!-- Main Content -->
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-sm rounded-0 p-5">
                <div class="card-body">
                    <h4 class="text-center mb-5 fw-bold">{{ isset($furniture) ? 'Edit' : 'Tambah' }} Data Furniture</h4>

                    <!-- Form Section -->
                    <form action="{{ isset($furniture) ? route('furniture.update', $furniture->id) : route('furniture.store') }}" method="POST">
                        @csrf
                        @if(isset($furniture))
                            @method('PUT')
                        @endif

                        <div class="row g-4 px-5">
                            <!-- Row 1 -->
                            <div class="form-group mb-4">
                                <label class="mb-2">ID Furniture</label>
                                <input type="text" name="id_furniture" class="form-control"
                                    value="{{ old('id_furniture', isset($furniture) ? $furniture->id_furniture : $newId) }}" readonly>

                            </div>
                            <div class="col-md-6">
                                <label for="tgl_pembuatan" class="form-label">Tgl Pembuatan</label>
                                <input type="date" class="form-control @error('tgl_pembuatan') is-invalid @enderror" 
                                    name="tgl_pembuatan" id="tgl_pembuatan" 
                                    value="{{ isset($furniture) ? $furniture->tgl_pembuatan->format('Y-m-d') : old('tgl_pembuatan') }}">
                                @error('tgl_pembuatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Row 2 -->
                            <div class="col-md-6">
                                <label for="nama_furniture" class="form-label">Nama Furniture</label>
                                <input type="text" class="form-control @error('nama_furniture') is-invalid @enderror" 
                                    name="nama_furniture" id="nama_furniture" 
                                    value="{{ isset($furniture) ? $furniture->nama_furniture : old('nama_furniture') }}">
                                @error('nama_furniture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="jumlah_unit" class="form-label">Jumlah Unit</label>
                                <input type="number" class="form-control @error('jumlah_unit') is-invalid @enderror" 
                                    name="jumlah_unit" id="jumlah_unit" 
                                    value="{{ isset($furniture) ? $furniture->jumlah_unit : old('jumlah_unit') }}">
                                @error('jumlah_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Row 3 -->
                            <div class="col-md-6">
                                <label for="harga_unit" class="form-label">Harga Unit</label>
                                <input type="number" class="form-control @error('harga_unit') is-invalid @enderror" 
                                    name="harga_unit" id="harga_unit" 
                                    value="{{ isset($furniture) ? $furniture->harga_unit : old('harga_unit') }}">
                                @error('harga_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                    name="lokasi" id="lokasi" 
                                    value="{{ isset($furniture) ? $furniture->lokasi : old('lokasi') }}">
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Row 4 -->
                            <div class="col-md-6">
                                <label for="tgl_selesai" class="form-label">Tgl Selesai</label>
                                <input type="date" class="form-control @error('tgl_selesai') is-invalid @enderror" 
                                    name="tgl_selesai" id="tgl_selesai" 
                                    value="{{ isset($furniture) ? $furniture->tgl_selesai->format('Y-m-d') : old('tgl_selesai') }}">
                                @error('tgl_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn-save">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection