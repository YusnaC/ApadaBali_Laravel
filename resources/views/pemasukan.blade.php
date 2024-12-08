@extends('layouts.app')

@section('title', 'Tambah Data Pemasukan')

@section('content')
<section id="main-content" class="col-md-12 ms-md-7">
    <div class="pemasukan-content">
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
                        <h4 class="text-center mb-5 fw-bold">Tambah Data Pemasukan</h4>
                        <form>
                        <div class="row mb-4">
                            <div class="col-md-6">
                            <label for="jenis-order" class="form-label">Jenis Order</label>
                            <select id="jenis-order" class="form-select">
                                <option value="" disabled selected>Jenis Order</option>
                                <option value="1">Order 1</option>
                                <option value="2">Order 2</option>
                            </select>
                            </div>
                            <div class="col-md-6">
                            <label for="id-order" class="form-label">Id Order</label>
                            <select id="id-order" class="form-select">
                                <option value="" disabled selected>Id Order</option>
                                    <option value="1">001</option>
                                    <option value="2">002</option>
                                    </select>
                            </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                            <label for="tgl-transaksi" class="form-label">Tgl Transaksi</label>
                            <input type="date" id="tgl-transaksi" class="form-control">
                            </div>
                            <div class="col-md-6">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" >
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="termin" class="form-label">Termin</label>
                            <input type="number" id="termin" class="form-control" >
                        </div>
                        <div class="mb-4">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea id="keterangan" class="form-control custom-textarea" rows="3" ></textarea>
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