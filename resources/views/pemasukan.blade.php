@extends('layouts.app')

@section('title', 'Tambah Data Pemasukan')

@section('content')

     <!-- Back Button -->
     <div class="mb-4 ms-5">
        <a href="{{ route('tables.pemasukanKeuangan') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
            <i class='bx bx-arrow-back fs-2'></i>
        </a>
    </div>

    <!-- Main Content -->
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-sm rounded-0 p-5">
                <div class="card-body px-5">
                    <h4 class="text-center mb-5 fw-bold">
                        {{ isset($pemasukan) ? 'Edit Data Pemasukan' : 'Tambah Data Pemasukan' }}
                    </h4>

                    <!-- Form Section -->
                    <form action="{{ isset($pemasukan) ? route('pemasukan.update', $pemasukan->id) : route('pemasukan.store') }}" method="POST">
                        @csrf
                        @if(isset($pemasukan))
                            @method('PUT')
                        @endif

                        <!-- Row 1 -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="jenis_order" class="form-label">Jenis Order</label>
                                <select name="jenis_order" id="jenis_order" class="form-select @error('jenis_order') is-invalid @enderror">
                                    <option value="" disabled selected>Pilih Jenis Order</option>
                                    <option value="Proyek Arsitektur" {{ (isset($pemasukan) && $pemasukan->jenis_order == 'Proyek Arsitektur') || old('jenis_order') == 'Proyek Arsitektur' ? 'selected' : '' }}>
                                        Proyek Arsitektur
                                    </option>
                                    <option value="Furniture" {{ (isset($pemasukan) && $pemasukan->jenis_order == 'Furniture') || old('jenis_order') == 'Furniture' ? 'selected' : '' }}>
                                        Furniture
                                    </option>
                                </select>
                                @error('jenis_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="id_order" class="form-label">Id Order</label>
                                <input type="text" name="id_order" id="id_order" 
                                       class="form-control @error('id_order') is-invalid @enderror"
                                       value="{{ isset($pemasukan) ? $pemasukan->id_order : old('id_order') }}">
                                @error('id_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="tgl_transaksi" class="form-label">Tgl Transaksi</label>
                                <input type="date" name="tgl_transaksi" id="tgl_transaksi" 
                                       class="form-control @error('tgl_transaksi') is-invalid @enderror"
                                       value="{{ isset($pemasukan) ? $pemasukan->tgl_transaksi : old('tgl_transaksi') }}">
                                @error('tgl_transaksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" 
                                       class="form-control @error('jumlah') is-invalid @enderror"
                                       value="{{ isset($pemasukan) ? $pemasukan->jumlah : old('jumlah') }}">
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 3 -->
                        <div class="mb-4">
                            <label for="termin" class="form-label">Termin</label>
                            <input type="number" name="termin" id="termin" 
                                   class="form-control @error('termin') is-invalid @enderror"
                                   min="1" max="3"
                                   value="{{ isset($pemasukan) ? $pemasukan->termin : old('termin') }}">
                            @error('termin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Row 4 -->
                        <div class="mb-4">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" 
                                      class="form-control custom-textarea @error('keterangan') is-invalid @enderror" 
                                      rows="3">{{ isset($pemasukan) ? $pemasukan->keterangan : old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Save Button -->
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn-save">
                                {{ isset($pemasukan) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
