@extends('layouts.app')

@section('title', 'editPengeluaran')

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
                        <h4 class="text-center mb-5 fw-bold">Ubah Data Pengeluaran</h4>
                        <form>
                        <div class="row mb-4">
                            <div class="col-md-6">
                            <label for="tgl-transaksi" class="form-label">Tgl Transaksi</label>
                            <input type="date" id="tgl-transaksi" class="form-control">
                            </div>
                            <div class="col-md-6">
                            <label for="namaBarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="namaBarang" placeholder="Kertas HVS">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" placeholder="5">
                            </div>
                            <div class="col-md-6">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" placeholder="Rp 5,000">
                            </div>
                        </div>
                        <div class="mb-4">
                        <label for="totalHarga" class="form-label">Total Harga</label>
                        <input type="number" class="form-control" id="totalHarga" placeholder="Rp 25,000">
                        </div>
                        <div class="mb-4">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea id="keterangan" class="form-control custom-textarea" rows="3" placeholder="Pembelian Kertas HVS"></textarea>
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