@extends('layouts.app')

@section('title', 'Tambah Data Pengeluaran')

@section('content')

        <!-- Back Button -->
        <div class="mb-4 ms-5">
        <a href="{{ route('tables.pengeluaranKeuangan') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
            <i class='bx bx-arrow-back fs-2'></i>
        </a>
    </div>

    <!-- Main Content -->
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-sm rounded-0 p-5">
                <div class="card-body px-5">
                    <h4 class="text-center mb-5 fw-bold">
                        {{ isset($pengeluaran) ? 'Edit Data Pengeluaran' : 'Tambah Data Pengeluaran' }}
                    </h4>

                    <!-- Form Section -->
                    <form action="{{ isset($pengeluaran) ? route('pengeluaran.update', $pengeluaran->id) : route('pengeluaran.store') }}" method="POST">
                        @csrf
                        @if(isset($pengeluaran))
                            @method('PUT')
                        @endif

                        <!-- Row 1 -->
                        <div class="row mb-4"> 
                            <div class="col-md-6">
                                <label for="tanggal_transaksi" class="form-label">Tgl Transaksi</label>
                                <input type="date" name="tanggal_transaksi" id="tanggal_transaksi"
                                       onfocus="this.showPicker()" 
                                       class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                                       value="{{ isset($pengeluaran) ? $pengeluaran->tanggal_transaksi : old('tanggal_transaksi') }}">
                                @error('tanggal_transaksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input type="text" name="nama_barang" id="nama_barang" 
                                       class="form-control @error('nama_barang') is-invalid @enderror"
                                       value="{{ isset($pengeluaran) ? $pengeluaran->nama_barang : old('nama_barang') }}">
                                @error('nama_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" 
                                       class="form-control @error('jumlah') is-invalid @enderror"
                                       value="{{ isset($pengeluaran) ? $pengeluaran->jumlah : old('jumlah') }}">
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="harga_satuan" class="form-label">Harga Satuan</label>
                                <input type="number" name="harga_satuan" id="harga_satuan" 
                                       class="form-control @error('harga_satuan') is-invalid @enderror"
                                       value="{{ isset($pengeluaran) ? $pengeluaran->harga_satuan : old('harga_satuan') }}">
                                @error('harga_satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 4 -->
                        <div class="mb-4">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" 
                                      class="form-control custom-textarea @error('keterangan') is-invalid @enderror" 
                                      rows="3">{{ isset($pengeluaran) ? $pengeluaran->keterangan : old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Save Button -->
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn-save">
                                {{ isset($pengeluaran) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
