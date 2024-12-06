@extends('layouts.app')

@section('title', 'proyek')

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
                        <h4 class="text-center mb-5 fw-bold">Tambah Data Proyek</h4>
                        <form>
                            <div class="row g-3  ">
                                <!-- Baris 1 -->
                                <div class="col-md-4 mb-3">
                                    <label for="idProyek" class="form-label">Id Proyek</label>
                                    <input type="text" class="form-control text-secondary" id="idProyek" value="ASB0001" disabled>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select class="form-select" id="kategori">
                                        <option selected disabled>Pilih Kategori</option>
                                        <option value="1">Kategori 1</option>
                                        <option value="2">Kategori 2</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tglProyek" class="form-label">Tgl Proyek</label>
                                    <input type="date" class="form-control" id="tglProyek">
                                </div>

                                <!-- Baris 2 -->
                                <div class="col-md-4 mb-3">
                                    <label for="namaProyek" class="form-label">Nama Proyek</label>
                                    <input type="text" class="form-control" id="namaProyek" >
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="lokasi" class="form-label">Lokasi</label>
                                    <input type="text" class="form-control" id="lokasi" >
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="jenis" class="form-label">Jenis</label>
                                    <input type="text" class="form-control" id="jenis" >
                                </div>

                                <!-- Baris 3 -->
                                <div class="col-md-4 mb-3">
                                    <label for="luas" class="form-label">Luas</label>
                                    <input type="number" class="form-control" id="luas" >
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="jumlahLantai" class="form-label">Jumlah Lantai</label>
                                    <input type="number" class="form-control" id="jumlahLantai" >
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tglDeadline" class="form-label">Tgl Deadline</label>
                                    <input type="date" class="form-control" id="tglDeadline">
                                </div>

                                <!-- Baris 4 -->
                                <div class="col-md-4 mb-3">
                                    <label for="idDrafter" class="form-label">Id Drafter</label>
                                    <select class="form-select" id="idDrafter">
                                        <option selected disabled>Pilih Drafter</option>
                                        <option value="1">Drafter 1</option>
                                        <option value="2">Drafter 2</option>
                                    </select>
                                </div>
         
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn-save">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection