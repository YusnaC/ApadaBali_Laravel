@extends('layouts.app')

@section('title', isset($proyek) ? 'Edit Data Proyek' : 'Tambah Data Proyek')

@section('content')

    <!-- Back Button -->
    <div class="mb-4 ms-5">
        <a href="/Pencatatan-Proyek" class="text-decoration-none text-dark d-inline-flex align-items-center">
            <i class='bx bx-arrow-back fs-2'></i>
        </a>
    </div>

    <!-- Main Content -->
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-sm rounded-0 p-5">
                <div class="card-body">
                    <h4 class="text-center mb-5 fw-bold">{{ isset($proyek) ? 'Edit Data Proyek' : 'Tambah Data Proyek' }}</h4>
                    
                    <form method="POST" action="{{ isset($proyek) ? route('proyek.update', $proyek->id_proyek) : route('proyek.store') }}">
                        @csrf
                        @if(isset($proyek))
                            @method('PUT') <!-- Tambahkan jika edit -->
                        @endif

                        <div class="row g-3">
                            <!-- Row 1 -->
                            <div class="col-md-4 mb-3">
                                <label for="idProyek" class="form-label">Id Proyek</label>
                                <input name="id_proyek" type="text" class="form-control text-secondary" id="idProyek" 
                                       value="{{ old('id_proyek', isset($proyek) ? $proyek->id_proyek : $newId) }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select name="kategori" class="form-select" id="kategori">
                                    <option disabled {{ !isset($proyek) ? 'selected' : '' }}>Pilih Kategori</option>
                                    <option value="1" {{ old('kategori', isset($proyek) ? $proyek->kategori : '') == 1 ? 'selected' : '' }}>Kategori 1</option>
                                    <option value="2" {{ old('kategori', isset($proyek) ? $proyek->kategori : '') == 2 ? 'selected' : '' }}>Kategori 2</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tglProyek" class="form-label">Tgl Proyek</label>
                                <input name="tgl_proyek" type="date" class="form-control" id="tglProyek"
                                       value="{{ old('tgl_proyek', isset($proyek) ? $proyek->tgl_proyek : '') }}">
                            </div>

                            <!-- Row 2 -->
                            <div class="col-md-4 mb-3">
                                <label for="namaProyek" class="form-label">Nama Proyek</label>
                                <input name="nama_proyek" type="text" class="form-control" id="namaProyek"
                                       value="{{ old('nama_proyek', isset($proyek) ? $proyek->nama_proyek : '') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input name="lokasi" type="text" class="form-control" id="lokasi"
                                       value="{{ old('lokasi', isset($proyek) ? $proyek->lokasi : '') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="luas" class="form-label">Luas</label>
                                <input name="luas" type="number" class="form-control" id="luas"
                                       value="{{ old('luas', isset($proyek) ? $proyek->luas : '') }}">
                            </div>

                            <!-- Row 3 -->
                            <div class="col-md-4 mb-3">
                                <label for="jumlahLantai" class="form-label">Jumlah Lantai</label>
                                <input name="jumlah_lantai" type="number" class="form-control" id="jumlahLantai"
                                       value="{{ old('jumlah_lantai', isset($proyek) ? $proyek->jumlah_lantai : '') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tglDeadline" class="form-label">Tgl Deadline</label>
                                <input name="tgl_deadline" type="date" class="form-control" id="tglDeadline"
                                       value="{{ old('tgl_deadline', isset($proyek) ? $proyek->tgl_deadline : '') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="idDrafter" class="form-label">Id Drafter</label>
                                <select name="id_drafter" class="form-select" id="idDrafter">
                                    <option disabled {{ !isset($proyek) ? 'selected' : '' }}>Pilih Drafter</option>
                                    <option value="1" {{ old('id_drafter', isset($proyek) ? $proyek->id_drafter : '') == 1 ? 'selected' : '' }}>Drafter 1</option>
                                    <option value="2" {{ old('id_drafter', isset($proyek) ? $proyek->id_drafter : '') == 2 ? 'selected' : '' }}>Drafter 2</option>
                                </select>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn-save">{{ isset($proyek) ? 'Update' : 'Simpan' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
