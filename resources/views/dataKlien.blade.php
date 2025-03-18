@extends('layouts.app')

@section('title', 'Tambah Data Klien')

@section('content')

    <!-- Back Button -->
    <div class="mb-4 ms-5">
        <a href="{{ route('tables.klien') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
            <i class='bx bx-arrow-back fs-2'></i>
        </a>
    </div>

    <!-- Main Content -->
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-sm rounded-0 p-5">
                <div class="card-body px-5">
                    <h4 class="text-center mb-5 fw-bold">
                        {{ isset($klien) ? 'Edit Data Klien' : 'Tambah Data Klien' }}
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
                    <form action="{{ isset($klien) ? route('klien.update', $klien->id_klien) : route('klien.store') }}" method="POST">
                        @csrf
                        @if(isset($klien))
                            @method('PUT')
                        @endif

                        <!-- Row 1 -->
                        <div class="row mb-4 g-5">
                            <div class="col-md-6">
                                <label for="id_klien" class="form-label">Id Klien</label>
                                <input type="text" id="id_klien" name="id_klien" 
                                       class="form-control text-secondary @error('id_klien') is-invalid @enderror" 
                                       value="{{ old('id_klien', isset($klien) ? $klien->id_klien : $newId) }}" readonly>
                                @error('id_klien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_order" class="form-label">Jenis Order</label>
                                <select id="jenis_order" name="jenis_order" 
                                        class="form-select @error('jenis_order') is-invalid @enderror">
                                    <option value="" disabled selected>Jenis Order</option>
                                    <option value="Proyek Arsitektur" {{ (isset($klien) && $klien->jenis_order == 'Proyek Arsitektur') || old('jenis_order') == 'Proyek Arsitektur' ? 'selected' : '' }}>
                                        Proyek Arsitektur
                                    </option>
                                    <option value="Furniture" {{ (isset($klien) && $klien->jenis_order == 'Furniture') || old('jenis_order') == 'Furniture' ? 'selected' : '' }}>
                                        Furniture
                                    </option>
                                </select>
                                @error('jenis_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="row mb-4 g-5">
                            <div class="col-md-6">
                                <label for="id_order" class="form-label">Id Order</label>
                                <input type="text" id="id_order" name="id_order" 
                                       class="form-control @error('id_order') is-invalid @enderror"
                                       value="{{ isset($klien) ? $klien->id_order : old('id_order') }}">
                                @error('id_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nama_klien" class="form-label">Nama Klien</label>
                                <input type="text" id="nama_klien" name="nama_klien" 
                                       class="form-control @error('nama_klien') is-invalid @enderror"
                                       value="{{ isset($klien) ? $klien->nama_klien : old('nama_klien') }}">
                                @error('nama_klien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 3 -->
                        <div class="row mb-4 g-5">
                            <div class="col-md-6">
                                <label for="alamat_klien" class="form-label">Alamat Klien</label>
                                <input type="text" id="alamat_klien" name="alamat_klien" 
                                       class="form-control @error('alamat_klien') is-invalid @enderror"
                                       value="{{ isset($klien) ? $klien->alamat_klien : old('alamat_klien') }}">
                                @error('alamat_klien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="no_whatsapp" class="form-label">No WhatsApp</label>
                                <input type="text" id="no_whatsapp" name="no_whatsapp" 
                                       class="form-control @error('no_whatsapp') is-invalid @enderror"
                                       value="{{ isset($klien) ? $klien->no_whatsapp : old('no_whatsapp') }}">
                                @error('no_whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn-save">
                                {{ isset($klien) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
