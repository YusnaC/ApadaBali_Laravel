@extends('layouts.app')

@section('title', 'Tambah Data Furniture')

@section('content')

    <!-- Back Button -->
    <div class="mb-4 ms-5">
        <a href="/Pencatatan-Furniture" class="text-decoration-none text-dark d-inline-flex align-items-center">
            <i class='bx bx-arrow-back fs-2'></i>
        </a>
    </div>

   <!-- Main Content -->
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-sm rounded-0 p-5">
                <div class="card-body">
                    <h4 class="text-center mb-5 fw-bold">Tambah Data Furniture</h4>

                    <!-- Form Section -->
                    <form>
                        <div class="row g-4 px-5">
                            <!-- Row 1 -->
                            <div class="col-md-6">
                                <label for="idFurniture" class="form-label">Id Furniture</label>
                                <input type="text" class="form-control text-secondary" id="idFurniture" value="AFB0001" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="tglPembuatan" class="form-label">Tgl Pembuatan</label>
                                <input type="date" class="form-control" id="tglPembuatan">
                            </div>

                            <!-- Row 2 -->
                            <div class="col-md-6">
                                <label for="namaFurniture" class="form-label">Nama Furniture</label>
                                <input type="text" class="form-control" id="namaFurniture">
                            </div>
                            <div class="col-md-6">
                                <label for="jumlahUnit" class="form-label">Jumlah Unit</label>
                                <input type="number" class="form-control" id="jumlahUnit">
                            </div>

                            <!-- Row 3 -->
                            <div class="col-md-6">
                                <label for="hargaUnit" class="form-label">Harga Unit</label>
                                <input type="text" class="form-control" id="hargaUnit">
                            </div>
                            <div class="col-md-6">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input type="text" class="form-control" id="lokasi">
                            </div>

                            <!-- Row 4 -->
                            <div class="col-md-6">
                                <label for="tglSelesai" class="form-label">Tgl Selesai</label>
                                <input type="date" class="form-control" id="tglSelesai">
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
