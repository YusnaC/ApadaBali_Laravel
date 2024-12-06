@extends('layouts.app')

@section('title', 'editKlien')

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
                    <div class="card-body px-5">
                        <h4 class="text-center mb-5 fw-bold">Ubah Data Klien</h4>
                        <form>
                        <div class="row mb-4 g-5">
                            <div class="col-md-6">
                            <label for="id-klien" class="form-label">Id Klien</label>
                            <input type="text" id="id-klien" class="form-control text-secondary" value="D0001" readonly>
                            </div>
                            <div class="col-md-6">
                            <label for="jenis-order" class="form-label">Jenis Order</label>
                            <select id="jenis-order" class="form-select">
                                <option value="" disabled selected>Jenis Order</option>
                                <option value="1">Order 1</option>
                                <option value="2">Order 2</option>
                            </select>
                            </div>
                        </div>
                        <div class="row mb-4 g-5">
                            <div class="col-md-6">
                            <label for="id-order" class="form-label">Id Order</label>
                            <select id="id-order" class="form-select">
                                <option value="" disabled selected>Id Order</option>
                                 <option value="1">001</option>
                                 <option value="2">002</option>
                                 </select>
                            </select>
                            </div>
                            <div class="col-md-6">
                            <label for="nama" class="form-label">Nama Klien</label>
                            <input type="text" id="nama" class="form-control" placeholder="Klien 1">
                            </div>
                        </div>
                        <div class="row mb-4 g-5">
                            <div class="col-md-6">
                            <label for="alamat" class="form-label">Alamat Klien</label>
                            <input type="text" id="alamat" class="form-control" placeholder="Jl Tukad Pakerisan" >
                            </div>
                            <div class="col-md-6">
                            <label for="no-whatsapp" class="form-label">No WhatsApp</label>
                            <input type="text" id="no-whatsapp" class="form-control" placeholder="081234567890" >
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
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