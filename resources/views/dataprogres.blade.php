@extends('layouts.app')

@section('title', 'Tambah Data Progress')

@section('content')

    <!-- Back Button -->
    <div class="mb-4 ms-5">
        <a href="/Progres-Proyek" class="text-decoration-none text-dark d-inline-flex align-items-center">
            <i class='bx bx-arrow-back fs-2'></i>
        </a>
    </div>

    <!-- Main Content -->
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-sm rounded-0 p-5">
                <div class="card-body px-5">
                    <h4 class="text-center mb-5 fw-bold">Tambah Data Progres</h4>

                    <!-- Form Section -->
                    <form>
                        <!-- Row 1 -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="id-order" class="form-label">Id Proyek</label>
                                <select id="id-order" class="form-select">
                                    <option value="" disabled selected>Id Proyek</option>
                                    <option value="1">ASB0001</option>
                                    <option value="2">ASB0002</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="tgl-progres" class="form-label">Tgl Progres</label>
                                <input type="date" id="tgl-progres" class="form-control">
                            </div>
                        </div>

                        
                        <div class="row mb-4">
                            <!-- Row 2 -->
                            <div class="mb-4">
                                <label for="termin" class="form-label">Progres</label>
                                <input type="number" id="termin" class="form-control">
                            </div>
                            <!-- Row 3 -->
                            <div class="mb-4">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea id="keterangan" class="form-control custom-textarea" rows="3"></textarea>
                            </div>
                            <!-- row 4 -->
                            <div class="mb-4">
                                <label for="upload" class="form-label">Upload Dokumen</label>
                                <input type="file" id="upload" class="form-control">
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
